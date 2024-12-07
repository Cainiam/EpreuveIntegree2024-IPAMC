<?php

namespace App\Livewire\Gerant;

use Livewire\Component;
use App\Models\Order;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdated;

class OrderManager extends Component
{

    public $orderId, $status, $tracker, $isVisible; //What we want gerant can change on Order in DB

    public function mount($id)
    {
        $order = Order::findOrFail($id);
        $this->orderId = $order->id;
        $this->status = $order->status;
        $this->tracker = $order->tracker;
        $this->isVisible = $order->isVisible;
    }

    //Editing rules:
    protected function rules()
    {
        return [
            'status' => 'required|string',
            'tracker' => 'nullable|url',
            'isVisible' => 'required',
        ];
    }

    //Personnal error messages:
    protected $messages = 
    [
        'status.required' => 'Le status est requis !',
        'status.string' => 'Le status doit être une phrase !',
        'tracker.url' => 'Le tracker doit avoir le format d\'un lien! ',
        'isVisible.required' => 'La visibilité est requise !',
    ];


    public function updateOrder()
    {
        $this->validate();

        $order=Order::findOrFail($this->orderId);
        $order->update(
            [
                'status' => $this->status,
                'tracker' => $this->tracker,
                'isVisible' => $this->isVisible,
            ]
        );

        //Mailing notification of update :
        $user=User::findOrFail($order->user_id);
        Mail::to($user->email)->send(new OrderStatusUpdated($order, $user));
        //M
        
        session()->flash('message', 'Commande mise à jour.');

        return redirect()->route('gerantdashboard');
    }

    public function render()
    {
        return view('livewire.gerant.order-manager')->layout('layouts.app');
    }
}
