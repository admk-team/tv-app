<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DetailScreenController extends Controller
{
    public function index($id)
    {
        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->get(Api::endpoint("/getitemdetail/{$id}"));

        $data = $response->json()['app'];
        if ($data['stream_details'] === []) {
            abort(404);
        }
        $streamGuId = $data['stream_details']['stream_guid'];
        $imdb = $data['stream_details']['imdb'];

        $responseRatings = Http::withHeaders(Api::headers())
            ->get(Api::endpoint('/userrating/get/' . $streamGuId . '/stream'));
        $data['stream_details']['ratings'] = $responseRatings->json()['data'];
        // dd($data['stream_details']['ratings']);

        if ($imdb !== "") {

            dd("http://www.omdbapi.com/?i={$imdb}&apikey=da5b7118");
            $responseImdb = Http::timeout(300)->withHeaders(Api::headers())
                ->get(Api::endpoint("http://www.omdbapi.com/?i={$imdb}&apikey=da5b7118"));

            $imdbDetails = $responseImdb->json();

            dd($imdbDetails);
        }

        return view("detailscreen.index", $data);
    }

    public function addRating(Request $request)
    {
        $request->validate([
            'rating' => 'required',
        ], [
            'rating.required' => 'Please rate the stream'
        ]);
        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->timeout(300)
            ->post(Api::endpoint('/userrating/store'), [
                'app_code' => env('APP_CODE'),
                'user_id' => session('USER_DETAILS')['USER_ID'],
                'rating' => $request->rating ?? 0,
                'comment' => $request->comment ?? '',
                'stream_code' => $request->type == 'stream' ? $request->stream_code : '',
                'show_code' => $request->type == 'show' ? $request->stream_code : '',
            ]);
        $responseJson = $response->json();

        if ($responseJson['success'] == false)
            return back()->with('error', $responseJson['message']);

        return back();
    }
}
