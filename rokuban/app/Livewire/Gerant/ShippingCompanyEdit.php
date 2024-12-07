<?php

namespace App\Livewire\Gerant;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Shippingcompany;

class ShippingCompanyEdit extends Component
{
    public $shippingcompanyId, $name, $description;

    public function mount($id)
    {
        $shippingcompany = Shippingcompany::findOrFail($id);
        $this->shippingcompanyId = $shippingcompany->id;
        $this->name = $shippingcompany->name;
        $this->description = $shippingcompany->description;
    }
    
    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255', Rule::unique('shippingcompanies')->ignore($this->shippingcompanyId)],
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

    public function updateShippingcompany()
    {
        $this->validate();

        $shippingcompany = Shippingcompany::findOrFail($this->shippingcompanyId);

        $shippingcompany->update(
            [
                'name' => $this->name,
                'description' => $this->description,
            ]
        );

        session()->flash('message', 'Société mise à jour avec succès.');
        return redirect()->route('gerantdashboard');
    }

    public function render()
    {
        return view('livewire.gerant.shipping-company-edit')->layout('layouts.app');
    }
}
