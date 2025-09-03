<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Sucursal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the central sucursal to assign to the admin user
        $sucursalCentral = Sucursal::where('nombre', 'Sucursal Central')->first();

        $adminUser = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('gym123admin'),
                'last_sucursal_id' => $sucursalCentral ? $sucursalCentral->id : null,
            ]
        );

        $adminUser->assignRole('Administrador');
    }
}
