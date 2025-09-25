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
        Schema::table('producto', function (Blueprint $table) {
            // Cambiar el campo Imagen de VARCHAR(255) a TEXT para permitir URLs más largas
            $table->text('Imagen')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('producto', function (Blueprint $table) {
            // Revertir el campo Imagen de TEXT a VARCHAR(255)
            $table->string('Imagen', 255)->nullable()->change();
        });
    }
};
