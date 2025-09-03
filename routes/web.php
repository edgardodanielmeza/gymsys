<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\SelectSucursal;
use App\Http\Livewire\Sucursales\SucursalManager;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // This route is for selecting the branch, so it can't have the 'sucursal.selected' middleware
    Route::get('/seleccionar-sucursal', SelectSucursal::class)->name('sucursal.select');

    // These routes require a branch to be selected
    Route::middleware(['sucursal.selected'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        // CRUD Sucursales
        Route::get('/sucursales', SucursalManager::class)->name('sucursales.index');
    });
});
