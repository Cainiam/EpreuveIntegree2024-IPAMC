<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Shipping;

class PaypalCheckout extends Component
{
    public $cartItems;
    public $totalPrice = 0;
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

    public function render()
    {
        return view('livewire.paypal-checkout')->layout('layouts.app');
    }
}
