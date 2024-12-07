<?php

namespace App\Livewire\Gerant;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Shipping;
use App\Models\Shippingcompany;

class ShippingAdd extends Component
{
    public $shippingcompany_id, $name, $description, $price, $isVisible, $shippingcompanies;

    public function mount()
    {
        $this->shippingcompanies = Shippingcompany::all();
    }

    protected function rules()
    {
        return [
            'shippingcompany_id' => 'required|exists:shippingcompanies,id',
            'name' => 'required|unique:scales,name|string|min:2|max:255',
            'price' => 'required|numeric|min:0|max:1000', //Shipping should never go up to 1000.00€ 
            'description' => 'required|string|min:2|max:2000', 
            'isVisible' => 'required',
        ];
    }

    //Personnal error messages :
    protected $messages = 
    [
        'shippingcompany_id.required' => 'La compagnie est requise.',
        'shippingcompany_id.exists' => 'La compagnie doit exister dans la base de données',
        'name.required' => 'Le nom est requis.',
        'name.unique' => 'Ce nom est déjà utilisé.',
        'name.min' => 'Le nom doit faire au moins 2 caractères.',
        'name.max' => 'Le nom ne doit pas dépasser 255 caractères',
        'price.required' => 'Le prix est requis.',
        'price.numeric' => 'Le prix doit être un nombre compris entre 0 et 1000.',
        'price.min' => 'Le prix ne peut être inférieur à 0.00€.',
        'price.max' => 'Le prix ne peut pas dépasser 1000.00€',
        'description.required' => 'La description est requise.',
        'description.min' => 'La description doit faire au moins 2 caractères',
        'description.max' => 'La description ne peut pas dépasser 2000 caractères.',
        'isVisible' => 'La visibilité est requise.',
    ];

    public function addShipping()
    {
        $this->validate();

        Shipping::create([
                'shippingcompany_id' => $this->shippingcompany_id,
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'isVisible' => $this->isVisible,
        ]);

        session()->flash('message', 'Moyen de livraison créé avec succès.');
        return redirect()->route('gerantdashboard');
    }

    public function render()
    {
        return view('livewire.gerant.shipping-add')->layout('layouts.app');
    }
}
