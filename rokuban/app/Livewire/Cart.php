<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Figure;

class Cart extends Component
{
    public $cartItems = [];

    public function mount()
    {
        $this->cartItems = session()->get('cart', []);
    }

    public function increaseQuantity($figureId)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$figureId]))
        {
            $figure = Figure::findOrFail($figureId);
            $newqty = $cart[$figureId]['quantity']+1;
            if($newqty > $figure->stock_qty) //Checking if requested quantity still < stock
            {
                session()->flash('message', "Vous ne pouvez plus ajouté plus de {$figure->name} à votre panier, la quantité en stock est dépassée : {$figure->stockqty}.");
                return;
            }
            $cart[$figureId]['quantity']++;
            session()->put('cart', $cart);
            $this->cartItems = $cart;
        }
    }

    public function decreaseQuantity($figureId)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$figureId]) && $cart[$figureId]['quantity'] > 1) //If more than 1, figure_qty-1
        {
            $cart[$figureId]['quantity']--;
            session()->put('cart', $cart);
            $this->cartItems = $cart;
        }
        else //if only 1, delete figure
        {
            unset($cart[$figureId]);
            session()->put('cart', $cart);
            $this->cartItems = $cart;
        }
    }

    public function removeItem($figureId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$figureId]);
        session()->put('cart', $cart);
        $this->cartItems = $cart;
    }

    public function clearCart()
    {
        session()->forget('cart');
        $this->cartItems = [];
    }

    public function render()
    {
        return view('livewire.cart')->layout('layouts.app');
    }
}
