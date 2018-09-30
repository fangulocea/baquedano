<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->check()) {


            if(Auth::user()->roles[0]->name=='Propietario'){
                return redirect('/home/propietario');
            }

            if(Auth::user()->roles[0]->name=='Arrendatario'){
                return redirect('/home/arrendatario');
            }


            return redirect('/home');
        }

        return $next($request);
    }
}
