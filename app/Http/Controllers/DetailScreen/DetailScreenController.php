<?php

namespace App\Http\Controllers\DetailScreen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class DetailScreenController extends Controller
{
    public function index($id)
    {
        $response = Http::withHeaders([
            'happcode' => '7376d3829575f06617d9db3f7f6836df'
        ])
        ->get(env("API_BASE_URL") . "/getitemdetail/{$id}");

        $data = $response->json()['app'];
        //dd($data);
        return view("detailscreen.index", $data);
    }
}
