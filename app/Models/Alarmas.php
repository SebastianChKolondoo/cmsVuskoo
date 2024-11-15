<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alarmas extends Model
{
    use HasFactory;
    protected $table = 'WEB_3_TARIFAS_ALARMAS';

    protected $fillable = [
        'proveedor',
        'selector_1',
        'precio_1',
        'divisa_1',
        'selector_2',
        'precio_2',
        'divisa_2',
        'parrilla_1',
        'parrilla_2',
        'parrilla_3',
        'parrilla_4',
        'url_redirct',
        'destacada',
        'estado',
        'pais',
        'verificacion_video',
        'compatible_mascotas',
        'boton_panico',
        'fotodetector',
        'detector_infrarrojo',
        'detector_magnetico',
        'llaves_tags',
        'extras',
        'slug_tarifa'
    ];

    public function proveedores()
    {
        return $this->belongsTo(Proveedores::class, 'proveedor', 'id');
    }

    public function state()
    {
        return $this->belongsTo(States::class, 'estado', 'id');
    }

    public function paises()
    {
        return $this->belongsTo(Paises::class, 'pais', 'id');
    }
}
