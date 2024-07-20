<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\Api;

class PersonController extends Controller
{
    public function index($id)
    {
        $response = Http::withHeaders(Api::headers())
        ->get(Api::endpoint('/person/' . $id));
        $responseJson = $response->json();

        $data = $responseJson['data'];
        $follows = $responseJson['follows'];
        return view('person.index', compact('data', 'follows'));
    }
}
