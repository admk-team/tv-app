<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\DownloadStreamLink;
use App\Models\Video;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class CheckVideoProgress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $videoDetailid;
    public $asset_id;
    public $user_email;

    public function __construct($videoid, $userEmail)
    {

        $videoDetail = Video::findOrFail($videoid);
        $this->videoDetailid = $videoid;
        $this->asset_id = $videoDetail->asset_id;
        $this->user_email = $userEmail;
    }

    public function handle()
    {
        $output = $this->apiCall();

        if ($output['progress'] === 100) {
            $video = Video::findOrFail($this->videoDetailid);
            $video->update(['status' => 'completed']);
            $data = [
                'id' => $video->id,
                'title' => $video->title,
            ];
            Mail::to($this->user_email)->send(new DownloadStreamLink($data));
        } else {
            self::dispatch($this->videoDetailid, $this->user_email)->delay(now()->addMinutes(2));
        }
    }

    public function apiCall()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://api.gumlet.com/v1/video/assets/' . $this->asset_id, [
            'headers' => [
                'Authorization' => 'Bearer ' . env('GUMLET_API_TOKEN'),
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
        ]);
        $responseOutput = json_decode($response->getBody(), true);
        return $responseOutput;
    }
}
