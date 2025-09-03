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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membresia_id')->constrained('membresias')->onDelete('cascade');
            $table->foreignId('user_id')->comment('Usuario que registra el pago')->nullable()->constrained('users');
            $table->foreignId('sucursal_id')->comment('Sucursal donde se realiza el pago')->constrained('sucursales');
            $table->decimal('monto', 10, 2);
            $table->string('metodo_pago', 50); // Ej: efectivo, tarjeta_credito, transferencia
            $table->timestamp('fecha_pago');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
