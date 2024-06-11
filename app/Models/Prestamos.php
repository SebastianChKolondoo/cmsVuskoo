<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamos extends Model
{
    use HasFactory;
    protected $table = 'WEB_3_PRESTAMOS';

    protected $fillable = [
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
    ];

    public function state()
    {
        return $this->belongsTo(States::class, 'estado', 'id');
    }

    public function banco()
    {
        return $this->belongsTo(Banca::class, 'banca', 'id');
    }
}
