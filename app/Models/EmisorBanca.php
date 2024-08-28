<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmisorBanca extends Model
{
    use HasFactory;
    protected $table = "emisor_banca";
    protected $fillable = [
        'nombre',
    ];        
}
