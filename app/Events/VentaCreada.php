<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Venta;

class VentaCreada
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $venta;

    /**
     * Create a new event instance.
     */
    public function __construct(Venta $venta)
    {
        $this->venta = $venta;
    }
}
