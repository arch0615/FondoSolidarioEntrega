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
        Schema::table('prestadores', function (Blueprint $table) {
            $table->foreign(['id_tipo_prestador'], 'fk_prestadores_tipo')->references(['id_tipo_prestador'])->on('cat_tipos_prestadores')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestadores', function (Blueprint $table) {
            $table->dropForeign('fk_prestadores_tipo');
        });
    }
};
