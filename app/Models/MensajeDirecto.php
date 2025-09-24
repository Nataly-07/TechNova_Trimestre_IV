<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MensajeDirecto extends Model
{
    protected $table = 'mensaje_directos';
    
    protected $fillable = [
        'user_id',
        'asunto',
        'mensaje',
        'prioridad',
        'estado',
        'empleado_id',
        'respuesta',
        'fecha_respuesta'
    ];

    protected $casts = [
        'fecha_respuesta' => 'datetime'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }

    // Método para obtener el color de la prioridad
    public function getColorPrioridadAttribute()
    {
        return match($this->prioridad) {
            'baja' => '#28a745',
            'normal' => '#17a2b8',
            'alta' => '#ffc107',
            'urgente' => '#dc3545',
            default => '#17a2b8'
        };
    }

    // Método para obtener el color del estado
    public function getColorEstadoAttribute()
    {
        return match($this->estado) {
            'enviado' => '#6c757d',
            'leido' => '#17a2b8',
            'respondido' => '#28a745',
            'cerrado' => '#6c757d',
            default => '#6c757d'
        };
    }
}
