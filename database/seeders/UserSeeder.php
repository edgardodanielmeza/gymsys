<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Sucursal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->where('email', 'admin@admin.com')->delete();

        // Create Admin User
        $admin = User::create([
            'name' => 'Administrador General',
            'email' => 'admin@admin.com',
            'password' => Hash::make('gym123admin'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Attach all sucursales to the admin user
        $sucursales = Sucursal::all();
        if ($sucursales->isNotEmpty()) {
            $admin->sucursales()->attach($sucursales->pluck('id'));
        }
    }
}
