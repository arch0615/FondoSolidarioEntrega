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
        Schema::create('accidente_alumnos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_accidente');
            $table->integer('id_alumno')->index('id_alumno');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->unique(['id_accidente', 'id_alumno'], 'unique_accidente_alumno');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accidente_alumnos');
    }
};
