<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppCofig extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_code',
        'api_data'
    ];
}
