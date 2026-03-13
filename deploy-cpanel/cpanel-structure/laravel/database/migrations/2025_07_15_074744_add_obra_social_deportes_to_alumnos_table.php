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
        Schema::table('alumnos', function (Blueprint $table) {
            if (!Schema::hasColumn('alumnos', 'obra_social')) {
                $table->text('obra_social')->nullable()->after('activo');
            }
            if (!Schema::hasColumn('alumnos', 'deportes')) {
                $table->text('deportes')->nullable()->after('obra_social');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropColumn(['obra_social', 'deportes']);
        });
    }
};
