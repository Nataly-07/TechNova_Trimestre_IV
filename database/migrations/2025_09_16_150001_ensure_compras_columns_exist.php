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
        // First, let's check if the table exists and what columns it has
        if (Schema::hasTable('compras')) {
            // Try to add columns without checking if they exist first
            try {
                DB::statement('ALTER TABLE compras ADD COLUMN ID_Usuario INT NULL AFTER ID_Compras');
            } catch (Exception $e) {
                // Column might already exist, ignore error
            }
            
            try {
                DB::statement('ALTER TABLE compras ADD COLUMN ID_MedioDePago INT NULL AFTER ID_Usuario');
            } catch (Exception $e) {
                // Column might already exist, ignore error
            }
            
            try {
                DB::statement('ALTER TABLE compras ADD COLUMN Total DECIMAL(10,2) NULL AFTER ID_MedioDePago');
            } catch (Exception $e) {
                // Column might already exist, ignore error
            }
            
            try {
                DB::statement('ALTER TABLE compras ADD COLUMN Estado VARCHAR(50) NULL AFTER Total');
            } catch (Exception $e) {
                // Column might already exist, ignore error
            }
            
            try {
                DB::statement('ALTER TABLE compras ADD COLUMN Fecha_Compra DATETIME NULL AFTER Estado');
            } catch (Exception $e) {
                // Column might already exist, ignore error
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
                DB::statement('ALTER TABLE compras DROP COLUMN ID_Usuario');
            } catch (Exception $e) {
                // Column might not exist, ignore error
            }
            
            try {
                DB::statement('ALTER TABLE compras DROP COLUMN ID_MedioDePago');
            } catch (Exception $e) {
                // Column might not exist, ignore error
            }
            
            try {
                DB::statement('ALTER TABLE compras DROP COLUMN Total');
            } catch (Exception $e) {
                // Column might not exist, ignore error
            }
            
            try {
                DB::statement('ALTER TABLE compras DROP COLUMN Estado');
            } catch (Exception $e) {
                // Column might not exist, ignore error
            }
            
            try {
                DB::statement('ALTER TABLE compras DROP COLUMN Fecha_Compra');
            } catch (Exception $e) {
                // Column might not exist, ignore error
            }
        }
    }
};


