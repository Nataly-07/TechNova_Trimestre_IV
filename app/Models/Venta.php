<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'ID_Ventas';
    protected $fillable = [
        'ID_Usuario',
        'fecha_venta'
    ];
    public $timestamps = false;

    /**
     * Relación con los detalles de venta
     */
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'ID_Ventas', 'ID_Ventas');
    }

    /**
     * Relación con el usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'ID_Usuario', 'ID_Usuario');
    }
}
