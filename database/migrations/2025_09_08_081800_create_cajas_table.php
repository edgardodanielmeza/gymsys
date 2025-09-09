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
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('sucursal_id')->constrained('sucursales');
            $table->decimal('monto_inicial', 10, 2);
            $table->decimal('monto_final_calculado', 10, 2)->nullable();
            $table->decimal('monto_final_real', 10, 2)->nullable();
            $table->decimal('diferencia', 10, 2)->nullable();
            $table->timestamp('fecha_cierre')->nullable();
            $table->text('notas')->nullable();
            $table->string('estado')->default('abierta'); // 'abierta', 'cerrada'
            $table->timestamps(); // fecha_apertura es created_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cajas');
    }
};
