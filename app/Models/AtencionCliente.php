<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtencionCliente extends Model
{
    use HasFactory;
    
    protected $table = 'atencioncliente';
    protected $primaryKey = 'ID_Atencion';
    
    // Deshabilitar timestamps automáticos ya que la tabla usa Fecha_Consulta
    public $timestamps = false;
    
    protected $fillable = [
        'ID_Usuario',
        'Fecha_Consulta',
        'Tema',
        'Descripcion',
        'Estado',
        'Respuesta'
    ];
    
    protected $casts = [
        'Fecha_Consulta' => 'datetime'
    ];
    
    public function usuario()
    {
        return $this->belongsTo(User::class, 'ID_Usuario');
    }
}
