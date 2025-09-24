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
        'fecha_respuesta',
        'conversation_id',
        'parent_message_id',
        'sender_type',
        'sender_id',
        'recipient_id',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'fecha_respuesta' => 'datetime',
        'read_at' => 'datetime',
        'is_read' => 'boolean'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function parentMessage()
    {
        return $this->belongsTo(MensajeDirecto::class, 'parent_message_id');
    }

    public function replies()
    {
        return $this->hasMany(MensajeDirecto::class, 'parent_message_id')->orderBy('created_at');
    }

    public function conversation()
    {
        return $this->hasMany(MensajeDirecto::class, 'conversation_id', 'conversation_id')->orderBy('created_at');
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

    // Método para marcar como leído
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    // Método para obtener el nombre del remitente
    public function getSenderNameAttribute()
    {
        if ($this->sender_type === 'cliente') {
            return $this->sender ? $this->sender->name : 'Cliente';
        } else {
            return $this->sender ? $this->sender->name : 'Empleado';
        }
    }

    // Método para obtener el avatar del remitente
    public function getSenderAvatarAttribute()
    {
        if ($this->sender_type === 'cliente') {
            return '👤';
        } else {
            return '👨‍💼';
        }
    }

    // Método para verificar si es el primer mensaje de la conversación
    public function isFirstMessage()
    {
        return $this->parent_message_id === null;
    }

    // Método estático para crear una nueva conversación
    public static function createConversation($data)
    {
        $conversationId = 'conv_' . uniqid();
        
        return self::create(array_merge($data, [
            'conversation_id' => $conversationId,
            'sender_type' => 'cliente',
            'sender_id' => $data['user_id'],
            'recipient_id' => null, // Se asignará cuando un empleado responda
            'is_read' => false
        ]));
    }

    // Método para responder a un mensaje
    public function reply($data, $senderType, $senderId, $recipientId)
    {
        return self::create(array_merge($data, [
            'conversation_id' => $this->conversation_id,
            'parent_message_id' => $this->id,
            'sender_type' => $senderType,
            'sender_id' => $senderId,
            'recipient_id' => $recipientId,
            'is_read' => false
        ]));
    }
}
