<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Figure;

class HomeController extends Controller
{
    public function index()
    {
        $carouselFigures = Figure::orderBy('created_at', 'desc')->take(3)->get();
        $gridFigures = Figure::orderBy('created_at', 'desc')->take(10)->get();
        return view('home', compact('carouselFigures', 'gridFigures'));
    }

    public function legal()
    {
        return view('legal');
    }

    public function retract()
    {
        return view('retract');
    }

    public function polconf()
    {
        return view('polconf');
    }
}
