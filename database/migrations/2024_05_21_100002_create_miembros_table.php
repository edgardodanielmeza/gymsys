<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('miembros', function (Blueprint $table) {
            $table->id();
            $table->string('documento_identidad', 20)->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email')->unique();
            $table->string('direccion')->nullable();
            $table->string('foto_path')->nullable();

            $table->foreignId('sucursal_registro_id')
                  ->comment('Sucursal donde se registró el miembro')
                  ->constrained('sucursales');

            // For a future client portal, a member can be linked to a user account
            $table->foreignId('user_id')
                  ->nullable()
                  ->comment('Link to the users table for portal access')
                  ->constrained('users')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miembros');
    }
};
