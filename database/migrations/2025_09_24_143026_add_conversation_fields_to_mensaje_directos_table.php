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
        Schema::table('mensaje_directos', function (Blueprint $table) {
            $table->string('conversation_id')->nullable()->after('id');
            $table->unsignedBigInteger('parent_message_id')->nullable()->after('conversation_id');
            $table->enum('sender_type', ['cliente', 'empleado'])->default('cliente')->after('parent_message_id');
            $table->unsignedBigInteger('sender_id')->nullable()->after('sender_type');
            $table->unsignedBigInteger('recipient_id')->nullable()->after('sender_id');
            $table->boolean('is_read')->default(false)->after('recipient_id');
            $table->timestamp('read_at')->nullable()->after('is_read');
            
            $table->index('conversation_id');
            $table->index('parent_message_id');
            $table->index(['sender_type', 'sender_id']);
            $table->index('recipient_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mensaje_directos', function (Blueprint $table) {
            $table->dropIndex(['conversation_id']);
            $table->dropIndex(['parent_message_id']);
            $table->dropIndex(['sender_type', 'sender_id']);
            $table->dropIndex(['recipient_id']);
            
            $table->dropColumn([
                'conversation_id',
                'parent_message_id',
                'sender_type',
                'sender_id',
                'recipient_id',
                'is_read',
                'read_at'
            ]);
        });
    }
};
