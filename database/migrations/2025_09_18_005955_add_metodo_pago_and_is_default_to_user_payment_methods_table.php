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
        Schema::table('user_payment_methods', function (Blueprint $table) {
            $table->string('metodo_pago')->nullable()->after('user_id');
            $table->boolean('is_default')->default(false)->after('metodo_pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_payment_methods', function (Blueprint $table) {
            $table->dropColumn(['metodo_pago', 'is_default']);
        });
    }
};