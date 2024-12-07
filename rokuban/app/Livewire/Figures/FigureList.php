<?php

namespace App\Livewire\Figures;

use Livewire\Component;
use App\Models\Figure;
use App\Models\Tva;
use Livewire\WithPagination;

class FigureList extends Component
{
    use withPagination;
    public $search = '';
    public $sort = 'recent';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
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
        //Search
        $query = Figure::where('name', 'like', '%' . $this->search . '%');
        //Sorting
        if($this->sort === 'price_asc')
        {
            $query->orderBy('price', 'asc');
        }
        elseif($this->sort === 'price_desc')
        {
            $query->orderBy('price', 'desc');
        }
        elseif($this->sort === 'oldest')
        {
            $query->orderBy('created_at', 'asc');
        }
        else //Default, most recent
        {
            $query->orderBy('created_at', 'desc');
        }
        //Paginate
        $figures = $query->paginate(12);

        return view('livewire.figures.figure-list', compact('figures'))->layout('layouts.app');
    }
}
