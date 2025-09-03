<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        // Si el usuario está logueado, lo redirige al dashboard.
        // El middleware 'sucursal.selected' se encargará de redirigirlo
        // a la selección de sucursal si es necesario.
        return redirect()->route('dashboard');
    }

    // Si no está logueado, lo redirige a la página de login.
    return redirect()->route('login');
});

use App\Livewire\Auth\SeleccionarSucursal;

Route::get('/seleccionar-sucursal', SeleccionarSucursal::class)
    ->middleware(['auth'])
    ->name('seleccionar-sucursal');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'sucursal.selected', // Middleware para asegurar que se ha seleccionado una sucursal
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
