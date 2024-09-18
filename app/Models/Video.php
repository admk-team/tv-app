<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'source_url', 'asset_id', 'source_id', 'playback_url', 'thumbnail_url', 'status_url', 'status'];
}
