<?php

namespace App\Listeners;

use App\Events\CompraCreada;
use App\Services\NotificacionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CrearNotificacionCompra
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
    public function handle(CompraCreada $event): void
    {
        $compra = $event->compra;
        
        if ($compra->user) {
            NotificacionService::crearNotificacionCompra(
                $compra->user->id, 
                $compra->ID_Compras
            );
        }
    }
}
