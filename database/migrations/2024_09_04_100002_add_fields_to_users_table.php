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
        Schema::table('users', function (Blueprint $table) {
            // Columna para saber si el usuario puede usar el sistema
            $table->boolean('activo')->default(true)->after('email');

            // Columna para la sucursal principal del usuario, puede ser nulo para un admin global
            $table->foreignId('sucursal_id')->nullable()->constrained('sucursales')->after('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Se asegura de que la llave foránea exista antes de intentar borrarla
            if (Schema::hasColumn('users', 'sucursal_id')) {
                $table->dropForeign(['sucursal_id']);
                $table->dropColumn('sucursal_id');
            }
            if (Schema::hasColumn('users', 'activo')) {
                $table->dropColumn('activo');
            }
        });
    }
};
