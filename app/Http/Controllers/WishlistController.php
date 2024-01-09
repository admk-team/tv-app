<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WishlistController extends Controller
{
    public function toggle()
    {
        $response = Http::withHeaders(Api::headers())
            ->post(Api::endpoint('/mngfavitems'), request()->except('_token'));
        
        return $response->body();
    }
}
