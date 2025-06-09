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
        Schema::table('documentos_institucionales', function (Blueprint $table) {
            $table->foreign(['id_escuela'], 'documentos_institucionales_ibfk_1')->references(['id_escuela'])->on('escuelas')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_usuario_carga'], 'documentos_institucionales_ibfk_2')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_tipo_documento'], 'fk_documentos_tipo')->references(['id_tipo_documento'])->on('cat_tipos_documentos')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documentos_institucionales', function (Blueprint $table) {
            $table->dropForeign('documentos_institucionales_ibfk_1');
            $table->dropForeign('documentos_institucionales_ibfk_2');
            $table->dropForeign('fk_documentos_tipo');
        });
    }
};
