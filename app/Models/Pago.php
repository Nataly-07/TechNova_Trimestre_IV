<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'ID_Pagos';
    protected $fillable = [
        'Fecha_Pago',
        'Numero_Factura',
        'Fecha_Factura',
        'Monto',
        'Estado_Pago'
    ];
    public $timestamps = false;

    /**
     * Relación con los medios de pago
     */
    public function mediosPago()
    {
        return $this->hasMany(MedioPago::class, 'ID_Pagos', 'ID_Pagos');
    }
}




