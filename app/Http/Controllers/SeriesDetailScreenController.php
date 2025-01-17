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
        if ($data['series_details'] === []) {
            abort(404);
        }
        $streamGuId = $data['series_details']['stream_guid'];
        $responseRatings = Http::withHeaders(Api::headers())
            ->get(Api::endpoint('/userrating/get/' . $streamGuId . '/stream'));
        $data['series_details']['ratings'] = $responseRatings->json()['data'];
        $streamGuId = $data['series_details']['stream_guid'];
        $imdb = $data['series_details']['imdb'];
        // dd($data['series_details']['ratings']);

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
        return view("series-detailscreen.index", $data);
    }
}
