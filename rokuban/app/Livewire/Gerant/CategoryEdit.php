<?php

namespace App\Livewire\Gerant;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Category;

class CategoryEdit extends Component
{
    public $categoryId, $name, $description;

    public function mount($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
    }
    
    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255', Rule::unique('categories')->ignore($this->categoryId)],
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

    public function updateCategory()
    {
        $this->validate();

        $category = Category::findOrFail($this->categoryId);

        $category->update(
            [
                'name' => $this->name,
                'description' => $this->description,
            ]
        );

        session()->flash('message', 'Catégorie mise à jour avec succès.');
        return redirect()->route('gerantdashboard');
    }

    public function render()
    {
        return view('livewire.gerant.category-edit')->layout('layouts.app');
    }
}
