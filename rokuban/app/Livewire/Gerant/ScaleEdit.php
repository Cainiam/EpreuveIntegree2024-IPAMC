<?php

namespace App\Livewire\Gerant;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Scale;

class ScaleEdit extends Component
{
    public $scaleId, $name, $description;

    public function mount($id)
    {
        $scale = Scale::findOrFail($id);
        $this->scaleId = $scale->id;
        $this->name = $scale->name;
        $this->description = $scale->description;
    }
    
    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255', Rule::unique('scales')->ignore($this->scaleId)],
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

    public function updateScale()
    {
        $this->validate();

        $scale = Scale::findOrFail($this->scaleId);

        $scale->update(
            [
                'name' => $this->name,
                'description' => $this->description,
            ]
        );

        session()->flash('message', 'Echelle mise à jour avec succès.');
        return redirect()->route('gerantdashboard');
    }

    public function render()
    {
        return view('livewire.gerant.scale-edit')->layout('layouts.app');
    }
}
