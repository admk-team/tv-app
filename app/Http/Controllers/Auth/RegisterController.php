<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $response = Http::timeout(300)->withHeaders(Api::headers(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ))
            ->asForm()
            ->post(Api::endpoint('/mngappusrs'), [
                'requestAction' => 'createAccount',
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'confirmPassword' => $request->password_confirmation,
                'isBypassEmailVerificationStep' => 'Y'
            ]);
        $responseJson = $response->json();
        
        if (array_key_exists('errors', $responseJson) && is_array($responseJson['errors'])) {
            return back()->with('error', reset($responseJson['errors'])[0]);
        }   

        session([
            'USER_DETAILS' => [
                'USER_ACCOUNT_PASS' => $request->password ?? null,
                'USER_CODE' => $responseJson['app']['data']['user_code'] ?? null,
                'USER_NAME' => $responseJson['app']['data']['name'] ?? null,
                'USER_PICTURE' => $responseJson['app']['data']['picture'] ?? null,
                'USER_ACCOUNT_STATUS' => $responseJson['app']['data']['account_status'] ?? null,
                'USER_EMAIL' => $responseJson['app']['data']['email'] ?? null,
                'USER_ID' => $responseJson['app']['data']['user_id'] ?? null,
            ],
            'msgTrue' => 1,
        ]);

        return redirect(route('profile.index'));
    }
}
