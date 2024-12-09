<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchParty extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'app_code', 'stream_code', 'code', 'start_date', 'start_time', 'end_date', 'end_time'];
}
