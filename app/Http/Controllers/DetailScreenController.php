<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DetailScreenController extends Controller
{
    private function fetchStreamDetails($id)
    {
        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->get(Api::endpoint("/getitemdetail/{$id}"));

        $data = $response->json()['app'];
        if ($data['stream_details'] === []) {
            abort(404);
        }

        $streamGuId = $data['stream_details']['stream_guid'];
        $imdb = $data['stream_details']['imdb'];

        // Fetch Ratings
        $responseRatings = Http::withHeaders(Api::headers())
            ->get(Api::endpoint('/userrating/get/' . $streamGuId . '/stream'));
        $data['stream_details']['ratings'] = $responseRatings->json()['data'];

        // Fetch IMDb details
        if ($imdb !== "") {
            $responseImdb = Http::timeout(300)
                ->get("http://www.omdbapi.com/?i={$imdb}&apikey=da5b7118");

            $imdbDetails = $responseImdb->json();
            if ($imdbDetails !== null && $imdbDetails["Response"] !== "False") {
                $data['stream_details']['cast'] = $imdbDetails['Actors'];
                $data['stream_details']['director'] = $imdbDetails['Director'];
                $data['stream_details']['writer'] = $imdbDetails['Writer'];
            }
        }

        return $data;
    }

    public function index($id)
    {
        $data = $this->fetchStreamDetails($id);
        return view("detailscreen.index", $data);
    }


    public function addRating(Request $request)
    {
        $ratingField = $request->has('rating_mobile') ? 'rating_mobile' : 'rating';

        $request->validate([$ratingField => 'required',
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

        // Render updated reviews HTML
        $newReviewHtml = view('detailscreen.partials.review', ['reviews' => $data['stream_details']['ratings']])->render();

        return response()->json([
            'success' => true,
            'newReviewHtml' => $newReviewHtml,
        ]);
    }


}
