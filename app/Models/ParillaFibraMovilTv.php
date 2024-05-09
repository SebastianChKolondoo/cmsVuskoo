<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParillaFibraMovilTv extends Model
{
    use HasFactory;
    protected $table = 'WEB_3_TARIFAS_TELCO_FIBRA_MOVIL_TV';

    protected $fillable = [
        'id_producto',
        'operadora',
        'destacada',
        'landing_link',
        'funcion',
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
        'TV',
        'Netflix',
        'HBO',
        'AmazonPrime',
        'Filmin',
        'DAZN',
        'otros_canales_TV',
        'nombre_terminal_regalo',
        'destacada',
        'estado',
        'orden_parrilla_operadora',
        'fecha_publicacion',
        'fecha_expiracion',
        'fecha_registro',
        'moneda',
        'landingLead',
        'slug_tarifa',
        'pais',
        'textoAdicional'
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
