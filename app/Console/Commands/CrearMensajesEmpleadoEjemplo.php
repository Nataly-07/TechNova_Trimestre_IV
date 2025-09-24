<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\MensajeEmpleado;

class CrearMensajesEmpleadoEjemplo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mensajes-empleado:crear-ejemplo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear mensajes de ejemplo para empleados';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creando mensajes de ejemplo para empleados...');
        
        // Obtener empleados existentes
        $empleados = User::where('role', 'empleado')->get();
        
        if ($empleados->isEmpty()) {
            $this->error('No se encontraron empleados en la base de datos');
            return;
        }
        
        // Obtener un administrador como remitente
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $this->error('No se encontró un administrador para enviar los mensajes');
            return;
        }
        
        foreach ($empleados as $empleado) {
            $this->line("Creando mensajes para: {$empleado->name}");
            
            // Crear mensajes de ejemplo
            MensajeEmpleado::create([
                'empleado_id' => $empleado->id,
                'remitente_id' => $admin->id,
                'tipo_remitente' => 'admin',
                'asunto' => 'Bienvenida al sistema',
                'mensaje' => 'Bienvenido al sistema Technova. Esperamos que tengas una excelente experiencia trabajando con nosotros. Si tienes alguna pregunta, no dudes en contactar al administrador.',
                'tipo' => 'general',
                'prioridad' => 'normal',
                'leido' => false
            ]);
            
            MensajeEmpleado::create([
                'empleado_id' => $empleado->id,
                'remitente_id' => $admin->id,
                'tipo_remitente' => 'admin',
                'asunto' => 'Actualización del inventario',
                'mensaje' => 'Por favor, asegúrate de actualizar el inventario de productos al final de cada día. Es importante mantener la información actualizada para el correcto funcionamiento del sistema.',
                'tipo' => 'instruccion',
                'prioridad' => 'alta',
                'leido' => false
            ]);
            
            MensajeEmpleado::create([
                'empleado_id' => $empleado->id,
                'remitente_id' => $admin->id,
                'tipo_remitente' => 'admin',
                'asunto' => 'Nueva funcionalidad disponible',
                'mensaje' => 'Se ha implementado una nueva funcionalidad en el sistema de mensajes. Ahora puedes recibir notificaciones directas del administrador y gestionar mejor la comunicación interna.',
                'tipo' => 'notificacion',
                'prioridad' => 'normal',
                'leido' => true,
                'fecha_leido' => now()->subHours(2)
            ]);
            
            MensajeEmpleado::create([
                'empleado_id' => $empleado->id,
                'remitente_id' => $admin->id,
                'tipo_remitente' => 'admin',
                'asunto' => 'Reunión de equipo programada',
                'mensaje' => 'Se ha programado una reunión de equipo para el próximo viernes a las 2:00 PM. Por favor confirma tu asistencia respondiendo a este mensaje.',
                'tipo' => 'urgencia',
                'prioridad' => 'urgente',
                'leido' => false
            ]);
            
            $this->line("  ✓ 4 mensajes creados");
        }
        
        $this->info('¡Mensajes de ejemplo creados exitosamente!');
    }
}
