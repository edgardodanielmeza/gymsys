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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('miembro_id')->constrained('miembros')->onDelete('cascade');
            $table->foreignId('sucursal_id')->constrained('sucursales');
            $table->foreignId('user_id')->nullable()->constrained('users')->comment('Empleado que registró la entrada');
            $table->timestamp('fecha_hora_entrada')->useCurrent();
            $table->timestamps(); // Correct way to handle created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
