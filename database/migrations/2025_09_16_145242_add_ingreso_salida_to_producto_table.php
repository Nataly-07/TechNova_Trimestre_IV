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
            if (!Schema::hasColumn('producto', 'Ingreso')) {
                $table->integer('Ingreso')->default(0)->after('Stock');
            }
            if (!Schema::hasColumn('producto', 'Salida')) {
                $table->integer('Salida')->default(0)->after('Ingreso');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('producto', function (Blueprint $table) {
            if (Schema::hasColumn('producto', 'Ingreso')) {
                $table->dropColumn('Ingreso');
            }
            if (Schema::hasColumn('producto', 'Salida')) {
                $table->dropColumn('Salida');
            }
        });
    }
};
