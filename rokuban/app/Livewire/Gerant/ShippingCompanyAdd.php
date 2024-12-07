<?php

namespace App\Livewire\Gerant;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Shippingcompany;

class ShippingCompanyAdd extends Component
{
    public $name, $description;

    protected function rules()
    {
        return [
            'name' => 'required|unique:shippingcompanies,name|string|min:2|max:255', 
            'description' => 'required|string|min:2|max:2000', 
        ];
    }

    //Personnal error messages :
    protected $messages = 
    [
        'name.required' => 'Le nom est requis.',
        'name.unique' => 'Ce nom est déjà utilisé.',
        'name.min' => 'Le nom doit faire au moins 2 caractères.',
        'name.max' => 'Le nom ne doit pas dépasser 255 caractères',
        'description.required' => 'La description est requise.',
        'description.min' => 'La description doit faire au moins 2 caractères',
        'description.max' => 'La description ne peut pas dépasser 2000 caractères.',
    ];

    public function addShippingcompany()
    {
        $this->validate();

        Shippingcompany::create([
                'name' => $this->name,
                'description' => $this->description,
        ]);

        session()->flash('message', 'Société créée avec succès.');
        return redirect()->route('gerantdashboard');
    }

    public function render()
    {
        return view('livewire.gerant.shipping-company-add')->layout('layouts.app');
    }
}