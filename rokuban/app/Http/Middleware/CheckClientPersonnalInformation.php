<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckClientPersonnalInformation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //We check if user has had its address in the DB
        if(Auth::check() && (empty(Auth::user()->first_name) || empty(Auth::user()->last_name) || empty(Auth::user()->address_line_1) || empty(Auth::user()->postal_code) || empty(Auth::user()->city)))
        {
            return redirect()->route('profile')->with('error', 'Veuillez compléter votre adresse de livraison correctement avant de passer au paiement !'); //If not, we send him to
        }
        return $next($request);
    }
}
