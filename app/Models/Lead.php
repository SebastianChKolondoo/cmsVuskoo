<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $table = "lead";
    protected $fillable = [
        'idOferta',
        'phone',
        'landing',
        'urlOffer',
        'company',
        'idResponse',
        'nombre_usuario',
        'email',
        'producto',
        'tipo_conversion',
        'tarifa',
        'tipo_formulario',
        'acepta_politica_privacidad_kolondoo',
        'acepta_cesion_datos_a_proveedor',
        'acepta_comunicaciones_comerciales_kolondoo'
    ];
}
