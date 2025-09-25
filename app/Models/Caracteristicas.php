<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caracteristicas extends Model
{
    use HasFactory;

    protected $table = 'caracteristicas';
    protected $primaryKey = 'ID_Caracteristicas';

    protected $fillable = [
        'Categoria',
        'Color',
        'Descripcion',
        'Precio_Compra',
        'Porcentaje_Ganancia',
        'Precio_Venta',
        'Marca'
    ];

    public $timestamps = false;

    public function productos()
    {
        return $this->hasMany(Producto::class, 'ID_Caracteristicas');
    }
}
