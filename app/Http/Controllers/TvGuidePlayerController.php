<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TvGuidePlayerController extends Controller
{
    public function index($channelGuid)
    {
        $menuSlug = 'live-tv-guide';

        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->get(Api::endpoint("/{$menuSlug}"));

        $tvGuideData = json_decode($response->getBody()->getContents());

        if (isset($tvGuideData->app->app_info->timezone)) {
            config(['app.timezone' => $tvGuideData->app->app_info->timezone]);
        }

        $data = ['channelGuid' => $channelGuid, 'arrRes' => $tvGuideData];
        return view('tv-guide.tv-guide-player', $data);
    }
}
