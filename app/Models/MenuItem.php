<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;
    protected $table = "pagina_web_menu_item";
    protected $fillable = [
        'idMenu',
        'nombre',
        'url',
        'logo',
        'pais',
        'orden'
    ];
}
