<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChannelSubscribeController extends Controller
{
    public function toggleSubscribe(Request $request)
    {
        $playerId = $request->input('player_id');

        $response = Http::timeout(300)
            ->withHeaders(Api::headers())
            ->asForm()
            ->post(Api::endpoint('/channel/subscribe'), [
                'player_id' => $playerId,
            ]);
        return response()->json(['success' => true, 'message' => $response->json()]);
    }


    public function checkSubscriptionStatus()
    {
        $responseData = Http::timeout(300)->withHeaders(Api::headers())->asForm()
            ->get(Api::endpoint('/channel/subscribe/check'));
        // dd($responseData->json());
        if ($responseData->successful()) {
            return response()->json([
                'success' => true,
                'subscribed' => $responseData->json('subscribed', false)
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve subscription status'
            ], 200);
        }
    }
}
