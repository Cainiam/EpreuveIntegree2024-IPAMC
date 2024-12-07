<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class CartSummary extends Component
{
    public $cart = [];
    public $totalPrice = 0;
    public $totalItems = 0;

    public function mount()
    {
        $this->loadCart();
    }

    #[On('cartUpdated')] 
    public function loadCart()
    {
        $this->cart = session('cart', []);
        $this->totalItems = collect($this->cart)->sum('quantity');
        $this->totalPrice = collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function render()
    {
        return view('livewire.cart-summary');
    }
}
