<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSucursalIsSelected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario tiene una sucursal en la sesión, o si está intentando seleccionar una,
        // o si está intentando cerrar sesión, déjalo continuar.
        if (
            session()->has('sucursal_id') ||
            $request->routeIs('seleccionar-sucursal') ||
            $request->routeIs('profile.show') // Permitir acceso al perfil para cerrar sesión
        ) {
            return $next($request);
        }

        // Si el usuario está autenticado pero no ha seleccionado sucursal,
        // redirigirlo a la página de selección.
        if (auth()->check()) {
            return redirect()->route('seleccionar-sucursal');
        }

        return $next($request);
    }
}
