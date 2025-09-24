<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\VentaCreada;
use App\Events\PagoProcesado;
use App\Events\CompraCreada;
use App\Listeners\CrearNotificacionVenta;
use App\Listeners\CrearNotificacionPago;
use App\Listeners\CrearNotificacionCompra;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        VentaCreada::class => [
            CrearNotificacionVenta::class,
        ],
        PagoProcesado::class => [
            CrearNotificacionPago::class,
        ],
        CompraCreada::class => [
            CrearNotificacionCompra::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
