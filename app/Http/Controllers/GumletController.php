<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\CheckVideoProgress;
use App\Models\Video;


class GumletController extends Controller
{

    public function uploadGumlet(Request $request)
    {
        $streamUrl = $request->input('stream_url');
        $title = $request->input('stream_title');

        $video = Video::where('source_url', $streamUrl)
            ->where('title', $title)
            ->where('status', 'completed')
            ->first();

        if ($video) {
            // $response = Http::get($video->playback_url);
            // return response($response->body(), 200)
            //     ->header('Content-Type', $response->header('Content-Type'))
            //     ->header('Content-Disposition', 'attachment; filename="video.mp4"');
            return redirect($video->playback_url)->header('Content-Type', 'video/mp4')
            ->header('Content-Disposition', 'attachment; filename="video.mp4"');
        }


        // Proceed with the conversion if video is not present
        $client = new Client();
        $body = [
            'title' => $title,
            "format" => 'MP4',
            "input" => $request->stream_url,
            "collection_id" => "64bbfee29f70c7817c4ace2c",
            "profile_id" => "6626ddc24d91ce7d6199d506",
        ];

        $response = $client->request('POST', 'https://api.gumlet.com/v1/video/assets', [
            'body' => json_encode($body),
            'headers' => [
                'Authorization' => 'Bearer ' . env('GUMLET_API_TOKEN'),
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
        ]);

        if ($response->getBody()) {
            $responseOutput = json_decode($response->getBody(), true);
            $videoDetailData = [
                'status' => 'processing',
                'asset_id' => $responseOutput['asset_id'],
                'source_id' => $responseOutput['source_id'],
                'playback_url' => $responseOutput['output']['playback_url'],
                'thumbnail_url' => $responseOutput['output']['thumbnail_url'][0],
                'status_url' => $responseOutput['output']['status_url'],
                'source_url' => $streamUrl,
                'title' => $title,
            ];

            $video = Video::create($videoDetailData);

            CheckVideoProgress::dispatch($video->id, $videoDetailData);

            return response()->json([
                'success' => true,
                'message' => 'You will receive an email with the download link once the video is processed.',
            ]);
        }
    }
}
