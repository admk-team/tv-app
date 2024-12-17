<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\Api;
use App\Services\AppConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->input();
        unset($data['_token']);
        return view('auth.register', compact('data'));
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
                'isBypassEmailVerificationStep' => 'Y',
                'partner_url' => session('partner_url') ?? null,
                'referral_link' => session('referral_link') ?? null
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

        if (session()->has('REDIRECT_TO_SCREEN')) {
            $redirectUrl = session('REDIRECT_TO_SCREEN');
            session()->forget('REDIRECT_TO_SCREEN');
            return redirect($redirectUrl);
        }

        if (GeneralHelper::subscriptionIsRequired()) {
            return redirect(route('subscription'));
        }
        $profile = \App\Services\AppConfig::get()->app->app_info->profile_manage;
        if ($profile == 1) {
            return redirect(route('profile.index'));
        } else {
            // If $profile is not 1, redirect to the home page ('/')
            return redirect('/');
        }
    }
}
