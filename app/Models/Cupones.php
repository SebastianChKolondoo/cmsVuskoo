<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupones extends Model
{
    use HasFactory;
    protected $table = "WEB_3_TARIFAS_CUPONES";
    protected $fillable = [
        'comercio',
        'codigo',
        'titulo',
        'descripcion',
        'label',
        'CodigoCupon',
        'featured',
        'source',
        'deeplink',
        'affiliate_link',
        'cashback_link',
        'url',
        'image_url',
        'tipoCupon',
        'merchant_home_page',
        'fecha_inicial',
        'fecha_final',
        'estado',
        'pais',
        'destacada',
        'TiempoCupon'
    ];

    public function state()
    {
        return $this->belongsTo(States::class, 'estado', 'id');
    }

    public function comercios()
    {
        return $this->belongsTo(Comercios::class, 'comercio', 'id');
    }

    public function paises()
    {
        return $this->belongsTo(Paises::class, 'pais', 'id');
    }

    public function categorias()
    {
        return $this->belongsTo(Categorias::class, 'categoria', 'id');
    }
    
    public function tipoCupones()
    {
        return $this->belongsTo(TipoCupon::class, 'tipoCupon', 'id');
    }
}
