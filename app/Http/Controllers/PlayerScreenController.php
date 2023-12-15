<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlayerScreenController extends Controller
{
    public function index($id)
    {
        $response = Http::withHeaders([
            'happcode' => env('APP_CODE')
        ])
        ->get(env("API_BASE_URL") . "/getitemplayerdetail/{$id}");

        $data = $response->json();
        return view("playerscreen.index", ['arrRes' => $data]);
    }
}
