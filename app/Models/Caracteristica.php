<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
    protected $table = 'caracteristica';
    protected $primaryKey = 'ID_Caracteristicas';
    protected $fillable = [
        'Categoria',
        'Color',
        'Descripcion',
        'Precio_Compra',
        'Precio_Venta',
        'Marca'
    ];
    public $timestamps = false;

    /**
     * Relación con los productos
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'ID_Caracteristicas', 'ID_Caracteristicas');
    }
}


