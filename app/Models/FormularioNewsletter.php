<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormularioNewsletter extends Model
{
    use HasFactory;
    protected $table = "formNewsLetter";
    protected $fillable = [
        'id',
        'email',
        'politica',
        'created_at',
    ];
}
