<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class DetailScreenController extends Controller
{
    private function fetchStreamDetails($id)
    {
        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->get(Api::endpoint("/getitemdetail/{$id}"));

        $data = $response->json()['app'];
        // Dynamic Error Handling
        if (!empty($data['early_message'])) {
            abort(404, __('Sorry, this content is available only for Early Screening members. Please subscribe to an Early Screening membership plan to watch.'));
        }

        if (empty($data['stream_details'])) {
            abort(404, __('Sorry, You Don’t Have Access to This Content.'));
        }

        $streamGuId = $data['stream_details']['stream_guid'];
        $imdb = $data['stream_details']['imdb'];

        // Fetch Ratings
        $responseRatings = Http::withHeaders(Api::headers())
            ->get(Api::endpoint('/userrating/get/' . $streamGuId . '/stream'));
        // $data['stream_details']['ratings'] = $responseRatings->json()['data'];

        $reviews = $data['stream_details']['ratings'] ?? [];
        $data['stream_details']['ratings'] = $responseRatings->successful()
            ? $responseRatings->json()['data']
            : [];
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
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }
        $data = $this->fetchStreamDetails($id);
        // Calculate total reviews and average rating
        $reviews = $data['stream_details']['ratings'] ?? [];
        $totalReviews = count($reviews);
        $averageRating = $totalReviews > 0
            ? number_format(array_sum(array_column($reviews, 'rating')) / $totalReviews, 1)
            : ' ';

        return view("detailscreen.index", array_merge($data, [
            'totalReviews' => $totalReviews,
            'averageRating' => $averageRating,
            'ratingsCount' => $totalReviews ?? '',
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
        if ($responseJson['success'] == false)
            return back()->with('error', $responseJson['message']);

        // Fetch updated ratings
        //need to send total reviews also ???
        $data = $this->fetchStreamDetails($request->stream_code);
        $reviews = $data['stream_details']['ratings'] ?? [];
        $totalReviews = count($reviews);
        // Calculate the average rating
        $totalRating = 0;
        foreach ($reviews as $review) {
            $totalRating += $review['rating'];
        }
        $averageRating = $totalReviews > 0 ? number_format($totalRating / $totalReviews, 1) : 0;

        // Render updated reviews HTML
        $newReviewHtml = view(
            'detailscreen.partials.review',
            [
                'reviews' => $data['stream_details']['ratings'],
                'stream_details' => $data['stream_details']
            ]
        )->render();
        $ratingIconHtml = view('detailscreen.partials.rating-icon', ['ratingsCount' => $totalReviews, 'stream_details' => $data['stream_details']])->render();

        return response()->json([
            'success' => true,
            'newReviewHtml' => $newReviewHtml,
            'ratingIconHtml' => $ratingIconHtml,
            'totalReviews' => $totalReviews ?? '',
            'ratingsCount' => $totalReviews ?? '',
            'averageRating' => $averageRating
        ]);
    }

   public function getRelatedStreams(Request $request)
{
    $streamGuid = $request->input('stream_guid');

    $cacheKey = 'related_streams_' . $streamGuid;

    if (Cache::has($cacheKey)) {
        return response()->json([
            'success' => true,
            'data' => [
                'streams' => Cache::get($cacheKey),
            ]
        ]);
    }

    $response = Http::withHeaders(Api::headers())
        ->asForm()
        ->post(Api::endpoint('/related/stream'), [
            'streamGuid' => $streamGuid,
        ]);

    if ($response->successful()) {
        $responseJson = $response->json();
        $streams = $responseJson['app']['latest_items'] ?? [];

        // Cache the result for 2 minutes
        Cache::put($cacheKey, $streams, now()->addMinutes(1));

        return response()->json([
            'success' => true,
            'data' => [
                'streams' => $streams,
            ]
        ]);
    }

    Log::error('API call failed in getRelatedStreams', [
        'status' => $response->status(),
        'body' => $response->body()
    ]);

    return response()->json(['success' => false], 500);
}


    public function renderYouMightLike(Request $request)
    {
        $streams = $request->input('streams');
        $stream_guid = $request->input('stream_guid');
        $latest_items = $streams; // Map to match you-might-like partial
        $html = view('detailscreen.partials.you-might-like', compact('latest_items', 'stream_guid'))->render();
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    public function renderplaylist(Request $request)
    {
        $streams = $request->input('streams', []);

        if (empty($streams)) {
            return response()->json(['success' => false, 'html' => '']);
        }
        $latest_items = $streams; // Map to match you-might-like partial
        $stream_guid = $request->input('stream_guid');
        $adMacros = $request->input('adMacros');
        $isMobileBrowser = $request->input('isMobileBrowser');
        $dataVast2 = $request->input('dataVast2');
        // Trim whitespace from rendered HTML
        // $html = trim(view('detailscreen.partials.render-playlist-items', compact('latest_items', 'stream_guid', 'adMacros', 'isMobileBrowser', 'dataVast2'))->render());

        return view('detailscreen.partials.render-playlist-items', compact('latest_items', 'stream_guid', 'adMacros', 'isMobileBrowser', 'dataVast2'));
    }
}
