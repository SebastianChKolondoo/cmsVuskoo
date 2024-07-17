<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaginaWebFooter extends Model
{
    use HasFactory;
    protected $table = 'pagina_web_footer';
    protected $fillable = [
        'titulo_1',
        'titulo_2',
        'titulo_3',
        'titulo_4',
        'titulo_5',
        'enlace_1',
        'enlace_2',
        'enlace_3',
        'enlace_4',
        'enlace_5',
        'pais'
    ];
}
