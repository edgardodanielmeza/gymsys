<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $adminRole = Role::create(['name' => 'Administrador']);
        $receptionistRole = Role::create(['name' => 'Recepcionista']);

        // Here you can define permissions and assign them to roles if needed
        // For now, we are just creating the roles as per the initial request.
        // Example:
        // $permission = Permission::create(['name' => 'edit articles']);
        // $adminRole->givePermissionTo($permission);
    }
}
