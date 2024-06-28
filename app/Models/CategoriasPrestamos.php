<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriasPrestamos extends Model
{
    use HasFactory;
    protected $table = 'categorias_prestamos';
    protected $fillable = [
        'nombre',
    ];
}
