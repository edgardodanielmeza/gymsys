<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
