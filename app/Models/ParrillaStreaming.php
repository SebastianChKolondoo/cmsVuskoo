<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParrillaStreaming extends Model
{
    use HasFactory;
    protected $table = 'WEB_3_TARIFAS_TELCO_STREAMING';

    protected $fillable = [
        'id',
        'landing_link',
        'permanencia',
        'funcion',
        'nombre_tarifa',
        'detalles_tarifa',
        'categoria',
        'recomendaciones',
        'titulo_relativo_1',
        'precio_relativo_1',
        'titulo_relativo_2',
        'precio_relativo_2',
        'titulo_relativo_3',
        'precio_relativo_3',
        'parrilla_bloque_1',
        'precio_parrilla_bloque_1',
        'parrilla_bloque_2',
        'precio_parrilla_bloque_2',
        'parrilla_bloque_3',
        'precio_parrilla_bloque_3',
        'parrilla_bloque_4',
        'precio_parrilla_bloque_4',
        'num_meses_promo',
        'porcentaje_descuento',
        'logo',
        'promocion',
        'destacada',
        'tarifa_activa',
        'fecha_publicacion',
        'fecha_expiracion',
        'fecha_registro',
        'moneda',
        'landingLead',
        'slug_tarifa',
        'estado',
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
