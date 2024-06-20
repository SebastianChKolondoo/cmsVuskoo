<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operadoras extends Model
{
    use HasFactory;
    protected $table = '1_operadoras';
    protected $fillable = [
        'nombre',
        'nombre_slug',
        'tipo_conversion',
        'color',
        'color_texto',
        'logo',
        'logo_negativo',
        'isotipo',
        'politica_privacidad',
        'estado',
        'fecha_registro',
        'pais'
    ];

    public function state()
    {
        return $this->belongsTo(States::class, 'estado', 'id');
    }

    public function paises()
    {
        return $this->belongsTo(Paises::class, 'pais', 'id');
    }
}
