<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->integer('id_usuario', true);
            $table->string('email', 100)->unique('uk_email');
            $table->string('password');
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->integer('id_rol')->index('idx_rol');
            $table->integer('id_escuela')->nullable()->index('idx_escuela');
            $table->dateTime('fecha_registro')->nullable();
            $table->boolean('email_verificado')->nullable()->default(false);
            $table->string('token_verificacion')->nullable();
            $table->boolean('activo')->nullable()->default(true)->index('idx_activo');
        });

        // Establecer contraseña por defecto para todos los usuarios existentes
        DB::table('usuarios')->whereNotNull('password')->update(['password' => Hash::make('password123')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
