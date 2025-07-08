<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function index()
    {
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }
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
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }
        return view('profile.setting');
    }

    public function history()
    {
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }
        $userProfileId = session('USER_DETAILS.USER_PROFILE') ?? null;

        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/watch/history?userProfileID=' . $userProfileId));

        $data = $response->json();
        return view('watch_history.index', compact('data'));
    }

    public function manage_profile($id)
    {
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }
        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/userprofiles?id=' . session('USER_DETAILS.USER_ID')));
        $user_data = $response->json();

        return view('profile.manage', compact('user_data'));
    }


    public function getUserProfile()
    {
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }
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

    public function updateProfile(Request $request)
    {
        // dd($request);
        $filename = null;
        Storage::deleteDirectory('public/images/appuser');
        // Handle file upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $filename = str_replace(' ', '', $request->input('name')) . '_' . now()->format('Y-m-d_H-i-s') . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = storage_path('app/public/images/appuser/' . $filename);
            $request->file('image')->move(storage_path('app/public/images/appuser'), $filename);

            // Prepare the API request
            $response = Http::timeout(300)->withHeaders(Api::headers([
                'Accept' => 'application/json',
            ]))
                ->attach('image', $filename ? fopen(storage_path('app/public/images/appuser/' . $filename), 'r') : null, $filename)
                ->post(Api::endpoint('/Updateprofile'), [
                    'code' => session('USER_DETAILS.USER_CODE'),
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'mobile' => $request->input('mobile'),
                    'account_type' => $request->input('account_type'),
                ]);
            return response()->json($response->json());
        } else {

            $response = Http::timeout(300)->withHeaders(Api::headers([
                'Accept' => 'application/json',
            ]))
                ->post(Api::endpoint('/Updateprofile'), [
                    'code' => session('USER_DETAILS.USER_CODE'),
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'mobile' => $request->input('mobile'),
                    'account_type' => $request->input('account_type'),
                ]);
            return response()->json($response->json());
        }
    }
}
