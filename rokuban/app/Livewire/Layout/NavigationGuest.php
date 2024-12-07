<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NavigationGuest extends Component
{
    public function render()
    {
        return view('livewire.layout.navigation-guest');
    }
}
