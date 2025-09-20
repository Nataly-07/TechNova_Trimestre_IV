<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalleventas';
    protected $primaryKey = 'ID_DetalleVentas';
    protected $fillable = [
        'ID_Ventas',
        'ID_Producto',
        'Cantidad',
        'Precio'
    ];
    public $timestamps = false;

    /**
     * Relación con la venta
     */
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'ID_Ventas', 'ID_Ventas');
    }

    /**
     * Relación con el producto
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'ID_Producto', 'ID_Producto');
    }

    /**
     * Relación con el producto en la tabla productos
     */
    public function productos()
    {
        return $this->belongsTo(Productos::class, 'ID_Producto', 'ID_Producto');
    }
}
