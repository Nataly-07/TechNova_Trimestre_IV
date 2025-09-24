<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\NotificacionService;

class CrearNotificacionesEjemplo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificaciones:crear-ejemplo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear notificaciones de ejemplo para usuarios existentes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creando notificaciones de ejemplo...');
        
        // Obtener todos los usuarios
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->error('No se encontraron usuarios en la base de datos');
            return;
        }
        
        foreach ($users as $user) {
            // Crear notificaciones de ejemplo para cada usuario
            NotificacionService::crearNotificacionBienvenida($user->id);
            NotificacionService::crearNotificacionOferta($user->id, 'Oferta especial en celulares', 'No te pierdas nuestra oferta especial en smartphones. Descuentos de hasta 30% en marcas seleccionadas.');
            NotificacionService::crearNotificacionSoporte($user->id, 'Nuestro equipo de soporte está disponible 24/7 para ayudarte con cualquier consulta.');
            NotificacionService::crearNotificacionRecordatorioPago($user->id);
            
            $this->line("Notificaciones creadas para: {$user->name}");
        }
        
        $this->info('¡Notificaciones de ejemplo creadas exitosamente!');
    }
}
