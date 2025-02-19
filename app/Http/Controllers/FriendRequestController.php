<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Services\Api;

use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    public function getPublicFriend()
    {
        $response = Http::timeout(300)->withHeaders(Api::headers(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ))
            ->asForm()
            ->post(Api::endpoint('/public-users'), [
                'code' => session('USER_DETAILS.USER_CODE'),
                'app_code' => env('APP_CODE')
            ]);
        $responseJson1 = $response->json();
        return $responseJson1;
    }


    public function sendFriendRequest(Request $request)
    {
        $response = Http::timeout(300)->withHeaders(Api::headers(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ))
            ->asForm()
            ->post(Api::endpoint('/send-request'), [
                'sender_id' => session('USER_DETAILS.USER_CODE'),
                'app_code' => env('APP_CODE'),
                'receiver_id' => $request->user_code,
            ]);
        $responseJson1 = $response->json();
        return $responseJson1;
    }


    public function getFriendRequests()
    {
        $response = Http::timeout(300)->withHeaders(Api::headers(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ))
            ->asForm()
            ->post(Api::endpoint('/incoming-requests'), [
                'code' => session('USER_DETAILS.USER_CODE'),
                'app_code' => env('APP_CODE')
            ]);
        $responseJson1 = $response->json();
        return $responseJson1;
    }

    public function AceptFriendRequests(Request $request)
    {
        $response = Http::timeout(300)->withHeaders(Api::headers(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ))
            ->asForm()
            ->post(Api::endpoint('/friend-request/accept'), [
                'sender_id' => session('USER_DETAILS.USER_CODE'),
                'receiver_id' => $request->input('receiver_id'),
                'app_code' => env('APP_CODE')
            ]);
        $responseJson1 = $response->json();
        return $responseJson1;
    }

    public function rejectFriendRequests(Request $request)
    {
        $response = Http::timeout(300)->withHeaders(Api::headers(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ))
            ->asForm()
            ->post(Api::endpoint('/friend-request/reject'), [
                'sender_id' => session('USER_DETAILS.USER_CODE'),
                'receiver_id' => $request->input('receiver_id'),
                'app_code' => env('APP_CODE')
            ]);
        $responseJson1 = $response->json();
        return $responseJson1;
    }

    public function getFriends()
    {
        $response = Http::timeout(300)->withHeaders(Api::headers(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ))
            ->asForm()
            ->post(Api::endpoint('/friends'), [
                'sender_id' => session('USER_DETAILS.USER_CODE'),
                'app_code' => env('APP_CODE')
            ]);
        $responseJson1 = $response->json();
        return $responseJson1;
    }

    public function markUnFriends(Request $request)
    {
        $response = Http::timeout(300)->withHeaders(Api::headers(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ))
            ->asForm()
            ->post(Api::endpoint('/unfriends'), [
                'sender_id' => session('USER_DETAILS.USER_CODE'),
                'receiver_id' => $request->input('receiver_id'),
                'app_code' => env('APP_CODE')
            ]);
        $responseJson1 = $response->json();
        return $responseJson1;
    }

    public function getFavFriends()
    {
        $response = Http::timeout(300)->withHeaders(Api::headers(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ))
            ->asForm()
            ->post(Api::endpoint('/get-fav-friends'), [
                'sender_id' => session('USER_DETAILS.USER_CODE'),
                'app_code' => env('APP_CODE')
            ]);
        $responseJson1 = $response->json();
        return $responseJson1;
    }

    public function markAsFavFriends(Request $request)
    {
        $response = Http::timeout(300)->withHeaders(Api::headers(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ))
            ->asForm()
            ->post(Api::endpoint('/mark-fav-friends'), [
                'sender_id' => session('USER_DETAILS.USER_CODE'),
                'receiver_id' => $request->input('receiver_id'),
                'app_code' => env('APP_CODE')
            ]);
        $responseJson1 = $response->json();
        return $responseJson1;
    }
    public function friends_option()
    {
        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/friends/option'));
        $responseJson = $response->json();

        $recommendation = $responseJson['app']['recommendation'] ?? [];
        // dd($quality);
        return view('recommendation.index', compact('recommendation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fav_friends' => 'required|array', // Ensure it's an array
        ]);
        if (!empty($request->fav_friends) && !empty($request->stream_code)) {
            $response = Http::timeout(300)->withHeaders(Api::headers(
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ))
                ->asForm()
                ->post(Api::endpoint('/friends-recommendation'), [
                    'sender_code' => session('USER_DETAILS.USER_CODE'),
                    'receiver_code' => $request->input('fav_friends'),
                    'type' => $request->input('type'),
                    'stream_code' => $request->input('stream_code'),
                    'app_code' => env('APP_CODE')
                ]);
            $responseJson1 = $response->json();
        }
        return $responseJson1;
    }
}
