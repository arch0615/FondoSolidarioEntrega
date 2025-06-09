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
        Schema::table('solicitudes_info_auditor', function (Blueprint $table) {
            $table->foreign(['id_estado_solicitud'], 'fk_solicitudes_estado')->references(['id_estado_solicitud'])->on('cat_estados_solicitudes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_reintegro'], 'solicitudes_info_auditor_ibfk_1')->references(['id_reintegro'])->on('reintegros')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_auditor'], 'solicitudes_info_auditor_ibfk_2')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_usuario_responde'], 'solicitudes_info_auditor_ibfk_3')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitudes_info_auditor', function (Blueprint $table) {
            $table->dropForeign('fk_solicitudes_estado');
            $table->dropForeign('solicitudes_info_auditor_ibfk_1');
            $table->dropForeign('solicitudes_info_auditor_ibfk_2');
            $table->dropForeign('solicitudes_info_auditor_ibfk_3');
        });
    }
};
