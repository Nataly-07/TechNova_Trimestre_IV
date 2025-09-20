<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('compras')) {
            try {
                // Make ID_Proveedor nullable to support customer purchases
                DB::statement('ALTER TABLE compras MODIFY COLUMN ID_Proveedor INT NULL');
            } catch (Exception $e) {
                // Handle any errors gracefully
                \Log::info('Error modifying ID_Proveedor column: ' . $e->getMessage());
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('compras')) {
            try {
                // Revert ID_Proveedor back to NOT NULL
                DB::statement('ALTER TABLE compras MODIFY COLUMN ID_Proveedor INT NOT NULL');
            } catch (Exception $e) {
                // Handle any errors gracefully
                \Log::info('Error reverting ID_Proveedor column: ' . $e->getMessage());
            }
        }
    }
};


