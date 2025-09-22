<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'ID_Producto';
    protected $fillable = [
        'Codigo', 'Nombre', 'Imagen', 'ID_Caracteristicas', 'Stock', 'Proveedor', 'Ingreso', 'Salida'
    ];
    public $timestamps = false;

    public function caracteristicas()
    {
        return $this->belongsTo(Caracteristicas::class, 'ID_Caracteristicas', 'ID_Caracteristicas');
    }

    // Nota: La tabla producto tiene una columna 'Proveedor' (string) no 'ID_Proveedor'
    // Por ahora no hay relación directa con la tabla proveedor
    // public function proveedor()
    // {
    //     return $this->belongsTo(Proveedor::class, 'ID_Proveedor', 'ID_Proveedor');
    // }

    /**
     * Relación con favoritos
     */
    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'producto_id', 'ID_Producto');
    }

    /**
     * Obtener usuarios que han marcado este producto como favorito
     */
    public function usuariosFavoritos()
    {
        return $this->belongsToMany(User::class, 'favoritos', 'producto_id', 'user_id', 'ID_Producto', 'id')
                    ->withTimestamps();
    }
}
