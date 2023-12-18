<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlayerScreenController extends Controller
{
    public function index($id)
    {
        $response = Http::withHeaders(Api::headers())
        ->get(Api::endpoint("/getitemplayerdetail/{$id}"));

        $data = $response->json();
        return view("playerscreen.index", ['arrRes' => $data, 'streamGuid' => $id]);
    }
}
