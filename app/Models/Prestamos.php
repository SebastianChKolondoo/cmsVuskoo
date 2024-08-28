<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamos extends Model
{
    use HasFactory;
    protected $table = 'WEB_3_PRESTAMOS';

    protected $fillable = [
        'categoria',
        'selector1',
        'titulo',
        'banca',
        'valorMaximo',
        'parrilla_1',
        'parrilla_2',
        'parrilla_3',
        'parrilla_4',
        'url_redirct',
        'destacada',
        'estado',
        'pais',
        'interes_mensual',
        'inteses_anual',
        'ingresos_minimos',
        'descuento_comercio',
        'apertura_cuenta',
        'disposicion_efectivo',
        'cajeros',
        'red_cajeros',
        'retiros_costo',
        'cashback',
        'cuota_manejo_1',
        'cuota_manejo_2',
        'cuota_manejo_3',
        'programa_puntos',
        'emisor',
        'compras_extranjero',
        'avance_cajero',
        'avance_oficina',
        'reposicion_tarjeta',
    ];

    public function state()
    {
        return $this->belongsTo(States::class, 'estado', 'id');
    }

    public function banco()
    {
        return $this->belongsTo(Banca::class, 'banca', 'id');
    }
    
    public function paises()
    {
        return $this->belongsTo(Paises::class, 'pais', 'id');
    }
}
