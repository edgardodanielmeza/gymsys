<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\SucursalManager;
use App\Livewire\Admin\TipoMembresiaManager;
use App\Livewire\Admin\PagoManager;
use App\Livewire\Auth\SelectBranch;
use App\Livewire\CheckinManager;
use App\Livewire\MiembroManager;
use App\Livewire\MiembroProfile;

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

    // Rutas Principales (Recepcionista y Admin)
    Route::middleware(['role:Admin|Recepcionista'])->group(function () {
        Route::get('/check-in', CheckinManager::class)->name('check-in');
        Route::get('/miembros', MiembroManager::class)->name('miembros.index');
        Route::get('/miembros/{miembro}', MiembroProfile::class)->name('miembros.show');
    });

    // Rutas de Administración
    Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/sucursales', SucursalManager::class)->name('sucursales.index');
        Route::get('/tipos-membresia', TipoMembresiaManager::class)->name('tipos-membresia.index');
        Route::get('/pagos', PagoManager::class)->name('pagos.index');
        // Aquí se pueden agregar más rutas de admin en el futuro
    });
});
