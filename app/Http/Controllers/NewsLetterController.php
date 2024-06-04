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
    
        $response = Http::timeout(300)->withHeaders(Api::headers([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]))
        ->asForm()
        ->post(Api::endpoint('/mngappusrs'), [
            'requestAction' => 'newLetter',
            'email' => $validated['email'],
        ]);
    
        if ($response) {
            $data = $response->json();
            session()->flash('data', $data);
        } else {
            session()->flash('error', 'An error occurred while processing your request.');
        }
    
        return redirect()->back()->withFragment('newsletter-section');
    }
    
}
