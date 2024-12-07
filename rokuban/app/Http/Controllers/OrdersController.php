<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\FiguresOrders;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;


class OrdersController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if($order->user_id !== Auth::id()) //Prevent user to go to order who are not them
        {
            abort(403, 'Accès interdit.');
        }

        $orderDetails = FiguresOrders::where('order_id', $order->id)
            ->join('figures', 'figures.id', '=', 'figuresorders.figure_id')
            ->select('figures.name', 'figuresorders.price_at_date', 'figuresorders.pricettc_at_date', 'figuresorders.quantity')
            ->get();
        return view('orders.show', compact('order', 'orderDetails'));
    }

    //Generate invoice user pdf
    public function downloadInvoice(Order $order)
    {
        if($order->user_id !== auth()->id())
        {
            abort('403', 'Accès interdit.');
        }

        $user = Auth::user();

        $orderDetails = FiguresOrders::where('order_id', $order->id)
            ->join('figures', 'figures.id', '=', 'figuresorders.figure_id')
            ->select('figures.name', 'figuresorders.price_at_date', 'figuresorders.pricettc_at_date', 'figuresorders.quantity')
            ->get();

        $pdf = Pdf::loadView('orders.invoice',
        [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'user' => $user,
        ]);

        return $pdf->download('Facture-Commande-' . $order->id . '.pdf');
    }

    //Generate admin invoice pdf
    public function downloadInvoiceGerant($id_order)
    {
        $order = Order::findOrFail($id_order);
        $user = User::findOrFail($order->user_id);

        $orderDetails = FiguresOrders::where('order_id', $order->id)
            ->join('figures', 'figures.id', '=', 'figuresorders.figure_id')
            ->select('figures.name', 'figuresorders.price_at_date', 'figuresorders.pricettc_at_date', 'figuresorders.quantity')
            ->get();

        $pdf = Pdf::loadView('orders.invoice',
        [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'user' => $user,
        ]);

        return $pdf->download('Facture-Commande-' . $order->id . '.pdf');
    }

    //Generate admin shipping label pdf
    public function generateLabel($id_order)
    {
        $order = Order::findOrFail($id_order);
        $user = User::findOrFail($order->user_id);  

        $pdf = Pdf::loadView('orders.shipping-label',
        [
            'order' => $order,
            'user' => $user,
        ]); 

        return $pdf->download('Etiquette_Commande_' . $order->id . '.pdf');
    }
}
