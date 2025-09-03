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
            $table->timestamp('fecha_ingreso');
            $table->timestamp('fecha_salida')->nullable();
            $table->timestamps();

            $table->index(['miembro_id', 'fecha_ingreso']);
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
