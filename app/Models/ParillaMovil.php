<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParillaMovil extends Model
{
    use HasFactory;
    protected $table = 'WEB_3_TARIFAS_TELCO_MOVIL';
    protected $fillable = [
        'id_producto',
        'operadora',
        'destacada',
        'estado',
        'landing_link',
        'permanencia',
        'funcion',
        'nombre_tarifa',
        'parrilla_bloque_1',
        'parrilla_bloque_2',
        'parrilla_bloque_3',
        'parrilla_bloque_4',
        'meses_permanencia',
        'precio',
        'precio_final',
        'num_meses_promo',
        'porcentaje_descuento',
        'imagen_promo',
        'promocion',
        'texto_alternativo_promo',
        'GB',
        'llamadas_ilimitadas',
        'coste_llamadas_minuto',
        'coste_establecimiento_llamada',
        'num_minutos_gratis',
        'nombre_terminal_regalo',
        'destacada',
        'orden_parrilla_operadora',
        'fecha_publicacion',
        'fecha_expiracion',
        'fecha_registro',
        'moneda',
        'landingLead',
        'slug_tarifa',
        'pais',
        'textoAdicional',
        'appsIlimitadas',
        'facebook',
        'messenger',
        'waze',
        'whatsapp',
        'twitter',
        'instagram',
        'duracionContrato'
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
