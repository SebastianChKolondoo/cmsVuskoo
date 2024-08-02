<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $table = "events";
    protected $fillable = [
        'event_type',
        'source',
        'message',
        'country_code',
        'instance',
        'route',
        'calling_IP',
    ];
}
