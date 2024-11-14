<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParillaGas extends Model
{
    use HasFactory;
    protected $table = 'WEB_3_TARIFAS_ENERGIA_GAS';

    protected $fillable = [
        'comercializadora',
        'destacada',
        'landing_link',
        'nombre_tarifa',
        'parrilla_bloque_1',
        'parrilla_bloque_2',
        'parrilla_bloque_3',
        'parrilla_bloque_4',
        'landing_dato_adicional',
        'meses_permanencia',
        'precio',
        'precio_final',
        'imagen_promo',
        'promocion',
        'num_meses_promo',
        'texto_alternativo_promo',
        'coste_mantenimiento',
        'coste_de_gestion',
        'gas_tipo_precio',
        'gas_precio_termino_fijo',
        'gas_precio_termino_variable',
        'gas_precio_energia',
        'destacada',
        'orden_parrilla_comercializadora',
        'estado',
        'fecha_publicacion',
        'fecha_expiracion',
        'fecha_registro',
        'moneda',
        'landingLead',
        'slug_tarifa',
        'pais',
        'textoAdicional',
        'tituloSeo',
        'descripcionSeo',
        'luz_indexada',
        'informacionLegal'
        /* 'tarifa_empresarial' */
    ];

    public function state()
    {
        return $this->belongsTo(States::class, 'estado', 'id');
    }

    public function comercializadoras()
    {
        return $this->belongsTo(Comercializadoras::class, 'comercializadora', 'id');
    }

    public function paises()
    {
        return $this->belongsTo(Paises::class, 'pais', 'id');
    }
}
