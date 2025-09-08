<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\SucursalManager;
use App\Livewire\Admin\TipoMembresiaManager;
use App\Livewire\Admin\PagoManager;
use App\Livewire\Admin\SettingsManager;
use App\Livewire\Admin\UserManager;
use App\Livewire\Admin\ProductManager;
use App\Livewire\Admin\CajaManager;
use App\Livewire\Admin\PointOfSale;
use App\Livewire\Auth\SelectBranch;
use App\Livewire\CheckinManager;
use App\Livewire\DashboardManager;
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
    Route::get('/dashboard', DashboardManager::class)->name('dashboard');

    // Rutas Principales (Recepcionista y Admin)
    Route::middleware(['role:Admin|Recepcionista'])->group(function () {
        Route::get('/check-in', CheckinManager::class)->name('check-in');
        Route::get('/miembros', MiembroManager::class)->name('miembros.index');
        Route::get('/miembros/{miembro}', MiembroProfile::class)->name('miembros.show');
        Route::get('/pos', PointOfSale::class)->name('pos');
    });

    // Rutas de Administración
    Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/sucursales', SucursalManager::class)->name('sucursales.index');
        Route::get('/tipos-membresia', TipoMembresiaManager::class)->name('tipos-membresia.index');
        Route::get('/pagos', PagoManager::class)->name('pagos.index');
        Route::get('/users', UserManager::class)->name('users.index');
        Route::get('/settings', SettingsManager::class)->name('settings');
        Route::get('/productos', ProductManager::class)->name('productos.index');
        Route::get('/caja', CajaManager::class)->name('caja.manager');
    });
});
