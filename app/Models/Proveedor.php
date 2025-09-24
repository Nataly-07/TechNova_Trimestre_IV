<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedor';
    protected $primaryKey = 'ID_Proveedor';
    public $timestamps = false;

    protected $fillable = [
        'Identificacion',
        'Nombre',
        'Empresa',
        'Telefono',
        'Correo',
        'ID_producto'
    ];

    protected $casts = [
        'ID_Proveedor' => 'integer',
        'ID_producto' => 'integer'
    ];

    // Relación con productos (opcional)
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'ID_producto', 'ID_Producto');
    }
}