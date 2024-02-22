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
        $defaultHeaders = [
            'happcode' => env('APP_CODE')
        ];

        if (session('USER_DETAILS.USER_CODE'))
            $defaultHeaders['husercode'] = session('USER_DETAILS.USER_CODE');

        if (session('USER_DETAILS.USER_PROFILE'))
            $defaultHeaders['huserprofile'] = session('USER_DETAILS.USER_PROFILE');

        return array_merge($defaultHeaders, $headers);
    }
}
