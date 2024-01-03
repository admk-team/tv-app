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

        return view("detailscreen.index", $data);
    }
}
