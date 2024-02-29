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
        'acepta_politica_privacidad',
        'acepta_cesion_datos_a_proveedor',
        'acepta_comunicaciones_comerciales',
        'fecha_aceptacion_comunicaciones_comerciales',
        'ip',
        'ip_type',
        'ip_nombre_continente',
        'ip_codigo_pais',
        'ip_nombre_pais',
        'ip_region',
        'ip_ciudad',
        'ip_codigo_postal',
        'ip_latitud',
        'ip_longitud',
    ];
}
