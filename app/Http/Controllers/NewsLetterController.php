<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsLetterController extends Controller
{
    public function newLetter(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);
        dd(  $validated);
        $response = Http::timeout(300)->withHeaders(Api::headers(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ))
            ->asForm()
            ->post(Api::endpoint('/mngappusrs'), [
                'requestAction' => 'newLetter',
                'email' => $validated['email'],
            ]);

        if ($response) {
            $data = $response->json();
            return back();
        }
    }
}
