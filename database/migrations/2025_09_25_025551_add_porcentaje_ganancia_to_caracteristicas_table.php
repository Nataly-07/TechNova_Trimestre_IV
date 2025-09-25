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
        Schema::table('caracteristicas', function (Blueprint $table) {
            $table->decimal('Porcentaje_Ganancia', 5, 2)->default(0)->after('Precio_Compra');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('caracteristicas', function (Blueprint $table) {
            $table->dropColumn('Porcentaje_Ganancia');
        });
    }
};
