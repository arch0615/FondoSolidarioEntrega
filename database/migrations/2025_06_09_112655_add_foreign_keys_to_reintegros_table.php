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
        Schema::table('reintegros', function (Blueprint $table) {
            $table->foreign(['id_estado_reintegro'], 'fk_reintegros_estado')->references(['id_estado_reintegro'])->on('cat_estados_reintegros')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_tipo_gasto'], 'fk_reintegros_tipo_gasto')->references(['id_tipo_gasto'])->on('cat_tipos_gastos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_accidente'], 'reintegros_ibfk_1')->references(['id_accidente'])->on('accidentes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_usuario_solicita'], 'reintegros_ibfk_2')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_medico_auditor'], 'reintegros_ibfk_3')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reintegros', function (Blueprint $table) {
            $table->dropForeign('fk_reintegros_estado');
            $table->dropForeign('fk_reintegros_tipo_gasto');
            $table->dropForeign('reintegros_ibfk_1');
            $table->dropForeign('reintegros_ibfk_2');
            $table->dropForeign('reintegros_ibfk_3');
        });
    }
};
