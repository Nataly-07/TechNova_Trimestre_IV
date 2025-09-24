<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Compra;

class CompraCreada
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $compra;

    /**
     * Create a new event instance.
     */
    public function __construct(Compra $compra)
    {
        $this->compra = $compra;
    }
}
