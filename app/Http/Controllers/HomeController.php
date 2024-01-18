<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index($slug = 'home')
    {
        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->get(Api::endpoint("/{$slug}"));

        $data = json_decode($response->getBody()->getContents());
        if (isset($data->app->app_info->timezone)) {
            config(['app.timezone' => $data->app->app_info->timezone]);
        }
        foreach ($data->app->featured_items->streams ?? [] as $item) {
            $duration = explode(':', $item->stream_duration_timeformat);
            $item->formatted_duration = $duration[0] . ' Hour ' . $duration[1] . ' Minutes';
        }

        if ($slug === "my-favs") {
            $categories = (array) $data->app->categories;
            foreach ($categories['streams'] as $i => $category) {
                $categories['streams'][$i] = (array) $category;
            }
            return view('category.index', compact('categories'));
        }

        $front_data = compact('data', 'slug');
        return view('home.index', $front_data);
    }
}
