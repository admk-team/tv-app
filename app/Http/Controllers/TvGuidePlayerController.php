<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class TvGuidePlayerController extends Controller
{
    public function index($channelGuid, $menuSlug)
    {
        $data = $this->fetchChannelPlaylists($channelGuid);

        $data = ['channelGuid' => $channelGuid, 'data' => $data];
        return view('tv-guide.tv-guide-player', $data);
    }

    private function fetchChannelPlaylists($channelCode)
    {
        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint("/live-tv-guide/channel/{$channelCode}"));
        $responseJson = $response->json();

        return $responseJson;
    }

    public function watchTvGuideStreams(Request $request)
    {
        if (!$request->has('data')) {
            return abort(404, 'Missing data');
        }
        try {
            $decryptedStreams = Crypt::decrypt($request->query('data'));
        } catch (\Exception $e) {
            return abort(403, $e->getMessage());
        }

        return view('tv-guide.tv-guide-group-streams', compact('decryptedStreams'));
    }

    public function indexRender($channelGuid)
    {
        $data = $this->fetchChannelPlaylists($channelGuid);

        $data = ['channelGuid' => $channelGuid, 'data' => $data];
        $newHtml = view('tv-guide.tv-guide-player', $data)->render();
        // Load HTML into DOMDocument
        $dom = new \DOMDocument();

        // Suppress warnings due to malformed HTML by using @
        @$dom->loadHTML($newHtml);

        // Find the element with the specific ID you want to extract
        $elementId = 'render-page';
        $element = $dom->getElementById($elementId);

        if ($element) {
            // Save that element as HTML string
            $extractedHtml = $dom->saveHTML($element);
            return response()->json([
                'success' => true,
                'newHtml' => $extractedHtml
            ]);
        } else {
            return response()->json([
                'success' => false,
                'newHtml' => null
            ]);
        }
    }
}
