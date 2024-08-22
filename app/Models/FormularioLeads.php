<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormularioLeads extends Model
{
    use HasFactory;
    protected $table = "lead";
    protected $fillable = [
        'id',
        'landing',
        'urlOffer',
        'company',
        'idOferta',
        'phone',
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
        'aceptaComunicacion',
        'created_at'
    ];

    /* public function companies()
    {
        return $this->belongsTo(Operadoras::class, 'company', 'id');
    }

    public function paises()
    {
        return $this->belongsTo(Paises::class, 'pais', 'id');
    } */

    public function politicaPrivacidad()
    {
        return $this->belongsTo(States::class, 'acepta_politica_privacidad', 'id');
    }
    public function cesionDatos()
    {
        return $this->belongsTo(States::class, 'acepta_cesion_datos_a_proveedor', 'id');
    }
    public function comunicacionesComerciales()
    {
        return $this->belongsTo(States::class, 'acepta_comunicaciones_comerciales', 'id');
    }
    
}
