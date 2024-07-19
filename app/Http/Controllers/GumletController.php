<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\CheckVideoProgress;
use App\Mail\DownloadStreamLink;
use App\Models\Video;
use Illuminate\Support\Facades\Mail;

class GumletController extends Controller
{

    public function uploadGumlet(Request $request)
    {
        $streamUrl = $request->input('stream_url');
        $title = $request->input('stream_title');

        // Check if the video is already present
        $existingVideo = Video::where('source_url', $streamUrl)
            ->where('title', $title)
            ->where('status', 'completed')
            ->first();
        if (session()->has('USER_DETAILS')) {
            $userEmail = session('USER_DETAILS')['USER_EMAIL']  ?? '';
        }

        if ($existingVideo) {
            Mail::to($userEmail)->send(new DownloadStreamLink([
                'title' => $existingVideo->title,
                'playback_url' => $existingVideo->playback_url,
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Video is already available. You will receive an email with the download link.',
            ]);
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
