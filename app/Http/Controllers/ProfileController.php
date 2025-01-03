<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/userprofiles?id=' . session('USER_DETAILS.USER_ID')));
        $user_data = $response->json();

        return view('profile.index', compact('user_data'));
    }

    public function view_profile($id)
    {
        // Replace the current profile ID with the new one
        session()->put('USER_DETAILS.USER_PROFILE', $id);

        return redirect()->route('home');
    }

    public function history()
    {
        $userProfileId = session('USER_DETAILS.USER_PROFILE') ?? null;

        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/watch/history?userProfileID='. $userProfileId));

        $data = $response->json();
        return view('watch_history.index', compact('data'));
    }

    public function manage_profile($id)
    {
        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/userprofiles?id=' . session('USER_DETAILS.USER_ID')));
        $user_data = $response->json();

        return view('profile.manage', compact('user_data'));
    }
}
