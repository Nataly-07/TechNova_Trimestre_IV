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
        Schema::create('notificacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('titulo');
            $table->text('mensaje');
            $table->string('tipo'); // bienvenida, promocion, pedido, producto, pago, soporte, etc.
            $table->string('icono')->default('bx-bell');
            $table->boolean('leida')->default(false);
            $table->json('data_adicional')->nullable(); // Para datos extra como ID de pedido, etc.
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'leida']);
            $table->index(['user_id', 'fecha_creacion']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacions');
    }
};
