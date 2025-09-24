<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'document_type',
        'document_number',
        'phone',
        'address',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user has admin role.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user has empleado role.
     */
    public function isEmpleado()
    {
        return $this->role === 'empleado';
    }

    /**
     * Check if user has cliente role.
     */
    public function isCliente()
    {
        return $this->role === 'cliente';
    }

    /**
     * Relación con favoritos
     */
    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    /**
     * Obtener productos favoritos del usuario
     */
    public function productosFavoritos()
    {
        return $this->belongsToMany(Producto::class, 'favoritos', 'user_id', 'producto_id', 'id', 'ID_Producto')
                    ->withTimestamps();
    }

    /**
     * Relación con el carrito
     */
    public function carrito()
    {
        return $this->hasOne(Carrito::class, 'ID_Usuario', 'id');
    }

    /**
     * Relación con las compras
     */
    public function compras()
    {
        return $this->hasMany(Compra::class, 'ID_Usuario', 'id');
    }

    /**
     * Relación con las notificaciones
     */
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class);
    }

    /**
     * Relación con los mensajes directos enviados
     */
    public function mensajesDirectos()
    {
        return $this->hasMany(MensajeDirecto::class, 'user_id');
    }

    /**
     * Relación con los mensajes directos asignados como empleado
     */
    public function mensajesAsignados()
    {
        return $this->hasMany(MensajeDirecto::class, 'empleado_id');
    }

    /**
     * Relación con los mensajes recibidos como empleado
     */
    public function mensajesRecibidos()
    {
        return $this->hasMany(MensajeEmpleado::class, 'empleado_id');
    }

    /**
     * Relación con los mensajes enviados como remitente
     */
    public function mensajesEnviados()
    {
        return $this->hasMany(MensajeEmpleado::class, 'remitente_id');
    }
}
