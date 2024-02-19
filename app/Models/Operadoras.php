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
        'operadora_activa',
        'tipo_conversion',
        'color',
        'color_texto',
        'logo',
        'logo_negativo',
        'isotipo',
        'politica_privacidad',
        'fecha_registro',
    ];

    public function state()
    {
        return $this->belongsTo(States::class, 'operadora_activa', 'id');
    }
}
