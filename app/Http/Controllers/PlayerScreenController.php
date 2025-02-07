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
        $data = $this->fetchStreamDetails($id);
        if (isset($data['errorView'])) {
            return $data['errorView'];
        }
        return view("playerscreen.index", $data);
    }

    private function fetchStreamDetails($id)
    {
        $xyz = base64_encode(request()->ip());
        if (env('NO_IP_ADDRESS') === true) { // For localhost
            $xyz = "MTU0LjE5Mi4xMzguMzY=";
        }

        // Fetch stream details
        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->get(Api::endpoint("/getitemplayerdetail/{$id}?user_data={$xyz}"));
        $data = $response->json();

        // if ($data['app']['stream_details'] === []) {
        //     if ($data['geoerror'] ?? null) {
        //         return view("page.movienotexist");
        //     }
        //     abort(404);
        // }
        // if ($data['app']['stream_details'] === []) {
        //     if ($data['geoerror'] ?? null) {
        //         return ['errorView' => view("page.movienotexist")];
        //     }
        //     abort(404);
        // }
        if (!empty($data['app']['early_message'])) {
            abort(404, __('Sorry, this content is available only for Early Screening members. Please subscribe to an Early Screening membership plan to watch.'));
        }

        if (empty($data['app']['stream_details'])) {
            if ($data['geoerror'] ?? null) {
                return ['errorView' => view("page.movienotexist")];
            }
            abort(404, __('Sorry, You Don’t Have Access to This Content.'));
        }
        // Extract necessary details
        $limitWatchTime = $data['app']['app_info']['limit_watch_time'];
        $watchTimeDuration = $data['app']['app_info']['watch_time_duration'];
        $streamGuId = $data['app']['stream_details']['stream_guid'];

        // Fetch ratings
        $responseRatings = Http::withHeaders(Api::headers())
            ->get(Api::endpoint('/userrating/get/' . $streamGuId . '/stream'));
        $ratings = $responseRatings->json()['data'];

        $streamRatingStatus = $data['app']['stream_details']['video_rating'] ?? null;
        $streamRatingType = $data['app']['stream_details']['rating_type'] ?? null;

        $ratingsCount = count($ratings);
        $totalRating = 0;
        $totalReviews = count($ratings);
        if ($ratingsCount > 0) {
            foreach ($ratings as $review) {
                $totalRating += $review['rating'];
            }
            $averageRating = $totalRating / $ratingsCount;
            $averageRating = number_format($averageRating, 1);
        } else {
            $averageRating = 0;
        }
        // Return data as an associative array
        return [
            'arrRes' => $data,
            'streamGuid' => $id,
            'limitWatchTime' => $limitWatchTime,
            'watchTimeDuration' => $watchTimeDuration,
            'streamratingstatus' => $streamRatingStatus,
            'streamratingtype' => $streamRatingType,
            'streamrating' => $ratings,
            'ratingsCount' => $totalReviews,
            'totalReviews' => $totalReviews,
            'averageRating' => $averageRating,
        ];
    }

    public function addRating(Request $request)
    {
        $ratingField = $request->has('rating_mobile') ? 'rating_mobile' : 'rating';

        $request->validate([
            $ratingField => 'required',
        ], [
            $ratingField . '.required' => 'Please rate the stream',
        ]);

        $rating = $request->input($ratingField);

        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->timeout(300)
            ->post(Api::endpoint('/userrating/store'), [
                'app_code' => env('APP_CODE'),
                'user_id' => session('USER_DETAILS')['USER_ID'],
                'rating' => $rating,
                'comment' => $request->comment ?? '',
                'stream_code' => $request->type === 'stream' ? $request->stream_code : '',
                'show_code' => $request->type === 'show' ? $request->stream_code : '',
            ]);

        $responseJson = $response->json();

        if (!$responseJson['success']) {
            return response()->json([
                'success' => false,
                'message' => $responseJson['message'],
            ]);
        }

        // Fetch updated ratings
        $data = $this->fetchStreamDetails($request->stream_code);
        $reviews = $data['streamrating'] ?? [];
        $totalReviews = count($reviews);
        // Calculate the average rating
        $totalRating = 0;
        foreach ($reviews as $review) {
            $totalRating += $review['rating'];
        }
        $averageRating = $totalReviews > 0 ? number_format($totalRating / $totalReviews, 1) : 0;

        $newReviewHtml = view('playerscreen.includes.review', ['reviews' => $data['streamrating']])->render();

        return response()->json([
            'success' => true,
            'newReviewHtml' => $newReviewHtml,
            'totalReviews' => $totalReviews ?? '',
            'ratingsCount' => $totalReviews ?? '',
            'averageRating' => $averageRating
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
