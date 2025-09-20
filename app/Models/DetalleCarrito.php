<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCarrito extends Model
{
    protected $table = 'detallecarrito';
    protected $primaryKey = 'ID_DetalleCarrito';
    protected $fillable = [
        'ID_Carrito',
        'ID_Producto',
        'Cantidad'
    ];
    public $timestamps = false;

    /**
     * Relación con el carrito
     */
    public function carrito()
    {
        return $this->belongsTo(Carrito::class, 'ID_Carrito', 'ID_Carrito');
    }

    /**
     * Relación con el producto
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'ID_Producto', 'ID_Producto');
    }
}

