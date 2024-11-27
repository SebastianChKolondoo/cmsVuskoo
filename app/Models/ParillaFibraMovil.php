<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParillaFibraMovil extends Model
{
    use HasFactory;
    protected $table = 'WEB_3_TARIFAS_TELCO_FIBRA_MOVIL';

    protected $fillable = [
        'operadora',
        'destacada',
        'landing_link',
        'nombre_tarifa',
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
        'GB',
        'llamadas_ilimitadas',
        'coste_llamadas_minuto',
        'coste_establecimiento_llamada',
        'num_minutos_gratis',
        'num_lineas_adicionales',
        'GB_linea_adicional',
        'tipo_conexion_internet',
        'nombre_terminal_regalo',
        'destacada',
        'orden_parrilla_operadora',
        'estado',
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
        'duracionContrato',
        'red5g',
        'tinder',
        'lolamusic',
        'tituloSeo',
        'descripcionSeo',
        'informacionLegal',
        'tarifa_empresarial'
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
