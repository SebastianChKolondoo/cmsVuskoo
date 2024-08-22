<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormularioContactenos extends Model
{
    use HasFactory;
    protected $table = "formContactanos";
    protected $fillable = [
        'id',
        'name',
        'message',
        'email',
        'politica',
        'created_at',
    ];

    public function politicas()
    {
        return $this->belongsTo(States::class, 'politica', 'id');
    }
}
