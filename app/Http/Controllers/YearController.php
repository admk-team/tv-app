<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class YearController extends Controller
{
    public function index($year)
    {
        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/year/' . $year));
        $responseJson = $response->json();

        $streams = $responseJson['app']['streams'] ?? [];
        return view('year.index', compact('streams', 'year'));
    }
}
