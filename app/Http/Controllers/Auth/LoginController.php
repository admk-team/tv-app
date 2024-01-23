<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Http;
use App\Services\Api;

class LoginController extends Controller
{
    public function index()
    {
        return view("auth.login");
    }

    public function login(LoginRequest $request)
    {
        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->asForm()
            ->post(Api::endpoint('/mngappusrs'), [
                'requestAction' => 'validateUserAccount',
                'email' => $request->email,
                'password' => $request->password,
                'isBypassEmailVerificationStep' => 'Y'
            ]);
        $responseJson = $response->json();

        if ($responseJson['app']['status'] === 0) {
            return back()->with('error', $responseJson['app']['msg']);
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
        $profile = \App\Services\AppConfig::get()->app->app_info->profile_manage;
        if ($profile === 1) {
            return redirect(route('profile.index'));
        }
        return redirect(route('profile.index'));
    }
}
