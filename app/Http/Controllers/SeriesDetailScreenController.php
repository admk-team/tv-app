<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SeriesDetailScreenController extends Controller
{
    // public function index($id)
    // {
    //     $response = Http::timeout(300)->withHeaders(Api::headers())
    //         ->get(Api::endpoint("/getseriesdetails/{$id}"));

    //     $data = $response->json()['app'];
    //     if ($data['series_details'] === []) {
    //         abort(404);
    //     }
    //     $streamGuId = $data['series_details']['stream_guid'];
    //     $responseRatings = Http::withHeaders(Api::headers())
    //         ->get(Api::endpoint('/userrating/get/' . $streamGuId . '/stream'));
    //     $data['series_details']['ratings'] = $responseRatings->json()['data'];
    //     $streamGuId = $data['series_details']['stream_guid'];
    //     $imdb = $data['series_details']['imdb'];
    //     // dd($data['series_details']['ratings']);

    //     if ($imdb !== "") {
    //         $responseImdb = Http::timeout(300)
    //             ->get("http://www.omdbapi.com/?i={$imdb}&apikey=da5b7118");

    //         $imdbDetails = $responseImdb->json();
    //         if ($imdbDetails !== null && $imdbDetails["Response"] !== "False") {
    //             $data['series_details']['cast'] = $imdbDetails['Actors'];
    //             $data['series_details']['director'] = $imdbDetails['Director'];
    //             $data['series_details']['writer'] = $imdbDetails['Writer'];
    //         }
    //     }
    //     return view("series-detailscreen.index", $data);
    // }

    private function fetchStreamDetails($id)
    {
        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->get(Api::endpoint("/getseriesdetails/{$id}"));
        $data = $response->json()['app'];
        if ($data['series_details'] === []) {
            abort(404);
        }

        $streamGuId = $data['series_details']['stream_guid'];
        $imdb = $data['series_details']['imdb'];

        // Fetch Ratings
        $responseRatings = Http::withHeaders(Api::headers())
            ->get(Api::endpoint('/userrating/get/' . $streamGuId . '/stream'));
        // $data['series_details']['ratings'] = $responseRatings->json()['data'];

        $reviews = $data['series_details']['ratings'] ?? [];
        $data['series_details']['ratings'] = $responseRatings->successful()
            ? $responseRatings->json()['data']
            : [];
        // Fetch IMDb details
        if ($imdb !== "") {
            $responseImdb = Http::timeout(300)
                ->get("http://www.omdbapi.com/?i={$imdb}&apikey=da5b7118");

            $imdbDetails = $responseImdb->json();
            if ($imdbDetails !== null && $imdbDetails["Response"] !== "False") {
                $data['series_details']['cast'] = $imdbDetails['Actors'];
                $data['series_details']['director'] = $imdbDetails['Director'];
                $data['series_details']['writer'] = $imdbDetails['Writer'];
            }
        }
        return $data;
    }

    public function index($id)
    {
        $data = $this->fetchStreamDetails($id);
        // Calculate total reviews and average rating
        $reviews = $data['series_details']['ratings'] ?? [];
        $totalReviews = count($reviews);
        $averageRating = $totalReviews > 0
            ? number_format(array_sum(array_column($reviews, 'rating')) / $totalReviews, 1)
            : '';

        return view("series-detailscreen.index", array_merge($data, [
            'totalReviews' => $totalReviews,
            'averageRating' => $averageRating,
        ]));

        // return view("detailscreen.index", $data); //old way
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
        //need to send total reviews also ???
        $data = $this->fetchStreamDetails($request->stream_code);
        $reviews = $data['series_details']['ratings'] ?? [];
        $totalReviews = count($reviews);
        // Calculate the average rating
        $totalRating = 0;
        foreach ($reviews as $review) {
            $totalRating += $review['rating'];
        }
        $averageRating = $totalReviews > 0 ? number_format($totalRating / $totalReviews, 1) : '';

         // Render updated reviews HTML
         $newReviewHtml = view('series-detailscreen.partials.review', ['reviews' => $data['series_details']['ratings']])->render();
         $ratingIconHtml = view('series-detailscreen.partials.rating-icon', ['ratingsCount' => $totalReviews])->render();
 
         return response()->json([
             'success' => true,
             'newReviewHtml' => $newReviewHtml,
             'ratingIconHtml' => $ratingIconHtml,
             'totalReviews' => $totalReviews ?? '',
             'ratingsCount' => $totalReviews ?? '',
             'averageRating' => $averageRating
         ]);
    }
}
