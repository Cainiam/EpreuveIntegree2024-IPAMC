<?php

namespace App\Livewire\Gerant;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Figure;
use App\Models\Tva;
use App\Models\Brand;
use App\Models\Scale;
use App\Models\Category;
use Livewire\WithFileUploads;



class FigureAdd extends Component
{
    use WithFileUploads;
    public $tvas, $brands, $scales, $categories;
    public $name, $description, $image_path, $price, $tva_id, $brand_id, $collection, $character_name, $series_title, $sculptor_name, $material, $height, $scale_id, $release_date, $stock_qty, $reference, $ean, $state, $category_id, $isVisible;

    public function mount()
    {
        $this->tvas = Tva::all();
        $this->brands = Brand::all();
        $this->scales = Scale::all();
        $this->categories = Category::all();
    }

    protected function rules()
    {
        return [
            'name' => 'required|unique:figures,name|string|min:2|max:255',
            'price' => 'required|numeric|min:0|max:999999', //Price should never go up to 999.999,00€ 
            'description' => 'nullable|string|min:2|max:2000',
            'image_path' => 'nullable|image|max:8192', //img up to 8mb
            'tva_id' => 'required|exists:tvas,id',
            'brand_id' => 'required|exists:brands,id',
            'collection' => 'required|string|min:2|max:30',
            'character_name' => 'required|string|min:2|max:100',
            'series_title' => 'required|string|min:2|max:50',
            'sculptor_name' => 'nullable|string|min:2|max:30',
            'material' => 'required|string|min:2|max:255',
            'height' => 'required|string|min:4|max:8',
            'scale_id' => 'required|exists:scales,id',
            'release_date' => 'required|string|min:10|max:10',
            'stock_qty' => 'required|integer|min:0|max:999999',
            'reference' => 'nullable|string|min:2|max:13',
            'ean' => 'nullable|string|min:13|max:13',
            'state' => 'nullable|string|min:2|max:15',
            'category_id' => 'required|exists:categories,id',
            'isVisible' => 'required',
        ];
    }

    //Personnal error messages :
    protected $messages = 
    [
        'name.required' => 'Le nom est requis.',
        'name.unique' => 'Ce nom est déjà utilisé.',
        'name.min' => 'Le nom doit faire au moins 2 caractères.',
        'name.max' => 'Le nom ne doit pas dépasser 255 caractères',
        'price.required' => 'Le prix est requis.',
        'price.numeric' => 'Le prix doit être un nombre compris entre 0 et 1000.',
        'price.min' => 'Le prix ne peut être inférieur à 0.00€.',
        'price.max' => 'Le prix ne peut pas dépasser 999999.00€',
        'description.min' => 'La description doit faire au moins 2 caractères',
        'description.max' => 'La description ne peut pas dépasser 2000 caractères.',
        'image_path.max' => 'L\'image ne peut pas faire plus de 8 MB.',
        'tva_id.required' => 'La tva est requise.',
        'tva_id.exists' => 'La tva sélectionnée n\'est pas valide.',
        'brand_id.required' => 'La marque est requise.',
        'brand_id.exists' => 'La marque sélectionnée n\'est pas valide.',
        'collection.required' => 'Veuillez indiquer une collection. Si pas de collection, mettre "aucune".',
        'collection.min' => 'Le nom de la collection doit au moins faire 2 caractères.',
        'collection.max' => 'Le nom de la collection ne doit pas dépasser 30 caractères.',
        'character_name.required' => 'Le nom du personnage est requis.',
        'character_name.min' => 'Le nom du personnage doit au moins faire 2 caractères.',
        'character_name.max' => 'Le nom du personnage ne doit pas dépasser 100 caractères.',
        'series_title.required' => 'Le nom de la série est requis.',
        'series_title.min' => 'Le nom de la série doit au moins faire 2 caractères.',
        'series_title.max' => 'Le nom de la série ne doit pas dépasser 50 caractères.',
        'sculptor_name.min' => 'Le nom du sculpteur doit au moins contenir 2 caractères.',
        'sculptor_name.max' => 'Le nom du sculpteur peut contenir au maximum 30 caractères.',
        'material.required' => 'Le matériel est requis.',
        'material.min' => 'Le nom du matériel doit au moins faire 2 caractères.',
        'material.max' => 'Le nom du matériel doit au maximum faire 255 caractères.',
        'height.required' => 'La taille est requises.',
        'height.min' => 'La taille doit au moins faire 4 caractères (x cm).',
        'scale_id.required' => 'L\'échelle est requise.',
        'scale_id.exists' => 'L\"échelle que vous avez choisi n\'est pas valide.',
        'release_date.required' => 'La date de sortie est requises',
        'release_date.min' => 'La date doit être écrite au format jj/mm/aaaa',
        'release_date.max' => 'La date doit être écrite au format jj/mm/aaaa',
        'stock_qty.required' => 'Le stock est requis',
        'stock_qty.integer' => 'Le stock doit être écrit avec un nombre entier.',
        'stock_qty.min' => 'Le stock doit être d\'au moins 0.',
        'stock_qty.max' => 'Le stock ne peut pas dépasser 999999.',
        'reference.min' => 'La référence doit au moins faire 2 caractères.',
        'reference.max' => 'La référence fait au maximum 13 caractères.',
        'ean.min' => 'L\'ean doit faire 13 chiffres minimum.',
        'ean.max' => 'L\'ean doit faire 13 chiffres maximum.',
        'state.min' => 'L\'état doit faire au moins 2 caractères.',
        'state.max' => 'L\'état peut faire maximum 13 caractères.',
        'category_id.required' => 'La catégorie est requises.',
        'category_id.exists' => 'La catégorie choisie n\'est pas valide.',
        'isVisible' => 'La visibilité est requise.',
    ];

    public function addFigure()
    {
        $this->validate();

        $img = $this->image_path ? $this->image_path->store('figures', 'public') : null;

        Figure::create([
                'name' => $this->name,
                'description' => $this->description,
                'image_path' => $img,
                'price' => $this->price,
                'tva_id' => $this->tva_id,
                'brand_id' => $this->brand_id,
                'collection' => $this->collection,
                'character_name' => $this->character_name,
                'series_title' => $this->series_title,
                'sculptor_name' => $this->sculptor_name,
                'material' => $this->material,
                'height' => $this->height,
                'scale_id' => $this->scale_id,
                'release_date' => $this->release_date,
                'stock_qty' => $this->stock_qty,
                'reference' => $this->reference,
                'ean' => $this->ean,
                'state' => $this->state,
                'category_id' => $this->category_id,
                'isVisible' => $this->isVisible,
        ]);

        session()->flash('message', 'Figurine créée avec succès.');
        return redirect()->route('gerantdashboard');
    }

    public function render()
    {
        return view('livewire.gerant.figure-add')->layout('layouts.app');
    }
}
