<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCupon extends Model
{
    use HasFactory;
    protected $table = "TipoCupon";
    protected $fillable = [
        'nombre',
    ];
}
