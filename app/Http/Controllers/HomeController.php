<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Services\Api;
use App\Services\AppConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(Request $request, $slug = 'home')
    {
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }
        $currentUrl = $request->fullUrl();
        $link = $request->query('link');

        // Handle partner link tracking
        if ($link) {
            if (!session()->has('partner_url')) {
                session(['partner_url' => $currentUrl]);
                Log::info('URL set in session: ' . $currentUrl);
                if (session('partner_url')) {
                    try {
                        Http::timeout(300)->withHeaders(Api::headers())
                            ->asForm()
                            ->post(Api::endpoint("/partner-link-count"), [
                                'partner_url' => session('partner_url'),
                            ]);
                    } catch (\Exception $e) {
                        Log::error("Partner link count API error: " . $e->getMessage());
                    }
                }
            }
        }

        // Handle referral link
        if ($referral_link = $request->query('referral_link')) {
            if (!session()->has('referral_link')) {
                session(['referral_link' => $currentUrl]);
            }
        }

        // Prepare encoded IP
        $xyz = base64_encode($request->ip());
        if (env('NO_IP_ADDRESS') === true) {
            $xyz = "MTU0LjE5Mi4xMzguMzY="; // Default IP for local testing
        }

        // Cache key based on slug and IP (xyz)
        $cacheKey = "page_data_{$slug}_{$xyz}";

        $data = Cache::remember($cacheKey, now()->addMinutes(2), function () use ($slug, $xyz, $cacheKey) {
            try {
                $response = Http::timeout(300)->withHeaders(Api::headers())
                    ->get(Api::endpoint("/{$slug}?user_data={$xyz}"));

                return json_decode($response->getBody()->getContents());
            } catch (\Exception $e) {
                Log::error("API error for slug `{$slug}`: " . $e->getMessage());
                return null;
            }
        });

        if (!$data) {
            abort(500, 'Failed to load content from API.');
        }

        // Set app timezone dynamically
        if (isset(\App\Services\AppConfig::get()->app->app_info->timezone)) {
            config(['app.timezone' => \App\Services\AppConfig::get()->app->app_info->timezone]);
        }

        // Format duration
        foreach ($data->app->featured_items->streams ?? [] as $item) {
            $duration = explode(':', $item->stream_duration_timeformat);
            $item->formatted_duration = $duration[0] . ' Hour ' . $duration[1] . ' Minutes';
        }

        // If menu type is 'FA' (Featured App)
        if (AppConfig::getMenuBySlug($slug)?->menu_type === 'FA') {
            $categories = (array) $data->app->categories;
            foreach ($categories['streams'] as $i => $category) {
                $categories['streams'][$i] = (array) $category;
            }
            return view('category.index', compact('categories'));
        }

        // Render home
        $appName = config('app.name');
        $front_data = compact('data', 'slug', 'appName');

        return view('home.index', $front_data);
    }

    // public function index(Request $request, $slug = 'home')
    // {
    //     // Construct the full URL from the request
    //     $currentUrl = $request->fullUrl();
    //     $link = $request->query('link');
    //     // Check if the session already has the 'visited_url' set
    //     if ($link) {
    //         if (!session()->has('partner_url')) {
    //             // If not, store the full URL in the session
    //             session(['partner_url' => $currentUrl]);
    //             Log::info('URL set in session: ' . $currentUrl);
    //             if (session('partner_url')) {
    //                 $response = Http::timeout(300)->withHeaders(Api::headers())
    //                     ->asForm()
    //                     ->post(Api::endpoint("/partner-link-count"), [
    //                         'partner_url' => session('partner_url'),
    //                     ]);
    //                 $responseJson = $response->json();
    //             }
    //         }
    //     }
    //     $referral_link = $request->query('referral_link');
    //     if ($referral_link) {
    //         if (!session()->has('referral_link')) {
    //             session(['referral_link' => $currentUrl]);
    //         }
    //     }

    //     $xyz = base64_encode(request()->ip());
    //     if (env('NO_IP_ADDRESS') === true) { // For localhost
    //         $xyz = "MTU0LjE5Mi4xMzguMzY=";
    //     }

    //     $response = Http::timeout(300)->withHeaders(Api::headers())
    //         ->get(Api::endpoint("/{$slug}?user_data={$xyz}"));
    //     $data = json_decode($response->getBody()->getContents());
    //     if (isset(\App\Services\AppConfig::get()->app->app_info->timezone)) {
    //         config(['app.timezone' => \App\Services\AppConfig::get()->app->app_info->timezone]);
    //     }
    //     foreach ($data->app->featured_items->streams ?? [] as $item) {
    //         $duration = explode(':', $item->stream_duration_timeformat);
    //         $item->formatted_duration = $duration[0] . ' Hour ' . $duration[1] . ' Minutes';
    //     }

    //     if (AppConfig::getMenuBySlug($slug)?->menu_type === 'FA') {
    //         $categories = (array) $data->app->categories;
    //         foreach ($categories['streams'] as $i => $category) {
    //             $categories['streams'][$i] = (array) $category;
    //         }
    //         return view('category.index', compact('categories'));
    //     }
    //     $appName = config('app.name');
    //     $front_data = compact('data', 'slug', 'appName');

    //     return view('home.index', $front_data);
    // }
}
