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
        Schema::create('sucursal_user', function (Blueprint $table) {
            $table->comment('Tabla pivote para relacionar usuarios y sucursales');

            $table->foreignId('user_id')
                  ->comment('ID del usuario')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('sucursal_id')
                  ->comment('ID de la sucursal')
                  ->constrained('sucursales')
                  ->onDelete('cascade');

            $table->primary(['user_id', 'sucursal_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursal_user');
    }
};
