<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserBadgeController extends Controller
{
    public function index()
    {
        $userProfileId = session('USER_DETAILS.USER_PROFILE') ?? null;

        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/watch/history?userProfileID='. $userProfileId));

        $data = $response->json();
        return view('user_badge.index', compact('data'));
    }
}
