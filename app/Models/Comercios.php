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
        'nombre_slug',
        'TipoCupon',
        'tipo_conversion',
        'logo',
        'logo_negativo',
        'politica_privacidad',
        'estado',
        'pais',
    ];

    public function state()
    {
        return $this->belongsTo(States::class, 'estado', 'id');
    }
   
    /* public function paises()
    {
        return $this->belongsToMany(Paises::class, 'pais', 'id');
    } */
}
