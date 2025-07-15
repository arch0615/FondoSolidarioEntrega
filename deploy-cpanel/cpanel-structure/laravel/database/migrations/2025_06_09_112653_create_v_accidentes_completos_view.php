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
        // Vista deshabilitada debido a restricciones de permisos del proveedor de la base de datos.
        // El usuario 'sql5783875' no tiene el privilegio 'CREATE VIEW'.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No es necesario revertir una vista que no se creó.
    }
};
