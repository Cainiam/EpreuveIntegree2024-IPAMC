<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class GerantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //If log in
        if(Auth::check())
        {
            //if gerant
            if(Auth::user()->role_id == 1)
            {
                return $next($request);
            }
            else //not gerant
            {
                return redirect('/');
            }
        }
        else //not logged
        {
            return redirect('/login');
        }
    }
}
