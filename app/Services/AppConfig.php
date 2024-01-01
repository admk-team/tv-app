<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AppConfig
{
    private static $data = null;

    public static function get()
    {
        self::fetchData();

        if (!self::$data) {
            self::$data = json_decode(session('api_data'));
        }

        return self::$data;
    }

    public static function fetchData()
    {
        if (!Session::get('api_data')) {
            $response = Http::timeout(300)->withHeaders(Api::headers())
                ->get(Api::endpoint('/masterfeed'));
            Session::put('api_data', $response->body());
        }
    }
}