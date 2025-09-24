<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Notificacion extends Model
{
    protected $table = 'notificacions';
    
    protected $fillable = [
        'user_id',
        'titulo',
        'mensaje',
        'tipo',
        'icono',
        'leida',
        'data_adicional',
        'fecha_creacion'
    ];

    protected $casts = [
        'leida' => 'boolean',
        'data_adicional' => 'array',
        'fecha_creacion' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Método para crear notificaciones automáticamente
    public static function crearNotificacion($userId, $titulo, $mensaje, $tipo = 'general', $icono = 'bx-bell', $dataAdicional = null)
    {
        return self::create([
            'user_id' => $userId,
            'titulo' => $titulo,
            'mensaje' => $mensaje,
            'tipo' => $tipo,
            'icono' => $icono,
            'data_adicional' => $dataAdicional,
            'fecha_creacion' => now()
        ]);
    }

    // Método para obtener notificaciones no leídas de un usuario
    public static function obtenerNoLeidas($userId)
    {
        return self::where('user_id', $userId)
                   ->where('leida', false)
                   ->orderBy('fecha_creacion', 'desc')
                   ->get();
    }

    // Método para obtener todas las notificaciones de un usuario
    public static function obtenerTodas($userId, $limit = 50)
    {
        return self::where('user_id', $userId)
                   ->orderBy('fecha_creacion', 'desc')
                   ->limit($limit)
                   ->get();
    }

    // Método para marcar como leída
    public function marcarComoLeida()
    {
        $this->update(['leida' => true]);
        return $this;
    }

    // Método para marcar como no leída
    public function marcarComoNoLeida()
    {
        $this->update(['leida' => false]);
        return $this;
    }

    // Accessor para formatear la fecha
    public function getFechaFormateadaAttribute()
    {
        return $this->fecha_creacion->diffForHumans();
    }
}
