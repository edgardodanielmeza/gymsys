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
        Schema::create('tipos_membresia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->comment('Nombre del tipo de membresía (ej. Mensual, Anual)');
            $table->text('descripcion')->nullable()->comment('Descripción del plan');
            $table->decimal('precio', 10, 2)->comment('Precio del plan');
            $table->integer('duracion_dias')->comment('Duración del plan en días');
            $table->boolean('activo')->default(true)->comment('Si el plan está disponible para la venta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_membresia');
    }
};
