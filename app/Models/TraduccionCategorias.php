<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraduccionCategorias extends Model
{
    use HasFactory;
    protected $table = "traduccion_categorias";
    protected $fillable = [
        'categoria',
        'nombre',
        'pais',
    ];

    public function paises()
    {
        return $this->belongsTo(Paises::class, 'pais', 'id');
    }
}
