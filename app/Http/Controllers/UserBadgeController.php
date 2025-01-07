<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserBadgeController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/badge/details'));

        $data = $response->json();
        return view('user_badge.index', compact('data'));
    }
}
