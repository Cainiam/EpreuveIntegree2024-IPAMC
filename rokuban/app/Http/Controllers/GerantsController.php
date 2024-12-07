<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GerantsController extends Controller
{
    public function index()
    {
        return view('gerant.home');
    }

    public function dashboard()
    {
        return view('gerant.dashboard');
    }
}
