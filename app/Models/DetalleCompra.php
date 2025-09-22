<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = 'detallecompras';
    protected $primaryKey = 'ID_DetalleCompras';
    protected $fillable = [
        'ID_Compras',
        'ID_Producto',
        'Cantidad',
        'Precio'
    ];
    public $timestamps = false;

    /**
     * Relación con la compra
     */
    public function compra()
    {
        return $this->belongsTo(Compra::class, 'ID_Compras', 'ID_Compras');
    }

    /**
     * Relación con el producto
     */
    public function producto()
    {
        return $this->belongsTo(Productos::class, 'ID_Producto', 'ID_Producto');
    }
}

