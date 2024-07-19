<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\CheckVideoProgress;
use App\Mail\DownloadStreamLink;
use Illuminate\Support\Facades\Mail;

class GumletController extends Controller
{

    public function uploadGumlet(Request $request)
    {
        $request->validate([
            'stream_url' => 'required',
            'stream_title' => 'required',
        ]);
        $client = new Client();
        $body = [
            "format" => 'MP4',
            "input" => $request->stream_url,
            "collection_id" => "64bbfee29f70c7817c4ace2c",
            "profile_id" => "6626ddc24d91ce7d6199d506",
            "title" => $request->stream_title,
            "description" => $request->stream_title,
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
                'status' => 'uploading_gumlet',
                "asset_id" => $responseOutput['asset_id'],
                "source_id" => $responseOutput['source_id'],
                "playback_url" => $responseOutput['output']['playback_url'],
                "thumbnail_url" => $responseOutput['output']['thumbnail_url'],
                "status_url" => $responseOutput['output']['status_url'],
            ];
            CheckVideoProgress::dispatch($videoDetailData['status_url'], $responseOutput);
        }

        return response()->json([
            'success' => true,
            'message' => 'You will receive an Email with download link.',
        ]);
    }
}
