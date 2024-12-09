<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Api;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotifyComingSoonStreamController extends Controller
{
    public function toggleRemind(Request $request)
    {
        $request->validate([
            'stream_code' => 'required|string',
        ]);
        try {
            $response = Http::timeout(300)->withHeaders(Api::headers())->asForm()
                ->post(Api::endpoint('/remind/me'), ['stream_code' => $request->stream_code]);
            // dd($response->json());
            if ($response->successful()) {
                return back();
            } else {
                return back();
            }
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while processing your request.');
        }
    }
    
    public function checkRemindStatus(Request $request)
    {
        $streamCode = $request->get('stream_code');
        if (!$streamCode) {
            return response()->json([
                'success' => false,
                'message' => 'Stream code is required.'
            ], 400);
        }
    
        try {
            $response = Http::timeout(300)->withHeaders(Api::headers())->asForm()
                ->get(Api::endpoint('/check/remind/me'), ['stream_code' => $streamCode]);
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'reminded' => $response->json('remind', false)
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve remind status'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred.'
            ], 500);
        }
    }
    
}
