<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comercializadoras extends Model
{
    use HasFactory;
    protected $table = '1_comercializadoras';
    protected $fillable = [
        'nombre',
        'tipo_conversion',
        'color',
        'color_texto',
        'logo',
        'logo_negativo',
        'isotipo',
        'politica_privacidad',
        'estado',
        'fecha_registro',
    ];

    public function state()
    {
        return $this->belongsTo(States::class, 'estado', 'id');
    }
}
