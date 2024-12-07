<?php

namespace App\Livewire\Gerant;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Tva;

class TvaAdd extends Component
{
    public $name, $purcent;

    protected function rules()
    {
        return [
            'name' => 'required|unique:tvas,name|string|min:2|max:255', 
            'purcent' => 'required|integer|min:0|max:100', 
        ];
    }

    //Personnal error messages :
    protected $messages = 
    [
        'name.required' => 'Le nom est requis.',
        'name.unique' => 'Ce nom est déjà utilisé.',
        'name.min' => 'Le nom doit faire au moins 2 caractères.',
        'name.max' => 'Le nom ne doit pas dépasser 255 caractères',
        'purcent.required' => 'Le mot de passe est requis.',
        'purcent.integer' => 'Pas de chiffre après la virgule.',
        'purcent.min' => 'La description doit faire au moins 2 caractères',
        'purcent.max' => 'Le mot de passe ne peut pas dépasser 2000 caractères.',
    ];

    public function addTva()
    {
        $this->validate();

        Tva::create([
                'name' => $this->name,
                'purcent' => number_format($this->purcent / 100, 2),
        ]);

        session()->flash('message', 'TVA créée avec succès.');
        return redirect()->route('gerantdashboard');
    }

    public function render()
    {
        return view('livewire.gerant.tva-add')->layout('layouts.app');
    }
}
