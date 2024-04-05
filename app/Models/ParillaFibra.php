<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParillaFibra extends Model
{
    use HasFactory;
    protected $table = 'WEB_3_TARIFAS_TELCO_FIBRA';

    protected $fillable = [
        'id_producto',
        'estado',
        'destacada',
        'operadora',
        'landing_link',
        'funcion',
        'nombre_tarifa',
        'slug_tarifa',
        'parrilla_bloque_1',
        'parrilla_bloque_2',
        'parrilla_bloque_3',
        'parrilla_bloque_4',
        'MB_subida',
        'MB_bajada',
        'tlf_fijo',
        'meses_permanencia',
        'precio',
        'precio_final',
        'num_meses_promo',
        'porcentaje_descuento',
        'imagen_promo',
        'promocion',
        'texto_alternativo_promo',
        'destacada',
        'orden_parrilla_operadora',
        'fecha_publicacion',
        'fecha_expiracion',
        'fecha_registro',
        'moneda',
        'landingLead',
        'pais',
    ];

    public function state()
    {
        return $this->belongsTo(States::class, 'estado', 'id');
    }

    public function operadoras()
    {
        return $this->belongsTo(Operadoras::class, 'operadora', 'id');
    }

    public function paises()
    {
        return $this->belongsTo(Paises::class, 'pais', 'id');
    }
}
