<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupones extends Model
{
    use HasFactory;
    protected $table = "WEB_3_TARIFAS_CUPONES";
    protected $fillable = [
        'codigo',
        'landing_link',
        'comercio',
        'estado',
        'landing_link',
        'funcion',
        'cateogria',
        'descripcion',
        'destacada',
        'fecha_publicacion',
        'fecha_expiracion',
        'slug_tarifa',
        'categoria',
        'pais',
        'textoAdicional',
        'created_at',
        'updated_at',
        'nombre_tarifa',
        'promocion'
    ];

    public function state()
    {
        return $this->belongsTo(States::class, 'estado', 'id');
    }

    public function comercios()
    {
        return $this->belongsTo(Comercios::class, 'comercio', 'id');
    }

    public function paises()
    {
        return $this->belongsTo(Paises::class, 'pais', 'id');
    }

    public function categorias()
    {
        return $this->belongsTo(Categorias::class, 'categoria', 'id');
    }
}
