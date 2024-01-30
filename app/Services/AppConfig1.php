<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AppConfig
{
    private static $data = null;

    public static function get()
    {
        self::fetchData();

        // if (!self::$data) {
        //     self::$data = json_decode(session('api_data'));
        // }

        return self::$data;
    }

    public static function fetchData()
    {
        if (!self::$data) {
            $finalresultDevice = null;
            // Get the user agent string
            $userAgent = $_SERVER['HTTP_USER_AGENT'];

            // Check if the user agent indicates a mobile device
            $isMobile = (bool)preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i', $userAgent);

            // Check if the user agent indicates a tablet device
            $isTablet = (bool)preg_match('/iPad|Android|Tablet/i', $userAgent);

            // Initialize a variable to store the matched browser
            $matchedBrowser = "Unknown";

            // Detect browsers
            if (strpos($userAgent, 'Chrome') !== false) {
                $matchedBrowser = "Chrome";
            } elseif (strpos($userAgent, 'Firefox') !== false) {
                $matchedBrowser = "Firefox";
            } elseif (strpos($userAgent, 'Safari') !== false) {
                $matchedBrowser = "Safari";
            } elseif (strpos($userAgent, 'Edge') !== false) {
                $matchedBrowser = "Microsoft Edge";
            } elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident/') !== false) {
                $matchedBrowser = "Internet Explorer";
            }

            // Output the information
            // echo "Is Mobile: " . ($isMobile ? 'Yes' : 'No') . "<br>";
            // echo "Is Tablet: " . ($isTablet ? 'Yes' : 'No') . "<br>";
            $mobile = $isMobile ? true : false;
            $tablet = $isTablet ? true : false;
            if ($mobile) {
                $finalresultDevice = 'mobile';
            } elseif ($isTablet) {
                $finalresultDevice = 'tablet';
            } else {
                $finalresultDevice = $matchedBrowser;
            }

            $xyz = base64_encode(request()->ip());
            $response = Http::timeout(300)->withHeaders(Api::headers())
                ->get(Api::endpoint("/masterfeed?user_data={$xyz}&user_device={$finalresultDevice}"));


            // Session::put('api_data', $response->body());
            self::$data = json_decode($response->body());
        }
    }

    public static function getMenuBySlug($slug)
    {
        foreach (self::get()->app->menus as $menu)
            if ($menu->menu_slug === $slug)
                return $menu;

        return null;
    }
}
