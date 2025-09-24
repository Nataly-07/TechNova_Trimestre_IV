<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\MensajeDirecto;

class CrearMensajesEjemplo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mensajes:crear-ejemplo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear mensajes directos de ejemplo para usuarios existentes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creando mensajes directos de ejemplo...');
        
        // Obtener usuarios existentes (no admin)
        $users = User::where('role', '!=', 'admin')->take(3)->get();
        
        if ($users->isEmpty()) {
            $this->error('No se encontraron usuarios para crear mensajes de ejemplo');
            return;
        }
        
        foreach ($users as $user) {
            $this->line("Creando mensajes para: {$user->name}");
            
            // Crear mensajes de ejemplo
            MensajeDirecto::create([
                'user_id' => $user->id,
                'asunto' => 'Consulta sobre envío de pedido',
                'mensaje' => 'Hola, tengo una consulta sobre el estado de mi pedido #12345. ¿Podrían confirmarme cuándo será enviado?',
                'prioridad' => 'normal',
                'estado' => 'enviado'
            ]);
            
            MensajeDirecto::create([
                'user_id' => $user->id,
                'asunto' => 'Problema con método de pago',
                'mensaje' => 'Estoy teniendo problemas para procesar el pago con mi tarjeta de crédito. El sistema me indica que hay un error pero no especifica cuál.',
                'prioridad' => 'alta',
                'estado' => 'leido'
            ]);
            
            MensajeDirecto::create([
                'user_id' => $user->id,
                'asunto' => 'Solicitud de reembolso',
                'mensaje' => 'Necesito solicitar un reembolso por un producto que llegó defectuoso. Adjunto fotos del problema.',
                'prioridad' => 'urgente',
                'estado' => 'respondido',
                'respuesta' => 'Hola, hemos revisado tu solicitud y procederemos con el reembolso en un plazo de 3-5 días hábiles. Te enviaremos un correo de confirmación.',
                'fecha_respuesta' => now()
            ]);
            
            $this->line("  ✓ 3 mensajes creados");
        }
        
        $this->info('¡Mensajes de ejemplo creados exitosamente!');
    }
}
