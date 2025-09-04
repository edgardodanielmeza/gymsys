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

            $table->foreignId('membresia_id')
                  ->constrained('membresias')
                  ->onDelete('cascade');

            $table->foreignId('sucursal_id')
                  ->comment('Sucursal donde se recibió el pago')
                  ->constrained('sucursales');

            $table->decimal('monto', 10, 2);
            $table->string('metodo_pago', 50)->comment('Efectivo, Tarjeta, Transferencia, etc.');
            $table->dateTime('fecha_pago');
            $table->text('notas')->nullable();

            // Could also link to the user (recepcionista) who processed the payment
            // $table->foreignId('user_id')->nullable()->constrained('users');

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
