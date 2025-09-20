<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';
    protected $primaryKey = 'ID_Compras';
    protected $fillable = [
        'ID_Proveedor',
        'ID_Usuario',
        'ID_MedioDePago',
        'Fecha_De_Compra',
        'Fecha_Compra',
        'Tiempo_De_Entrega',
        'Total',
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
     * Relación con el medio de pago
     */
    public function medioPago()
    {
        return $this->belongsTo(MedioPago::class, 'ID_MedioDePago', 'ID_MedioDePago');
    }

    /**
     * Relación con los detalles de compra
     */
    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class, 'ID_Compras', 'ID_Compras');
    }
}
