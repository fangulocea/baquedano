<?php

namespace Illuminate\Foundation\Auth;

use Auth;

trait RedirectsUsers
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {

        if(Auth::user()->roles[0]->name=='Propietario'){
           return property_exists($this, 'redirectToPropietario') ? $this->redirectToPropietario : '/home/propietario';
        }

        if(Auth::user()->roles[0]->name=='Arrendatario'){
           return property_exists($this, 'redirectToArrendatario') ? $this->redirectToArrendatario : '/home/arrendatario';
        }

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
}
