
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
        Schema::create('caracteristicas', function (Blueprint $table) {
            $table->increments('ID_Caracteristicas');
            $table->string('Categoria', 100);
            $table->string('Color', 100);
            $table->text('Descripcion')->nullable();
            $table->decimal('Precio_Compra', 10, 2);
            $table->decimal('Precio_Venta', 10, 2);
            $table->string('Marca', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caracteristicas');
    }
};