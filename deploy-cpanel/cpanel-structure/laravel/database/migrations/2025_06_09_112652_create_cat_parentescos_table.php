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
        Schema::create('cat_parentescos', function (Blueprint $table) {
            $table->integer('id_parentesco', true);
            $table->string('nombre_parentesco', 50)->unique('uk_nombre_parentesco');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_parentescos');
    }
};
