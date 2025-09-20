<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('mediodepago')) {
            Schema::table('mediodepago', function (Blueprint $table) {
                if (!Schema::hasColumn('mediodepago', 'Fecha_De_Compra')) {
                    $table->dateTime('Fecha_De_Compra')->nullable();
                }
                if (!Schema::hasColumn('mediodepago', 'Tiempo_De_Entrega')) {
                    $table->dateTime('Tiempo_De_Entrega')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('mediodepago')) {
            Schema::table('mediodepago', function (Blueprint $table) {
                if (Schema::hasColumn('mediodepago', 'Fecha_De_Compra')) {
                    $table->dropColumn('Fecha_De_Compra');
                }
                if (Schema::hasColumn('mediodepago', 'Tiempo_De_Entrega')) {
                    $table->dropColumn('Tiempo_De_Entrega');
                }
            });
        }
    }
};


