<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ScreenerController extends Controller
{
    public function player($code, $index = 1, Request $request)
    {
        $password = Session::get("screeners.$code.password");

        $response = Http::timeout(300)->withHeaders(Api::headers())
        ->post(Api::endpoint("/screener/{$code}?index=$index&email={$request->email}" . ($password? "&password=$password": "")));
        $data = $response->json();

        if (isset($data['app']['password_required']) && $data['app']['password_required'] === true) {
            return view("screener.password", compact('code'));
        }

        if (isset($data['app']['screener_start_time'])) {
            return view('screener.show_start_time', [
                'startTime' => $data['app']['screener_start_time']
            ]);
        }

        if ($data['app']['stream_details'] === []) {
            dd("dsfdsf");
            return view('screener.expired');
        }
        
        return view("screener.player", ['arrRes' => $data, 'streamGuid' => $data['app']['stream_details']['stream_guid'], 'code' => $code]);
    }

    public function authenticate($code, Request $request)
    {
        $response = Http::timeout(300)->withHeaders(Api::headers())
        ->post(Api::endpoint("/screener/{$code}?checking_password=true&email={$request->email}&password={$request->password}"));
        $data = $response->json();

        if (isset($data['app']['error'])) {
            return back()->with('error', $data['app']['error']);
        }

        Session::put("screeners.$code.password", $request->password);

        return back();
    }
}
