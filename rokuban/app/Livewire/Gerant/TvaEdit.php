<?php

namespace App\Livewire\Gerant;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Tva;

class TvaEdit extends Component
{
    public $tvaId, $name, $purcent;

    public function mount($id)
    {
        $tva = Tva::findOrFail($id);
        $this->tvaId = $tva->id;
        $this->name = $tva->name;
        $this->purcent = $tva->purcent;
    }
    
    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255', Rule::unique('tvas')->ignore($this->tvaId)],
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
        'purcent.required' => 'La valeur est requise.',
        'purcent.integer' => 'Pas de chiffre après la virgule.',
        'purcent.min' => 'La valeur est au minimum de 0%',
        'purcent.max' => 'Le valeur est au maximum de 100%.',
    ];

    public function updateTva()
    {
        $this->validate();

        $scale = Scale::findOrFail($this->scaleId);

        $scale->update(
            [
                'name' => $this->name,
                'purcent' => number_format($this->purcent / 100, 2),
            ]
        );

        session()->flash('message', 'TVA mise à jour avec succès.');
        return redirect()->route('gerantdashboard');
    }

    public function render()
    {
        return view('livewire.gerant.tva-edit')->layout('layouts.app');
    }
}
