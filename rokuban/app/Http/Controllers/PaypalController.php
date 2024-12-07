<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
//done following the instructions from https://srmklive.github.io/laravel-paypal/docs.html
use Srmklive\PayPal\Services\PayPal as PayPalClient;
//Models used for adding order and paypal transaction:
use App\Models\PaypalTransaction;
use App\Models\Figure;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\Tva;
use Illuminate\Support\Facades\Mail;
use App\Models\FiguresOrders;
use App\Mail\OrderDetailsMail;


class PaypalController extends Controller
{
    public function show()
    {
        return view('paypal-checkout');
    }

    public function payment(Request $request)
    {
        if(!$request->has('shipping_id')) //safeguard checking if shipping is selected
        {
            return redirect()->route('paypal.checkout')->with('error', 'Veuillez sélectionner un mode de livrasion !');
        }

        $cartItems = session()->get('cart', []);

        if(!$cartItems) //Verification but shoudln't trigger with our components but better to safeguard
        {
            return redirect()->route('paypal.checkout')->with('error', 'Votre panier est vide, impossible de payer !');
        }

        $PaypalPrice = 0;
        foreach($cartItems as $figureId => $item)
        {
            $figure = Figure::findOrFail($figureId);
            if($figure->stock_qty < $item['quantity']) //Verification but shoudln't trigger with our components but better to safeguard
            {
                return redirect()->route('paypal.checkout')->with('error', 'Votre panier contient au moins une figurine qui n\'a pas suffisamment de stock !');
            }
            $PaypalPrice += $item['price'] * $item ['quantity'];
        }

        //Shipping added
        $shipping = Shipping::findOrFail($request->shipping_id);
        $PaypalPrice += $shipping->price;
        Session::put('selectedshipping_id', $shipping->id);

        //PayPal Infos for request :
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        //Creating order which is send to paypal
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => 
            [
                "return_url" => route('paypal_success'),
                "cancel_url" => route('paypal_cancel')
            ],
            "purchase_units" => 
            [
                [
                    "amount" => 
                    [
                        "currency_code" => "EUR",
                        "value" => $PaypalPrice,
                    ]
                ]
            ]
        ]);
        //dd($response); //uncomment to check response

        //Checking if payment succedded or not from paypal's response
        if(isset($response['id']) && $response['id'] != null)
        {
            foreach($response['links'] as $link)
            {
                if($link['rel'] === 'approve')
                {
                    return redirect()->away($link['href']);
                }
            }
        }
        else
        {
            return redirect()->route('paypal_cancel');
        }
    }

    public function success(Request $request)
    {
        //PayPal Infos
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);
        //dd($response); //uncomment to check response

        if(isset($response['status']) && $response['status'] == 'COMPLETED')
        {
            $cartItems = session()->get('cart', []);

            if(!$cartItems) //Verification but shoudln't trigger with our components but better to safeguard
            {
                return redirect()->route('paypal.checkout')->with('error', 'Votre panier est vide, impossible de payer !');
            }

            //Order and pivot table Figure_Order + Mailing :
            $order = $this->createOrder($cartItems, $response);
            if(!$order instanceof Order)
            {
                return redirect()->route('paypal.checkout')->with('error', 'Un problème est survenu lors de la commande !');
            }
            //Paypal_Transaction :
            $this->createPTransaction($order->id, $response);
            session()->forget('cart');
            return redirect()->route('order.success', ['orderId' => $order->id]);
        }
        else
        {
            return redirect()->route('paypal_cancel');
        }
        return redirect()->route('paypal_cancel'); //If we don't go out from the if, problem so cancel
    }

    public function cancel()
    {
        return redirect()->route('paypal.checkout')->with('error', 'Le paiement PayPal a été annulé !');
    }

    //Done using modified function already done in the Checkout livewire component
    private function createOrder($cartItems, $paypalResponse)
    {
        $totalPriceHT = 0; //Price without tax
        $totalPrice = 0;
        $selectedShippingId = Session::get('selectedshipping_id');
        $selectedShippingInfo = Shipping::findOrFail($selectedShippingId);
        $shippingCost = $selectedShippingInfo->price;
        $user = Auth::user(); //Checking if user is correctly logged in, technically it's impossible to go on this page not logged but "safeguard"
        if(!$user)
        {
            session()->flash('error', 'Vous devez être connecté pour pouvoir réaliser cet achat !');
            return redirect()->route('login');
        }

        foreach($cartItems as $figureId => $item) //Calculate HT price for order
        {
            $figure = Figure::findOrFail($figureId);
            $figure_price = $figure->price;
            $tva_rate = Tva::findOrFail($figure->tva_id)->purcent;
            $figure_priceHT = $figure_price / (1.0 + $tva_rate);
            $totalPriceHT += $figure_priceHT * $item['quantity'];
            $totalPrice += $figure_price * $item['quantity'];
        }

        $order = Order::create([ //Adding order in table orders
            'user_id' => $user->id,
            'status' => 'Payement Paypal validé',
            'price' => number_format($totalPriceHT, 2), //Without vat
            'pricettc' => number_format($totalPrice, 2), //With vat
            'shipping_at_date' => number_format($shippingCost, 2), //Price of shipping at order date
            'paypal_status' => $paypalResponse['status'],
            'shipping_id' => $selectedShippingId,
            'tracker' => null,
            'isVisible' => 1,
        ]);

        //Adding to table FiguresOrders for each figures in the order
        foreach($cartItems as $figureId => $item)
        {
            $figure = Figure::findOrFail($figureId);

            //Updating quantity in stock
            if($figure && $figure->stock_qty >= $item['quantity'])
            {
                $figure->decrement('stock_qty', $item['quantity']);
            }
            else //In case of not enought quantity but shouldn't be possible
            {
                session()->flash('message', "La figurine {$item['name']} n'a pas assez de stock : {$figure->stock_qty}.");
                return redirect()->route('cart');
            }

            $priceTtcAtDate = $item['price'];
            $tva = Tva::FindOrFail($figure->tva_id)->purcent;
            $priceAtDate = number_format($item['price'] / (1.0+$tva), 2);

            $order->figures()->attach($figureId, [
                'price_at_date' => $priceAtDate,
                'pricettc_at_date' => $priceTtcAtDate,
                'quantity' => $item['quantity'],
            ]);
        }

        //Mailing (we retake informations for each figure from pivot table)
        $orderDetails = FiguresOrders::where('order_id', $order->id)
        ->join('figures', 'figures.id', '=', 'figuresorders.figure_id')
        ->select('figures.name', 'figuresorders.price_at_date', 'figuresorders.pricettc_at_date', 'figuresorders.quantity')
        ->get();
        Mail::to(auth()->user()->email)->send(new OrderDetailsMail($order, $orderDetails));

        return $order;
    }

    private function createPTransaction($orderId, $paypalResponse)
    {
        PaypalTransaction::create(
            [
                'paypal_transactions_id' => $paypalResponse['id'],
                'paypal_transactions_status' => $paypalResponse['status'],
                'paypal_client_mail' => $paypalResponse['payer']['email_address'],
                'paypal_pricewtax' => $paypalResponse['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
                'paypal_currency_code' => $paypalResponse['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'],
                'order_id' => $orderId,
            ]
        );
    }
}
