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
        Schema::create('mensaje_directos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('asunto');
            $table->text('mensaje');
            $table->string('prioridad')->default('normal'); // baja, normal, alta, urgente
            $table->string('estado')->default('enviado'); // enviado, leido, respondido, cerrado
            $table->unsignedBigInteger('empleado_id')->nullable(); // ID del empleado asignado
            $table->text('respuesta')->nullable();
            $table->timestamp('fecha_respuesta')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('empleado_id')->references('id')->on('users')->onDelete('set null');
            $table->index(['user_id', 'estado']);
            $table->index(['empleado_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensaje_directos');
    }
};
