<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // 1. Verificar si el usuario está activo
        if (!Auth::user()->activo) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->withErrors(['email' => 'Tu cuenta está inactiva. Contacta al administrador.']);
        }

        // 2. Verificar si se necesita seleccionar sucursal
        if (!session()->has('selected_sucursal_id')) {
            return redirect()->route('auth.select-branch');
        }

        // 3. Redirigir al dashboard
        return redirect()->intended(config('fortify.home'));
    }
}
