<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'ID_Usuario';
    protected $fillable = [
        'ID_Usuario',
        'Tipo_De_Documento',
        'Identificacion',
        'Nombre',
        'Apellido',
        'Correo',
        'Contraseña',
        'Telefono',
        'Direccion',
        'Rol',
        'Fecha_De_Registro'
    ];
    public $timestamps = false;

    /**
     * Relación con las ventas
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'ID_Usuario', 'ID_Usuario');
    }

    /**
     * Relación con el carrito
     */
    public function carrito()
    {
        return $this->hasOne(Carrito::class, 'ID_Usuario', 'ID_Usuario');
    }
}
