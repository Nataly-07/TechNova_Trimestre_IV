<?php

namespace App\Listeners;

use App\Events\VentaCreada;
use App\Services\NotificacionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CrearNotificacionVenta
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(VentaCreada $event): void
    {
        $venta = $event->venta;
        
        if ($venta->usuario) {
            NotificacionService::crearNotificacionPedidoEnviado(
                $venta->usuario->id, 
                $venta->ID_Ventas
            );
        }
    }
}
