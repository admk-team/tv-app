<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QualityController extends Controller
{
    public function index($code)
    {
        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/quality/' . $code));
        $responseJson = $response->json();

        $quality = $responseJson['app']['quality'] ?? [];
        return view('quality.index', compact('quality'));
    }
}
