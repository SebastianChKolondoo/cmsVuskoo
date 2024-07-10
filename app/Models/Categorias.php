<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;
    protected $table = 'categorias_comercios';
    protected $fillable = [
        'nombre',
        'pais'
    ];

    public function paises()
    {
        return $this->belongsTo(Paises::class, 'pais', 'id');
    }
}
