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
        if (Schema::hasTable('compras')) {
            Schema::table('compras', function (Blueprint $table) {
                // Add customer purchase fields
                if (!Schema::hasColumn('compras', 'ID_Usuario')) {
                    $table->integer('ID_Usuario')->nullable()->after('ID_Compras');
                }
                if (!Schema::hasColumn('compras', 'ID_MedioDePago')) {
                    $table->integer('ID_MedioDePago')->nullable()->after('ID_Usuario');
                }
                if (!Schema::hasColumn('compras', 'Total')) {
                    $table->decimal('Total', 10, 2)->nullable()->after('ID_MedioDePago');
                }
                if (!Schema::hasColumn('compras', 'Estado')) {
                    $table->string('Estado', 50)->nullable()->after('Total');
                }
                if (!Schema::hasColumn('compras', 'Fecha_Compra')) {
                    $table->datetime('Fecha_Compra')->nullable()->after('Estado');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('compras')) {
            Schema::table('compras', function (Blueprint $table) {
                if (Schema::hasColumn('compras', 'ID_Usuario')) {
                    $table->dropColumn('ID_Usuario');
                }
                if (Schema::hasColumn('compras', 'ID_MedioDePago')) {
                    $table->dropColumn('ID_MedioDePago');
                }
                if (Schema::hasColumn('compras', 'Total')) {
                    $table->dropColumn('Total');
                }
                if (Schema::hasColumn('compras', 'Estado')) {
                    $table->dropColumn('Estado');
                }
                if (Schema::hasColumn('compras', 'Fecha_Compra')) {
                    $table->dropColumn('Fecha_Compra');
                }
            });
        }
    }
};


