<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comercios extends Model
{
    use HasFactory;
    protected $table = "1_comercios";
    protected $fillable = [
        'funcion_api',
        'nombre',
        'idPerseo',
        'nombre_slug',
        'TipoCupon',
        'tipo_conversion',
        'logo',
        'logo_negativo',
        'politica_privacidad',
        'estado',
        'pais',
        'categoria'
    ];

    public function state()
    {
        return $this->belongsTo(States::class, 'estado', 'id');
    }

    public function categorias()
    {
        return $this->belongsTo(Categorias::class, 'categoria', 'id');
    }
   
    public function paises()
    {
        return $this->belongsTo(Paises::class, 'pais', 'id');
    }
}
