<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class PlayerScreenController extends Controller
{
    public function index($id)
    {
        $xyz = base64_encode(request()->ip());
        if (env('NO_IP_ADDRESS') === true) { // For localhost
            $xyz = "MTU0LjE5Mi4xMzguMzY=";
        }

        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->get(Api::endpoint("/getitemplayerdetail/{$id}?user_data={$xyz}"));
        $data = $response->json();
        if ($data['app']['stream_details'] === []) {
            if ($data['geoerror'] ?? null) {
                return view("page.movienotexist");
            }
            abort(404);
        }
        $limitWatchTime = $data['app']['app_info']['limit_watch_time'];
        $watchTimeDuration = $data['app']['app_info']['watch_time_duration'];

        $streamGuId = $data['app']['stream_details']['stream_guid'];
        $responseRatings = Http::withHeaders(Api::headers())
            ->get(Api::endpoint('/userrating/get/' . $streamGuId . '/stream'));
        $data['app']['stream_details']['ratings'] = $responseRatings->json()['data'];

        $streamRatingStatus = $data['app']['stream_details']['video_rating'] ?? null;
        $streamRatingType = $data['app']['stream_details']['rating_type'] ?? null;
        $streamRating= $data['app']['stream_details']['ratings'] ?? [];

        return view("playerscreen.index", [
            'arrRes' => $data,
            'streamGuid' => $id,
            'limitWatchTime' => $limitWatchTime,
            'watchTimeDuration' => $watchTimeDuration,
            'streamratingstatus' =>  $streamRatingStatus,
            'streamratingtype' =>  $streamRatingType,
            'streamrating' => $streamRating,
        ]);
    }

    public function private($id)
    {
        $xyz = base64_encode(request()->ip());
        if (env('NO_IP_ADDRESS') === true) { // For localhost
            $xyz = "MTU0LjE5Mi4xMzguMzY=";
        }

        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->get(Api::endpoint("/getprivateitemplayerdetail/{$id}?user_data={$xyz}"));

        $data = $response->json();
        if ($data['app']['stream_details'] === []) {
            if ($data['geoerror'] ?? null) {
                return view("page.movienotexist");
            }
            abort(404);
        }

        $limitWatchTime = $data['app']['app_info']['limit_watch_time'];
        $watchTimeDuration = $data['app']['app_info']['watch_time_duration'];


        return view("playerscreen.private", [
            'arrRes' => $data,
            'streamGuid' => $id,
            'limitWatchTime' => $limitWatchTime,
            'watchTimeDuration' => $watchTimeDuration,
        ]);
    }

    public function checkPassword(Request $request)
    {
        $streamPassword = null;
        try {
            $streamPassword = Crypt::decryptString($request->key);
        } catch (\Exception $e) {
        }

        if (password_verify($request->password, $streamPassword)) {
            if (session('protectedContentAccess') === null)
                session('protectedContentAccess', []);
            session()->push('protectedContentAccess', $request->stream_guid);
        } else {
            session()->flash('error', 'Incorrect Password');
        }

        return back();
    }

    public function checkScreenerPassword(Request $request)
    {
        $streamPassword = null;
        try {
            $streamPassword = Crypt::decryptString($request->key);
        } catch (\Exception $e) {
        }

        if (request()->password == $streamPassword) {
            session('GLOBAL_PASS', 0);
            header("Location: " . $request->shortUrl);
            die();
        } else {
            session('error', 'Incorrect Password');
        }
        header("Location: " . $request->fullUrl);
        die();
    }

    public function extraVideo(Request $request)
    {
        // Retrieve video data from the request body
        $playbackUrl = $request->input('playback_url');
        $thumbnail = $request->input('thumbnail');
        $title = $request->input('title');
        $description = $request->input('description');

        // Pass variables to the view
        return view('playerscreen.extra_video', compact('playbackUrl', 'thumbnail', 'title', 'description'));
    }
}
