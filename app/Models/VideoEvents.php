<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoEvents extends Model
{
    use HasFactory;
    protected $fillable = [
        'watch_party_code',
        'event_type',
        'instance_name',
        'seek_value',
        'current_volume',
        'current_time',
        'duration',
        'counter',
        'media_info'
    ];
}
