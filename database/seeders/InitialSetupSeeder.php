<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Sucursal;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class InitialSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear Roles
        $adminRole = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Recepcionista']);
        $this->command->info('Roles Creados');

        // Crear Sucursales
        $sucursalCentral = Sucursal::create([
            'nombre' => 'Sucursal Central',
            'direccion' => 'Av. Principal 123',
            'telefono' => '0981123456',
            'email' => 'central@gymsys.com',
            'capacidad_maxima' => 150,
            'horario_operacion' => 'Lunes a Viernes de 6:00 a 22:00. Sábados de 8:00 a 14:00.',
        ]);

        Sucursal::create([
            'nombre' => 'Sucursal Secundaria',
            'direccion' => 'Calle Secundaria 456',
            'telefono' => '0981654321',
            'email' => 'sucursal2@gymsys.com',
            'capacidad_maxima' => 100,
            'horario_operacion' => 'Lunes a Viernes de 7:00 a 21:00.',
        ]);
        $this->command->info('Sucursales Creadas');

        // Crear Usuario Administrador
        $adminUser = User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('gym123admin'),
            'activo' => true,
            'sucursal_id' => $sucursalCentral->id,
        ]);

        // Asignar rol de Admin al usuario
        $adminUser->assignRole($adminRole);

        $this->command->info('Usuario Administrador Creado y Rol Asignado');
    }
}
