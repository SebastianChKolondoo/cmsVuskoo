<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParrillaAutoconsumo extends Model
{
    use HasFactory;
    protected $table = 'WEB_3_TARIFAS_ENERGIA_AUTOCONSUMO';
    protected $fillable = [
        'estado',
        'destacada',
        'comercializadora',
        'landing_link',
        'nombre_tarifa',
        'parrilla_bloque_1',
        'parrilla_bloque_2',
        'parrilla_bloque_3',
        'parrilla_bloque_4',
        'landing_dato_adicional',
        'meses_permanencia',
        'luz_discriminacion_horaria',
        'precio',
        'precio_final',
        'luz_precio_potencia_punta',
        'luz_precio_potencia_valle',
        'luz_precio_energia_punta',
        'luz_precio_energia_llano',
        'luz_precio_energia_valle',
        'luz_precio_energia_24h',
        'energia_verde',
        'imagen_promo',
        'promocion',
        'num_meses_promo',
        'texto_alternativo_promo',
        'coste_de_gestion',
        'coste_mantenimiento',
        'destacada',
        'orden_parrilla_comercializadora',
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
        'informacionLegal',
        'excedente',
        'bateria_virtual',
        'precio_bateria_virtual'
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
