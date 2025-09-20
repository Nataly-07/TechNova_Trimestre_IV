<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'ID_Producto';
    protected $fillable = [
        'Codigo',
        'Nombre',
        'Imagen',
        'ID_Caracteristicas',
        'Stock'
    ];
    public $timestamps = false;

    /**
     * Relación con los detalles de venta
     */
    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'ID_Producto', 'ID_Producto');
    }

    /**
     * Relación con las características
     */
    public function caracteristica()
    {
        return $this->belongsTo(Caracteristica::class, 'ID_Caracteristicas', 'ID_Caracteristicas');
    }
}
