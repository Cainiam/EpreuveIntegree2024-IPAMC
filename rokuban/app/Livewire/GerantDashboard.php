<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Figure;
use App\Models\Order;
use App\Models\Scale;
use App\Models\Category;
use App\Models\Tva;
use App\Models\Shippingcompany;
use App\Models\Shipping;
use App\Models\Brand;
use App\Models\PaypalTransaction;

class GerantDashboard extends Component
{

    use WithPagination;

    public $selectedCrud = 'users'; //users by default
    protected $users, $figures, $orders, $scales, $categories, $tvas, $shippingcompanies, $shippings, $brands, $paypaltransactions; //crud possibility

    /** for delete: */
    public $toDeleteId;
    public $confirmingDeletion = false;

    /** for isVisible: */
    public $toChangeVisibleId;
    public $confirmingVisible = false;

    /** for deactivation user */
    public $toDeactiveID;
    public $confirmingDeactivation = false;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        if($this->selectedCrud == 'users')
        {
            $this->users = User::all()->sortBy('id');
        }
        else if($this->selectedCrud == 'figures') 
        {
            $this->figures = Figure::all()->sortBy('id')->map(function ($figure){
                $figure->tva_purcent = optional(Tva::find($figure->tva_id))->purcent;
                $figure->brand_name = optional(Brand::find($figure->brand_id))->name;
                $figure->scale_name = optional(Scale::find($figure->scale_id))->name;
                $figure->category_name = optional(Category::find($figure->category_id))->name;
                return $figure;
            });
        }
        else if($this->selectedCrud == 'orders')
        {
            $this->orders = Order::all()->sortBy('id')->map(function ($order){
                $order->client_first_name = optional(User::find($order->user_id))->first_name;
                $order->client_last_name = optional(User::find($order->user_id))->last_name;
                $order->transport_name = optional(Shipping::find($order->shipping_id))->name;
                return $order;
            });
        }
        else if($this->selectedCrud == 'scales')
        {
            $this->scales = Scale::all()->sortBy('id');
        }
        else if($this->selectedCrud == 'categories')
        {
            $this->categories = Category::all()->sortBy('id');
        }
        else if($this->selectedCrud == 'tvas')
        {
            $this->tvas = Tva::all()->sortBy('id');
        }
        else if($this->selectedCrud == 'shippingcompanies')
        {
            $this->shippingcompanies = Shippingcompany::all();
        }
        else if($this->selectedCrud == 'shippings')
        {
            $this->shippings = Shipping::all()->sortBy('id')->map(function ($shipping){
                $shipping->shippingcompany_name = optional(Shippingcompany::find($shipping->shippingcompany_id))->name;
                return $shipping;
            });
        }
        else if($this->selectedCrud == 'brands')
        {
            $this->brands = Brand::all()->sortBy('id');
        }
        else if($this->selectedCrud == 'paypaltransactions')
        {
            $this->paypaltransactions = PaypalTransaction::all()->sortBy('id');
        }
    }

    public function updatedSelectedCrud()
    {
        $this->loadData();
    }

    public function confirmDeletion($id)
    {
        $this->toDeleteId = $id;
        $this->confirmingDeletion = true;
    }

    public function confirmChangingVisible($id)
    {
        $this->toChangeVisibleId = $id;
        $this->confirmingVisible = true;
    }

    public function confirmDeactiveUser($id)
    {
        $this->toDeactiveID = $id;
        $this->confirmingDeactivation = true;
    }

    public function deleteById()
    {
        DB::table($this->selectedCrud)->where('id', $this->toDeleteId)->delete();
        $this->toDeleteId = null;
        $this->confirmingDeletion = false;
        session()->flash('message', 'L\'entrée a été supprimée de la base de données.');
    }

    public function changingVisibleById()
    {
        $currentVisible = DB::table($this->selectedCrud)->where('id', $this->toChangeVisibleId)->value('isVisible');
        $newVisible;
        if($currentVisible)
        {
            $newVisible = 0;
        }
        else
        {
            $newVisible = 1;
        }
        DB::table($this->selectedCrud)->where('id', $this->toChangeVisibleId)->update(['isVisible' => $newVisible]);
        $this->toChangeVisibleId = null;
        $this->confirmingVisible = false;
        session()->flash('message', 'La visibilité a été modifiée dans la base de données.');
    }

    public function deactiveUserById()
    {
        $currentActive = DB::table($this->selectedCrud)->where('id', $this->toDeactiveID)->value('isActive');
        $newActive;
        if($currentActive)
        {
            $newActive = 0;
        }
        else
        {
            $newActive = 1;
        }
        DB::table($this->selectedCrud)->where('id', $this->toDeactiveID)->update(['isActive' => $newActive]);
        $this->toDeactiveID = null;
        $this->confirmingDeactivation = false;
        session()->flash('message', 'L\'utilisateur a été modifié dans la base de données.');
    }

    /** 
     * Custom paginator for used collections, not best solutions but works in our case since we don't use a lot of queries, better to use paginator without collection for best method
     * Done following instructions froms Laravel 11 documentations https://laravel.com/docs/11.x/pagination#manually-creating-a-paginator 
     * & inspired by https://gist.github.com/simonhamp/549e8821946e2c40a617c85d2cf5af5e (but we don't add it to service provider, only for this particular class)
     */
    protected function paginateCollection(Collection $items, $perPage = 10)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $items->slice(($currentPage - 1) * $perPage,$perPage)->values();
        return new LengthAwarePaginator(
            $currentItems,
            $items->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    public function render()
    {
        if($this->selectedCrud == 'users')
        {
            $this->loadData();
            $users = $this->paginateCollection($this->users, 10);
            return view('livewire.gerant-dashboard', compact('users'));
        }
        elseif($this->selectedCrud == 'figures')
        {
            $this->loadData();
            $figures = $this->paginateCollection($this->figures, 10);
            return view('livewire.gerant-dashboard', compact('figures'));
        }
        elseif($this->selectedCrud == 'orders')
        {
            $this->loadData();
            $orders = $this->paginateCollection($this->orders, 10);
            return view('livewire.gerant-dashboard', compact('orders'));
        }
        elseif($this->selectedCrud == 'scales')
        {
            $this->loadData();
            $scales = $this->paginateCollection($this->scales, 10);
            return view('livewire.gerant-dashboard', compact('scales'));
        }
        elseif($this->selectedCrud == 'categories')
        {
            $this->loadData();
            $categories = $this->paginateCollection($this->categories, 10);
            return view('livewire.gerant-dashboard', compact('categories'));
        }
        elseif($this->selectedCrud == 'tvas')
        {
            $this->loadData();
            $tvas = $this->paginateCollection($this->tvas, 10);
            return view('livewire.gerant-dashboard', compact('tvas'));
        }
        elseif($this->selectedCrud == 'shippingcompanies')
        {
            $this->loadData();
            $shippingcompanies = $this->paginateCollection($this->shippingcompanies, 10);
            return view('livewire.gerant-dashboard', compact('shippingcompanies'));
        }
        elseif($this->selectedCrud == 'shippings')
        {
            $this->loadData();
            $shippings = $this->paginateCollection($this->shippings, 10);
            return view('livewire.gerant-dashboard', compact('shippings'));
        }
        elseif($this->selectedCrud == 'brands')
        {
            $this->loadData();
            $brands = $this->paginateCollection($this->brands, 10);
            return view('livewire.gerant-dashboard', compact('brands'));
        }
        elseif($this->selectedCrud == 'paypaltransactions')
        {
            $this->loadData();
            $paypaltransactions = $this->paginateCollection($this->paypaltransactions ,10);
            return view('livewire.gerant-dashboard', compact('paypaltransactions'));
        }
        else
        {
            $users = collect();
            $figures = collect();
            $orders = collect();
            $scales = collect(); 
            $categories = collect();
            $tvas = collect();
            $shippingcompanies = collect();
            $shippings = collect();
            $brands = collect();
        }
        return view('livewire.gerant-dashboard');
    }
}
