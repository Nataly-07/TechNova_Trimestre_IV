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
        Schema::create('mensaje_empleados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id'); // ID del empleado que recibe el mensaje
            $table->unsignedBigInteger('remitente_id'); // ID del remitente (admin, otro empleado, sistema)
            $table->string('tipo_remitente')->default('admin'); // admin, empleado, sistema
            $table->string('asunto');
            $table->text('mensaje');
            $table->string('tipo')->default('general'); // general, notificacion, instruccion, urgencia
            $table->string('prioridad')->default('normal'); // baja, normal, alta, urgente
            $table->boolean('leido')->default(false);
            $table->timestamp('fecha_leido')->nullable();
            $table->json('data_adicional')->nullable(); // Para datos extra como enlaces, referencias, etc.
            $table->timestamps();
            
            $table->foreign('empleado_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('remitente_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['empleado_id', 'leido']);
            $table->index(['empleado_id', 'created_at']);
            $table->index(['tipo', 'prioridad']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensaje_empleados');
    }
};
