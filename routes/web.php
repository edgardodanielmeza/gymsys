<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\SelectSucursal;
use App\Http\Livewire\Sucursales\SucursalManager;

Route::get('/', function () {
    return view('welcome');
});

// Route for branch selection
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/seleccionar-sucursal', SelectSucursal::class)->name('sucursal.select');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'sucursal.selected', // Custom middleware to ensure a branch is selected
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // CRUD Sucursales
    Route::get('/sucursales', SucursalManager::class)->name('sucursales.index');
});
