<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Figure;
use App\Models\Tva;
use App\Models\Shipping;
use Illuminate\Support\Facades\Mail;
use App\Models\FiguresOrders;
use App\Mail\OrderDetailsMail;

class Checkout extends Component
{
    public $cardNumber; //fake card number for fake payment here
    public $cartItems;
    public $totalPrice = 0; //price with vat
    public $selectedShipping;
    public $shippings = [];
    public $shippingCost;
    public $totalPriceWithShipping;
    protected $queryString = ['selectedShipping'];

    public function mount()
    {
        $this->cartItems = session()->get('cart', []);
        $this->shippings = Shipping::all();
        $this->selectedShipping = null;
        $this->shippingCost = 0;
        $this->totalPriceWithShipping = 0;
        $this->calculateTotal();
    }

    public function calculateTotal() //Additionning all items price
    {
        $this->totalPrice = array_reduce($this->cartItems, 
        function ($total, $item)
        {
            return $total + ($item['price'] * $item['quantity']);
        },
        0);
    }

    public function updatedSelectedShipping($shippingId)
    {
        $shipping = Shipping::findOrFail($shippingId);
        $this->shippingCost = $shipping ? $shipping->price : 0;
        $this->totalPriceWithShipping = $this->totalPrice + $this->shippingCost;
    }

    public function submitPayment()
    {
        $totalPriceHT = 0; //Price without tax

        $this->validate(
            [ //Validation
                'cardNumber' => 'required|digits:17',
                'selectedShipping' => 'required|exists:shippings,id',
            ],
            [ //Personnal error message
                'cardNumber.required' => 'Veuillez entrer un numéro de carte de payement !',
                'cardNumber.digits' => 'Le numéro de carte doit contenir exactement 17 chiffres !',
                'selectedShipping.required' => 'Veuillez choisir un transporteur dans la liste !',
                'selectedShipping.exists' => 'Le transporteur que vous avez choisi n\'est pas valide !',
            ]
        );

        $user = Auth::user(); //Checking if user is correctly logged in, technically it's impossible to go on this page not logged but "safeguard"
        if(!$user)
        {
            session()->flash('error', 'Vous devez être connecté pour pouvoir réaliser cet achat !');
            return redirect()->route('login');
        }

        foreach($this->cartItems as $figureId => $item) //Calculate HT price for order
        {
            $figure = Figure::findOrFail($figureId);
            $figure_price = $figure->price;
            $tva_rate = Tva::findOrFail($figure->tva_id)->purcent;
            $figure_priceHT = $figure_price / (1.0 + $tva_rate);
            $totalPriceHT += $figure_priceHT * $item['quantity'];
        }

        $order = Order::create([ //Adding order in table orders
            'user_id' => $user->id,
            'status' => 'Payement validé',
            'price' => number_format($totalPriceHT, 2), //Without vat
            'pricettc' => $this->totalPrice, //With vat
            'shipping_at_date' => $this->shippingCost, //Price of shipping at order date
            'paypal_status' => null, //No paypal since (fake) debit card payment
            'shipping_id' => $this->selectedShipping,
            'tracker' => null,
            'isVisible' => 1,
        ]);

        //Adding to table FiguresOrders for each figures in the order
        foreach($this->cartItems as $figureId => $item)
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

        session()->forget('cart');
        session()->flash('message', 'Paiement réussi!');
        return redirect()->route('order.success', ['orderId' => $order->id]);
    }

    public function render()
    {
        return view('livewire.checkout')->layout('layouts.app');
    }
}
