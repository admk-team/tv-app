<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\DownloadStreamLink;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class CheckVideoProgress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $statusUrl;
    protected $videoDetailData;
    /**
     * Create a new job instance.
     */
    public function __construct($statusUrl, $videoDetailData)
    {
        $this->statusUrl = $statusUrl;
        $this->videoDetailData = $videoDetailData;
    }

    public function handle()
    {
        $client = new \GuzzleHttp\Client();

        do {
            $response = $client->request('GET', $this->statusUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('GUMLET_API_TOKEN'),
                    'accept' => 'application/json',
                ],
            ]);

            $statusOutput = json_decode($response->getBody(), true);
            $progress = $statusOutput['progress'];

            if ($progress == 100) {

                $recipient = 'usamaramzan978@gmail.com';
                Mail::to($recipient)->send(new DownloadStreamLink($this->videoDetailData));
                break;
            }
            // Sleep for a while before checking again (e.g., 10 seconds)
            sleep(10);
        } while ($progress < 100);
    }

    public function failed(): void
    {
        logger()->error("error on job");
    }
}
