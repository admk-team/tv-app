<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RatingController extends Controller
{
    public function index($code)
    {
        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/rating/' . $code));
        $responseJson = $response->json();

        $rating = $responseJson['app']['rating'] ?? [];
        return view('rating.index', compact('rating'));
    }
}
