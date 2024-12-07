<?php

namespace App\Livewire\Figures;

use Livewire\Component;
use App\Models\Figure;
use App\Models\Tva;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Scale;


class FigureShow extends Component
{

    public $figure;
    public $category;
    public $scale;
    public $brand;

    public function mount($id)
    {
        $this->figure = Figure::findOrFail($id);
        $this->category = Category::findOrFail($this->figure->category_id);
        $this->scale = Scale::findOrFail($this->figure->scale_id);
        $this->brand = Brand::findOrFail($this->figure->brand_id);
    }

    /** Cart management */
    public function addToCart($figureId)
    {
        $figure = Figure::findOrFail($figureId);
        $tva = Tva::findOrFail($figure->tva_id)->purcent;
        $cart = session()->get('cart', []);

        if (isset($cart[$figureId])) //If 1 already, qt+1
        {
            $newqty = $cart[$figureId]['quantity']+1;
            if($newqty > $figure->stock_qty) //Checking if requested quantity still < stock
            {
                session()->flash('message', "Vous ne pouvez plus ajouté plus de {$figure->name} à votre panier, la quantité en stock est dépassée.");
                return;
            }
            $cart[$figureId]['quantity']++;
        }
        else // If not, new fig in cart
        {
            $cart[$figureId] =
            [
                "name" => $figure->name,
                "price" => $figure->price,
                "quantity" => 1,
            ];
        }

        session()->put('cart', $cart);
        session()->flash('message', 'Figurine ajoutée au panier.');
        $this->dispatch('cartUpdated');
    }
    /** End cart management */

    public function render()
    {
        return view('livewire.figures.figure-show')->layout('layouts.app');
    }
}
