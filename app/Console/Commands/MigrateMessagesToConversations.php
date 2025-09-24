<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MensajeDirecto;

class MigrateMessagesToConversations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages:migrate-conversations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing messages to the new conversation system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Migrating existing messages to conversation system...');
        
        $messages = MensajeDirecto::whereNull('conversation_id')->get();
        
        if ($messages->isEmpty()) {
            $this->info('No messages to migrate.');
            return;
        }
        
        $bar = $this->output->createProgressBar($messages->count());
        $bar->start();
        
        foreach ($messages as $message) {
            // Crear conversation_id único para cada mensaje
            $conversationId = 'conv_' . uniqid();
            
            // Actualizar el mensaje con los nuevos campos
            $message->update([
                'conversation_id' => $conversationId,
                'sender_type' => 'cliente',
                'sender_id' => $message->user_id,
                'recipient_id' => null,
                'is_read' => $message->estado === 'leido' || $message->estado === 'respondido',
                'read_at' => ($message->estado === 'leido' || $message->estado === 'respondido') ? now() : null
            ]);
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info("Successfully migrated {$messages->count()} messages to conversation system.");
    }
}
