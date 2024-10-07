<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    use HasFactory;
    protected $table = '1_proveedores';

    protected $fillable = [
        'nombre',
        'nombre_slug',
        'tipo_conversion',
        'logo',
        'logo_negativo',
        'politica_privacidad',
        'estado',
        'pais',
        'telefono'
    ];

    public function state()
    {
        return $this->belongsTo(States::class, 'estado', 'id');
    }

    public function paises()
    {
        return $this->belongsTo(Paises::class, 'pais', 'id');
    }
}
