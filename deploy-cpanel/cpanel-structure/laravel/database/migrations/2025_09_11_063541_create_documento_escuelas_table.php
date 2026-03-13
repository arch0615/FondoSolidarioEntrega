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
        Schema::create('documento_escuelas', function (Blueprint $table) {
            $table->integer('id_documento_escuela', true);
            $table->integer('id_documento')->index('idx_documento');
            $table->integer('id_escuela')->index('idx_escuela');
            $table->timestamps();

            // Índice único compuesto para evitar duplicados
            $table->unique(['id_documento', 'id_escuela'], 'uk_documento_escuela');

            // Foreign keys
            $table->foreign(['id_documento'], 'documento_escuelas_ibfk_1')
                  ->references(['id_documento'])
                  ->on('documentos_institucionales')
                  ->onUpdate('restrict')
                  ->onDelete('cascade');

            $table->foreign(['id_escuela'], 'documento_escuelas_ibfk_2')
                  ->references(['id_escuela'])
                  ->on('escuelas')
                  ->onUpdate('restrict')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documento_escuelas');
    }
};
