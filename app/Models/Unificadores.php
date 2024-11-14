<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unificadores extends Model
{
    use HasFactory;
    protected $table = 'WEB_3_TARIFAS_UNIFICADORAS';

    protected $fillable = [
        'banca',
        'titulo',
        'selector1',
        'valorMaximo',
        'parrilla_1',
        'parrilla_2',
        'parrilla_3',
        'parrilla_4',
        'url_redirct',
        'destacada',
        'estado',
        'categoria',
        'pais',
        'interes_mensual',
        'inteses_anual',
        'ingresos_minimos',
        'slug_tarifa'
    ];
}
