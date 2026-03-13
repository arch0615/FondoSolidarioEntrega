<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('salidas_educativas', function (Blueprint $table) {
            $table->date('fecha_hasta')->nullable()->after('fecha_salida');
            // Widen docentes_acompañantes to allow more detailed info
            $table->string('docentes_acompanantes', 1000)->change();
        });
    }

    public function down(): void
    {
        Schema::table('salidas_educativas', function (Blueprint $table) {
            $table->dropColumn('fecha_hasta');
            $table->string('docentes_acompanantes', 500)->change();
        });
    }
};
