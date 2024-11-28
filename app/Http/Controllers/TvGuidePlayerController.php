<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TvGuidePlayerController extends Controller
{
    // public function index($channelGuid, $menuSlug)
    // {
    //     // $menuSlug = 'live-tv-guide';

    //     $response = Http::timeout(300)->withHeaders(Api::headers())
    //         ->get(Api::endpoint("/{$menuSlug}"));

    //     $tvGuideData = json_decode($response->getBody()->getContents());

    //     if (isset($tvGuideData->app->app_info->timezone)) {
    //         config(['app.timezone' => $tvGuideData->app->app_info->timezone]);
    //     }

    //     $data = ['channelGuid' => $channelGuid, 'arrRes' => $tvGuideData];
    //     return view('tv-guide.tv-guide-player', $data);
    // }
    public function getChannelStreams($channelCode)
    {
        $currentTime = Carbon::now();
        $response = $this->fetchChannelPlaylists($channelCode);
        $channel = collect($response['channels'])->firstWhere('code', $channelCode);
        $playlists = $channel['playlists'] ?? [];
        if (!$channel || empty($playlists)) {
            return abort(404, 'No streams exist for this channel.');
        }

        $hasStreams = collect($playlists)->contains(function ($playlist) {
            return !empty($playlist['streams']);
        });
        if (!$hasStreams) {
            return abort(404, 'No streams exist for this channel.');
        }

        $currentPlaylist = null;

        foreach ($playlists as $playlist) {
            $startTime = Carbon::parse($playlist['start_time']);
            $endTime = Carbon::parse($playlist['end_time']);
            if ($currentTime->between($startTime, $endTime)) {
                $currentPlaylist = $playlist;
                break;
            }
        }
        if (isset($currentPlaylist['streams']) && is_array($currentPlaylist['streams'])) {
            $streams = array_map(function ($stream) {
                return [
                    'code' => $stream['code'],
                    'title' => $stream['title'],
                    'url' => $stream['url'],
                    'poster' => '',
                ];
            }, $currentPlaylist['streams']);
        }
        return view('tv-guide.tv-guide-player', compact('streams'));
    }

    private function fetchChannelPlaylists($channelCode)
    {
        $response = Http::timeout(300)->withHeaders(Api::headers())
        ->asForm()
        ->get(Api::endpoint("/live-tv-guide/channel/{$channelCode}"));
        $responseJson = $response->json();

        return $responseJson;
    }
}
