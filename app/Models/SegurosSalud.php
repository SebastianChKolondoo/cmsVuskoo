<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegurosSalud extends Model
{
    use HasFactory;
    protected $table = 'WEB_3_TARIFAS_SEGUROS_SALUD';

    protected $fillable = [
        'proveedor',
        'slug_tarifa',
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
        'copago',
        'telefono'
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
