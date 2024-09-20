<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Services\Api;
use App\Services\AppConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index($slug = 'home')
    {
        Log::info(Carbon::now()->toString());
        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->get(Api::endpoint("/{$slug}"));
        Log::info(Carbon::now()->toString());
        $data = json_decode($response->getBody()->getContents());
        if (isset(\App\Services\AppConfig::get()->app->app_info->timezone)) {
            config(['app.timezone' => \App\Services\AppConfig::get()->app->app_info->timezone]);
        }
        foreach ($data->app->featured_items->streams ?? [] as $item) {
            $duration = explode(':', $item->stream_duration_timeformat);
            $item->formatted_duration = $duration[0] . ' Hour ' . $duration[1] . ' Minutes';
        }

        if (AppConfig::getMenuBySlug($slug)?->menu_type === 'FA') {
            $categories = (array) $data->app->categories;
            foreach ($categories['streams'] as $i => $category) {
                $categories['streams'][$i] = (array) $category;
            }
            return view('category.index', compact('categories'));
        }
        $appName = config('app.name');
        $front_data = compact('data', 'slug', 'appName');

        return view('home.index', $front_data);
    }
}
