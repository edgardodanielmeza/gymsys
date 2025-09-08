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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caja_id')->constrained('cajas');
            $table->foreignId('miembro_id')->nullable()->constrained('miembros')->onDelete('set null');
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('total', 10, 2);
            $table->string('metodo_pago'); // 'efectivo', 'tarjeta', etc.
            $table->timestamps(); // created_at será la fecha de la venta
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
