<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedioPago extends Model
{
    protected $table = 'mediodepago';
    protected $primaryKey = 'ID_MedioDePago';
    protected $fillable = [
        'ID_Pagos',
        'ID_DetalleVentas',
        'ID_Usuario',
        'Metodo_pago',
        'Fecha_De_Compra',
        'Tiempo_De_Entrega'
    ];
    public $timestamps = false;

    /**
     * Relación con las compras
     */
    public function compras()
    {
        return $this->hasMany(Compra::class, 'ID_MedioDePago', 'ID_MedioDePago');
    }

    /**
     * Relación con el pago
     */
    public function pago()
    {
        return $this->belongsTo(Pago::class, 'ID_Pagos', 'ID_Pagos');
    }

    /**
     * Relación con el detalle de venta
     */
    public function detalleVenta()
    {
        return $this->belongsTo(DetalleVenta::class, 'ID_DetalleVentas', 'ID_DetalleVentas');
    }

    /**
     * Obtener métodos de pago disponibles
     */
    public static function getMetodosDisponibles()
    {
        return [
            'nequi' => 'Nequi',
            'pse' => 'PSE',
            'tarjeta_credito' => 'Tarjeta de Crédito',
            'tarjeta_debito' => 'Tarjeta de Débito',
            'transferencia_bancaria' => 'Transferencia Bancaria',
            'efectivo' => 'Efectivo'
        ];
    }
}

