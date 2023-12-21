<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index($slug = 'home')
    {
        $response = Http::withHeaders([
            'happcode' => '7376d3829575f06617d9db3f7f6836df'
        ])
            ->get(env('API_BASE_URL') . "/{$slug}");

        $data = json_decode($response->getBody()->getContents());

            foreach ($data->app->featured_items->streams ?? [] as $item) {
                $duration = explode(':', $item->stream_duration_timeformat);
                $item->formatted_duration = $duration[0] . ' Hour ' . $duration[1] . ' Minutes';
            }

        $front_data = compact('data', 'slug');

        return view('home.index', $front_data);
    }
}
