<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banca extends Model
{
    use HasFactory;
    protected $table = '1_banca';

    protected $fillable = [
        'nombre',
        'logo'
    ];
}
