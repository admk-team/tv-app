<?php

namespace App\Services;

class Api
{
    public static function endpoint($endpoint)
    {
        return env("API_BASE_URL") . $endpoint;
    }

    public static function headers($headers = [])
    {
        return array_merge([
            'happcode' => env('APP_CODE')
        ], $headers);
    }
}