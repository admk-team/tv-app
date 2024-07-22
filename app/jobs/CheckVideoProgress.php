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

    protected $videoId;
    protected $videoDetailData;

    public function __construct($videoId, $videoDetailData)
    {
        $this->videoId = $videoId;
        $this->videoDetailData = $videoDetailData;
    }

    public function handle()
    {
        $client = new Client();
        $video = Video::find($this->videoId);
        $statusUrl = $this->videoDetailData['status_url'];

        if (!filter_var($statusUrl, FILTER_VALIDATE_URL)) {
            Log::error('Invalid status URL: ' . $statusUrl);
            return;
        }

        do {
            $response = $client->request('GET', $statusUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('GUMLET_API_TOKEN'),
                    'accept' => 'application/json',
                ],
            ]);

            $statusOutput = json_decode($response->getBody(), true);
            $progress = $statusOutput['progress'];

            if ($progress == 100) {
                // Update video status in the database
                $video->update([
                    'status' => 'completed',
                    'playback_url' => $statusOutput['output']['playback_url'],
                    // 'thumbnail_url' => $statusOutput['output']['thumbnail_url'],
                ]);

                $this->sendCompletionEmail($statusOutput);
                break;
            }

            // Sleep for a while before checking again (e.g., 10 seconds)
            sleep(10);
        } while ($progress < 100);
    }

    protected function sendCompletionEmail($statusOutput)
    {
        $data = [
            'title' => $this->videoDetailData['title'],
            'playback_url' => $statusOutput['output']['playback_url'],
        ];

        Mail::to('recipient@example.com')->send(new DownloadStreamLink($data));
    }

    public function failed(): void
    {
        logger()->error("error on job");
    }
}
