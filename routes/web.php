<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\SucursalManager;
use App\Livewire\Auth\SelectBranch;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para la selección de sucursal, requiere que el usuario esté autenticado
Route::middleware(['auth:sanctum'])->get('/seleccionar-sucursal', SelectBranch::class)->name('auth.select-branch');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas de Administración
    Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/sucursales', SucursalManager::class)->name('sucursales.index');
        // Aquí se pueden agregar más rutas de admin en el futuro
    });
});
