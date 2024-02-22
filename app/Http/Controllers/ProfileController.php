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
            ->get(Api::endpoint('/userprofiles/' . session('USER_DETAILS.USER_ID')), [
                'type' => 'advisory',
            ]);
        $user_data = $response->json();

        return view('profile.index', compact('user_data'));
    }

    public function view_profile($id)
    {
        session()->push('USER_DETAILS.USER_PROFILE', $id);

        return redirect()->route('home');
    }
}
