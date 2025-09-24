<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\MensajeEmpleado;

class CrearMensajesPorDefecto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mensajes:crear-por-defecto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear mensajes por defecto del administrador para todos los empleados';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creando mensajes por defecto del administrador...');
        
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
            $this->line("Creando mensajes por defecto para: {$empleado->name}");
            
            // Verificar si ya existen mensajes por defecto para este empleado
            $mensajeExistente = MensajeEmpleado::where('empleado_id', $empleado->id)
                ->where('asunto', 'Bienvenida al sistema Technova')
                ->first();
            
            if (!$mensajeExistente) {
                // Mensaje de bienvenida por defecto
                MensajeEmpleado::create([
                    'empleado_id' => $empleado->id,
                    'remitente_id' => $admin->id,
                    'tipo_remitente' => 'admin',
                    'asunto' => 'Bienvenida al sistema Technova',
                    'mensaje' => '¡Bienvenido al sistema Technova! Este es tu panel de empleado donde podrás gestionar usuarios, visualizar inventario y recibir comunicaciones importantes del equipo administrativo. Si tienes alguna pregunta, no dudes en contactar al administrador.',
                    'tipo' => 'general',
                    'prioridad' => 'normal',
                    'leido' => false
                ]);
            }
            
            // Verificar si ya existe el mensaje de instrucciones
            $instruccionExistente = MensajeEmpleado::where('empleado_id', $empleado->id)
                ->where('asunto', 'Instrucciones de uso del sistema')
                ->first();
            
            if (!$instruccionExistente) {
                // Mensaje de instrucciones por defecto
                MensajeEmpleado::create([
                    'empleado_id' => $empleado->id,
                    'remitente_id' => $admin->id,
                    'tipo_remitente' => 'admin',
                    'asunto' => 'Instrucciones de uso del sistema',
                    'mensaje' => 'Como empleado de Technova, tienes acceso a las siguientes funcionalidades: 1) Gestión de usuarios clientes, 2) Visualización del inventario de productos, 3) Sistema de mensajes para comunicación interna, 4) Atención al cliente (próximamente). Mantén siempre actualizada la información y reporta cualquier incidencia.',
                    'tipo' => 'instruccion',
                    'prioridad' => 'alta',
                    'leido' => false
                ]);
            }
            
            $this->line("  ✓ Mensajes por defecto creados/verificados");
        }
        
        $this->info('¡Mensajes por defecto creados exitosamente!');
    }
}
