<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\CheckVideoProgress;
use App\Models\Video;
use App\Services\Api;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GumletController extends Controller
{

    public function uploadGumlet(Request $request)
    {
        $streamUrl = $request->input('stream_url');
        $title = $request->input('stream_title');
        $streamDescription = $request->input('stream_description');
        $email = $request->input('email');

        // Make the API request
        $response = Http::timeout(300)
            ->withHeaders(Api::headers())
            ->post(Api::endpoint('/video'), [
                'stream_url' => $streamUrl,
                'stream_title' => $title,
            'email' => $email,
            'stream_description' => $streamDescription,
            ]);

        // Handle the response
        $responseData = $response->json();

        if (!$response->successful()) {
            return back()->withErrors(['error' => 'Failed to process video. Please try again.']);
        }

        if ($responseData['status'] == 'pending') {
            return back()->with('message', $responseData['message']);
        } else {
            $videoUrl = $responseData['video_url'];
            $response = Http::head($videoUrl);
            if (!$response->successful()) {
                return response()->json(['error' => 'Failed to fetch video headers'], 500);
            }
            $contentType = $response->header('Content-Type', 'application/octet-stream');
            $contentLength = $response->header('Content-Length');

            return response()->stream(function () use ($videoUrl) {
                $stream = fopen($videoUrl, 'r');
                while (!feof($stream)) {
                    echo fread($stream, 8192);
                    flush();
                }
                fclose($stream);
            }, 200, [
                'Content-Type' => $contentType,
                'Content-Disposition' => 'attachment; filename="video.mp4"',
                'Content-Transfer-Encoding' => 'binary',
                'Content-Length' => $contentLength,
            ]);
        }
    }

}
