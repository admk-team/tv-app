<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use App\Models\GumletVideo;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class GumletVideoUploadStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $videoDetailid;
    public $asset_id;

    /**
     * Create a new job instance.
     */
    public function __construct(int $videoid)
    {
        $videoDetail = GumletVideo::findOrFail($videoid);
        $this->videoDetailid = $videoid;
        $this->asset_id = $videoDetail->asset_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $output = $this->apiCall();

        if ($output['progress'] === 100) {
            $video = GumletVideo::findOrFail($this->videoDetailid);
            $video->update(['status' => 'uploaded_gumlet']);
            Storage::disk('wasabi')->delete('gumletfiles/' . $video->file_path);
        } else {
            self::dispatch($this->videoDetailid)->delay(now()->addMinutes(2));
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
