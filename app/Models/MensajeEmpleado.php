<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MensajeEmpleado extends Model
{
    protected $table = 'mensaje_empleados';
    
    protected $fillable = [
        'empleado_id',
        'remitente_id',
        'tipo_remitente',
        'asunto',
        'mensaje',
        'tipo',
        'prioridad',
        'leido',
        'fecha_leido',
        'data_adicional'
    ];

    protected $casts = [
        'leido' => 'boolean',
        'fecha_leido' => 'datetime',
        'data_adicional' => 'array'
    ];

    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }

    public function remitente()
    {
        return $this->belongsTo(User::class, 'remitente_id');
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

    // Método para obtener el color del tipo
    public function getColorTipoAttribute()
    {
        return match($this->tipo) {
            'general' => '#6c757d',
            'notificacion' => '#17a2b8',
            'instruccion' => '#28a745',
            'urgencia' => '#dc3545',
            default => '#6c757d'
        };
    }

    // Método para obtener el icono del tipo
    public function getIconoTipoAttribute()
    {
        return match($this->tipo) {
            'general' => 'bx-message',
            'notificacion' => 'bx-bell',
            'instruccion' => 'bx-task',
            'urgencia' => 'bx-error',
            default => 'bx-message'
        };
    }

    // Método para marcar como leído
    public function marcarComoLeido()
    {
        $this->update([
            'leido' => true,
            'fecha_leido' => now()
        ]);
    }
}
