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

    public function __construct($videoId)
    {
        $this->videoId = $videoId;
    }

    public function handle()
    {
        $client = new Client();
        $video = Video::find($this->videoId);

        if (!$video) {
            Log::error('Video not found: ' . $this->videoId);
            return;
        }
        $statusUrl = $video->status_url;

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
            if (is_null($statusOutput) || !isset($statusOutput['progress'])) {
                Log::error('Invalid response from status URL: ' . $statusUrl);
                break;
            }
            $progress = $statusOutput['progress'];

            if ($progress == 100) {
                // Update video status in the database
                $video->update([
                    'status' => 'completed',
                    'playback_url' => $statusOutput['output']['playback_url'],
                ]);

                $data = [
                    'id' => $video->id,
                    'title' => $video->title,
                ];
                if (session()->has('USER_DETAILS')) {
                    $userEmail =  session('USER_DETAILS')['USER_EMAIL'];
                }
                Mail::to($userEmail)->send(new DownloadStreamLink($data));
                break;
            }

            // Sleep for a while before checking again (e.g., 10 seconds)
            sleep(10);
        } while ($progress < 99);
    }

    public function failed(Throwable $exception)
    {
        Log::error("Error in CheckVideoProgress job: " . $exception->getMessage());
    }

}
