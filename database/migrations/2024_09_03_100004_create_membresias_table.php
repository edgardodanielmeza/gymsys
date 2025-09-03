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
        Schema::create('membresias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('miembro_id')->constrained('miembros')->onDelete('cascade');
            $table->foreignId('tipo_membresia_id')->constrained('tipo_membresias');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('estado', 20)->default('activa'); // Ej: activa, vencida, suspendida
            $table->timestamps();

            $table->index('estado');
            $table->index('fecha_fin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membresias');
    }
};
