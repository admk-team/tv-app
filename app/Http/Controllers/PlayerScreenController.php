<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class PlayerScreenController extends Controller
{
    public function index($id)
    {
        $xyz = base64_encode(request()->ip());
        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->get(Api::endpoint("/getitemplayerdetail/{$id}?user_data={$xyz}"));
        $data = $response->json();
        if ($data['app']['stream_details'] === []) {
            if ($data['geoerror'] ?? null) {
                return view("page.movienotexist");
            }
            abort(404);
        }
        return view("playerscreen.index", ['arrRes' => $data, 'streamGuid' => $id]);
    }

    public function checkPassword(Request $request)
    {
        $streamPassword = null;
        try {
            $streamPassword = Crypt::decryptString($request->key);
        } catch (\Exception $e) {
        }

        if (password_verify($request->password, $streamPassword)) {
            if (session('protectedContentAccess') === null)
                session('protectedContentAccess', []);
            session()->push('protectedContentAccess', $request->stream_guid);
        } else {
            session()->flash('error', 'Incorrect Password');
        }

        return back();
    }

    public function checkScreenerPassword(Request $request)
    {
        $streamPassword = null;
        try {
            $streamPassword = Crypt::decryptString($request->key);
        } catch (\Exception $e) {
        }

        if (request()->password == $streamPassword) {
            session('GLOBAL_PASS', 0);
            header("Location: " . $request->shortUrl);
            die();
        } else {
            session('error', 'Incorrect Password');
        }
        header("Location: " . $request->fullUrl);
        die();
    }
}
