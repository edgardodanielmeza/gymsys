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
        Schema::create('sucursales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('direccion');
            $table->string('telefono', 20);
            $table->string('email')->nullable();
            $table->unsignedInteger('capacidad_maxima')->default(0);
            $table->text('horario_operacion')->nullable();
            $table->boolean('activa')->default(true)->comment('Estado de la sucursal (Activa/Inactiva)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursales');
    }
};
