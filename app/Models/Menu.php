<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = "pagina_web_menu";
    protected $fillable = [
        'titulo',
        'urlTitulo',
        'logo',
        'pais',
    ];

    public function paises()
    {
        return $this->belongsTo(Paises::class, 'pais', 'id');
    }
}
