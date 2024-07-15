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
        try {
            $response = Http::timeout(300)->withHeaders(Api::headers())->asForm()
                ->post(Api::endpoint('/channel/subscribe'));
            if ($response->successful()) {
                return back();
            } else {
                return back();
            }
        } catch (\Exception $e) {
            return back()->with('erros', 'An error occurred while processing your request.');
        }
    }

    public function checkSubscriptionStatus()
    {
        $responseData = Http::timeout(300)->withHeaders(Api::headers())
            ->get('http://127.0.0.1:8000/api/f/v1/channel/subscribe/check');
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
