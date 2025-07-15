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
        Schema::table('beneficiarios_svo', function (Blueprint $table) {
            $table->foreign(['id_empleado'], 'beneficiarios_svo_ibfk_1')->references(['id_empleado'])->on('empleados')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_parentesco'], 'fk_beneficiarios_parentesco')->references(['id_parentesco'])->on('cat_parentescos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_escuela'], 'fk_beneficiario_escuela')->references(['id_escuela'])->on('escuelas')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiarios_svo', function (Blueprint $table) {
            $table->dropForeign('beneficiarios_svo_ibfk_1');
            $table->dropForeign('fk_beneficiarios_parentesco');
            $table->dropForeign('fk_beneficiario_escuela');
        });
    }
};
