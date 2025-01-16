<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SeriesDetailScreenController extends Controller
{
    public function index($id)
    {
        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->get(Api::endpoint("/getseriesdetails/{$id}"));

        $data = $response->json()['app'];
        if ($data['stream_details'] === []) {
            abort(404);
        }
        $streamGuId = $data['stream_details']['stream_guid'];
        $responseRatings = Http::withHeaders(Api::headers())
            ->get(Api::endpoint('/userrating/get/' . $streamGuId . '/stream'));
        $data['stream_details']['ratings'] = $responseRatings->json()['data'];
        $streamGuId = $data['stream_details']['stream_guid'];
        $imdb = $data['stream_details']['imdb'];
        // dd($data['stream_details']['ratings']);

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
        return view("series-detailscreen.index", $data);
    }
}
