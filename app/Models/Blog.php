<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blog';
    protected $fillable = [
        'imagen',
        'fecha_publicacion',
        'titulo',
        'contenido',
        'entradilla',
        'seo_titulo',
        'seo_descripcion',
        'migapan',
        'url_amigable',
        'categoria',
        'pais',
        'estado'
    ];

    public function paises()
    {
        return $this->belongsTo(Paises::class, 'pais', 'id');
    }

    public function categorias()
    {
        return $this->belongsTo(CategoriaBlog::class, 'categoria', 'id');
    }
}
