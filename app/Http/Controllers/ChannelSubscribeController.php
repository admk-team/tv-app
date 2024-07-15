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
}
