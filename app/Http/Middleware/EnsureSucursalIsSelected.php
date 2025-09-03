<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Allow unauthenticated users to pass
        if (!Auth::check()) {
            return $next($request);
        }

        // Allow access to the selection page, the logic to set the sucursal, and logout
        if ($request->routeIs('sucursal.select') || $request->routeIs('logout')) {
            return $next($request);
        }

        // If user is authenticated but has not selected a sucursal, redirect them
        if (!session()->has('selected_sucursal_id')) {
            return redirect()->route('sucursal.select');
        }

        return $next($request);
    }
}
