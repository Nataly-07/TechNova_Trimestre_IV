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
        Schema::create('producto', function (Blueprint $table) {
            $table->increments('ID_Producto');
            $table->string('Codigo', 50)->unique();
            $table->string('Nombre', 100);
            $table->string('Imagen', 255)->nullable();
            $table->integer('ID_Caracteristicas')->unsigned()->nullable();
            $table->integer('Stock')->unsigned();
            $table->foreign('ID_Caracteristicas')->references('ID_Caracteristicas')->on('caracteristicas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
