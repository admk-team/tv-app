<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FollowController extends Controller
{
    public function follow(Request $request, $id)
    {
        try {
            $response = Http::timeout(300)->withHeaders(Api::headers())->asForm()
                ->post(Api::endpoint('/toggle/follow'), [
                    'actor_id' => $id,
                ]);
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
