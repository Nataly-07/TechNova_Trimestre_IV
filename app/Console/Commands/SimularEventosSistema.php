<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Venta;
use App\Models\Compra;
use App\Models\Pago;
use App\Services\NotificacionService;
use App\Events\VentaCreada;
use App\Events\CompraCreada;
use App\Events\PagoProcesado;

class SimularEventosSistema extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificaciones:simular-eventos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simular eventos del sistema para generar notificaciones reales';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Simulando eventos del sistema...');
        
        // Obtener usuarios existentes
        $users = User::where('role', '!=', 'admin')->take(3)->get();
        
        if ($users->isEmpty()) {
            $this->error('No se encontraron usuarios para simular eventos');
            return;
        }
        
        foreach ($users as $user) {
            $this->line("Simulando eventos para: {$user->name}");
            
            // Simular una venta
            $venta = Venta::create([
                'ID_Usuario' => $user->id,
                'fecha_venta' => now()->toDateString(),
            ]);
            
            // Disparar evento
            event(new VentaCreada($venta));
            $this->line("  ✓ Venta creada: #{$venta->ID_Ventas}");
            
            // Simular un pago
            $pago = Pago::create([
                'Fecha_Pago' => now()->toDateString(),
                'Numero_Factura' => 'FAC-SIM-' . time() . '-' . $user->id,
                'Fecha_Factura' => now()->toDateString(),
                'Monto' => rand(50000, 500000),
                'Estado_Pago' => 'procesado',
            ]);
            
            // Disparar evento
            event(new PagoProcesado($pago));
            $this->line("  ✓ Pago procesado: $" . number_format($pago->Monto, 0, ',', '.'));
            
            // Simular una compra
            $compra = Compra::create([
                'ID_Proveedor' => null,
                'ID_Usuario' => $user->id,
                'ID_MedioDePago' => 1, // ID dummy
                'Fecha_De_Compra' => now(),
                'Fecha_Compra' => now(),
                'Tiempo_De_Entrega' => now()->addDays(3),
                'Total' => rand(100000, 1000000),
                'Estado' => 'procesado'
            ]);
            
            // Disparar evento
            event(new CompraCreada($compra));
            $this->line("  ✓ Compra creada: #{$compra->ID_Compras}");
            
            // Crear notificaciones adicionales
            NotificacionService::crearNotificacionOferta(
                $user->id, 
                'Oferta especial en tecnología', 
                'No te pierdas nuestras ofertas especiales en smartphones y laptops. Descuentos de hasta 40%.'
            );
            
            NotificacionService::crearNotificacionSoporte(
                $user->id, 
                'Nuestro equipo de soporte está disponible 24/7 para ayudarte con cualquier consulta.'
            );
            
            $this->line("  ✓ Notificaciones adicionales creadas");
        }
        
        $this->info('¡Eventos simulados exitosamente!');
        $this->line('Las notificaciones se han generado automáticamente para los usuarios.');
    }
}
