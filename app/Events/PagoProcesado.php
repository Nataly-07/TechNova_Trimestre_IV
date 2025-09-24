<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pago;

class PagoProcesado
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pago;

    /**
     * Create a new event instance.
     */
    public function __construct(Pago $pago)
    {
        $this->pago = $pago;
    }
}
