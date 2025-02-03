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

    public function view_setting()
    {
        return view('profile.setting');
    }

    public function history()
    {
        $userProfileId = session('USER_DETAILS.USER_PROFILE') ?? null;

        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/watch/history?userProfileID=' . $userProfileId));

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


    public function getUserProfile()
    {
        $response = Http::timeout(300)->withHeaders(Api::headers(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ))
            ->asForm()
            ->post(Api::endpoint('/getUserprofiles'), [
                'code' => session('USER_DETAILS.USER_CODE')
            ]);
        $responseJson1 = $response->json();
        return $responseJson1;
    }

    public function UpdateProfile(Request $request)
    {
        $response = Http::timeout(300)->withHeaders(Api::headers(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ))
            ->asForm()
            ->post(Api::endpoint('/Updateprofile'), [
                'code' => session('USER_DETAILS.USER_CODE'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'account_type' => $request->input('account_type'),
                'image' => $request->input('image'),
            ]);
        $responseJson1 = $response->json();
        return $responseJson1;
    }
}
