<?php

namespace App\Listeners;

use App\Events\PagoProcesado;
use App\Services\NotificacionService;
use App\Models\Venta;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CrearNotificacionPago
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
    public function handle(PagoProcesado $event): void
    {
        $pago = $event->pago;
        
        // Buscar el usuario asociado a través de las ventas
        $venta = Venta::whereHas('detalles', function($query) use ($pago) {
            $query->whereHas('mediosPago', function($q) use ($pago) {
                $q->where('ID_Pagos', $pago->ID_Pagos);
            });
        })->with('usuario')->first();

        if ($venta && $venta->usuario) {
            if ($pago->Estado_Pago === 'procesado') {
                NotificacionService::crearNotificacionPagoProcesado(
                    $venta->usuario->id, 
                    $pago->ID_Pagos, 
                    $pago->Monto
                );
            } elseif ($pago->Estado_Pago === 'pendiente') {
                NotificacionService::crearNotificacionPagoPendiente(
                    $venta->usuario->id, 
                    $pago->ID_Pagos, 
                    $pago->Monto
                );
            }
        }
    }
}
