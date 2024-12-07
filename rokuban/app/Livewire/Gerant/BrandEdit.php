<?php

namespace App\Livewire\Gerant;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Brand;

class BrandEdit extends Component
{
    public $brandId, $name, $description;

    public function mount($id)
    {
        $brand = Brand::findOrFail($id);
        $this->brandId = $brand->id;
        $this->name = $brand->name;
        $this->description = $brand->description;
    }
    
    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255', Rule::unique('brands')->ignore($this->brandId)],
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

    public function updateBrand()
    {
        $this->validate();

        $brand = Brand::findOrFail($this->scaleId);


        $brand->update(
            [
                'name' => $this->name,
                'description' => $this->description,
            ]
        );

        session()->flash('message', 'Marque mise à jour avec succès.');
        return redirect()->route('gerantdashboard');
    }

    public function render()
    {
        return view('livewire.gerant.brand-edit')->layout('layouts.app');
    }
}
