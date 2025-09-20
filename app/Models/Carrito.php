<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'carrito';
    protected $primaryKey = 'ID_Carrito';
    protected $fillable = [
        'ID_Usuario',
        'Fecha_Creacion',
        'Estado'
    ];
    public $timestamps = false;

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'ID_Usuario', 'id');
    }

    /**
     * Relación con los detalles del carrito
     */
    public function detalles()
    {
        return $this->hasMany(DetalleCarrito::class, 'ID_Carrito', 'ID_Carrito');
    }

    /**
     * Obtener productos del carrito
     */
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'detallecarrito', 'ID_Carrito', 'ID_Producto', 'ID_Carrito', 'ID_Producto')
                    ->withPivot('Cantidad');
    }
}
