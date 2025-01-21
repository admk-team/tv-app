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
    public function index(Request $request ,$slug = 'home')
    {
        Log::info(Carbon::now()->toString());
        // Construct the full URL from the request
        $currentUrl = $request->fullUrl();
        $link = $request->query('link');
        // Check if the session already has the 'visited_url' set
        if ($link) {
            if (!session()->has('partner_url')) {
                // If not, store the full URL in the session
                session(['partner_url' => $currentUrl]);
                Log::info('URL set in session: ' . $currentUrl);
                if(session('partner_url')){
                    $response = Http::timeout(300)->withHeaders(Api::headers())
                    ->asForm()
                    ->post(Api::endpoint("/partner-link-count"), [
                        'partner_url' => session('partner_url'),
                    ]);
                $responseJson = $response->json();
                }
            }
        }
        $referral_link = $request->query('referral_link');
        if($referral_link){
            if (!session()->has('referral_link')) 
                {
                    session(['referral_link' => $currentUrl]); 
                }
        }

        $xyz = base64_encode(request()->ip());
        if (env('NO_IP_ADDRESS') === true) { // For localhost
            $xyz = "MTU0LjE5Mi4xMzguMzY=";
        }

        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->get(Api::endpoint("/{$slug}?user_data={$xyz}"));
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
