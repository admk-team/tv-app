<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Http;
use App\Services\Api;
use Illuminate\Support\Facades\Validator;

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

        $finalresultDevice = null;
        // Get the user agent string
        $userAgent = $_SERVER['HTTP_USER_AGENT'];

        // Check if the user agent indicates a mobile device
        $isMobile = (bool)preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i', $userAgent);

        // Check if the user agent indicates a tablet device
        $isTablet = (bool)preg_match('/iPad|Android|Tablet/i', $userAgent);

        // Initialize a variable to store the matched browser
        $matchedBrowser = "Unknown";

        // Detect browsers
        if (strpos($userAgent, 'Chrome') !== false) {
            $matchedBrowser = "Chrome";
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            $matchedBrowser = "Firefox";
        } elseif (strpos($userAgent, 'Safari') !== false) {
            $matchedBrowser = "Safari";
        } elseif (strpos($userAgent, 'Edge') !== false) {
            $matchedBrowser = "Microsoft Edge";
        } elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident/') !== false) {
            $matchedBrowser = "Internet Explorer";
        }

        // Output the information
        // echo "Is Mobile: " . ($isMobile ? 'Yes' : 'No') . "<br>";
        // echo "Is Tablet: " . ($isTablet ? 'Yes' : 'No') . "<br>";
        $mobile = $isMobile ? true : false;
        $tablet = $isTablet ? true : false;
        if ($mobile) {
            $finalresultDevice = 'mobile';
        } elseif ($isTablet) {
            $finalresultDevice = 'tablet';
        } else {
            $finalresultDevice = $matchedBrowser;
        }

        $xyz = base64_encode(request()->ip());

        if (session()->has('REDIRECT_TO_SCREEN')) {
            $redirectUrl = session('REDIRECT_TO_SCREEN');
            session()->forget('REDIRECT_TO_SCREEN');
            return redirect($redirectUrl);
        }

        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint("/userprofiles?id={$responseJson['app']['data']['user_id']}&user_data={$xyz}&user_device={$finalresultDevice}"));

        $user_data = $response->json();

        return view('profile.index', compact('user_data'));
    }

    public function verify()
    {
        return view("auth.verify_email");
    }

    public function verifyEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);
        $response = Http::timeout(300)->withHeaders(Api::headers(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ))
            ->asForm()
            ->post(Api::endpoint('/mngappusrs'), [
                'requestAction' => 'varifyEmail',
                'email' => $validated['email'],

            ]);

        if ($response) {
            $data = $response->json();
            return view("auth.verify_email", compact('data'));
        }
    }


    public function forgot()
    {
        return view("auth.forgot_password");
    }

    public function forgotPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);
        $response = Http::timeout(300)->withHeaders(Api::headers(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ))
            ->asForm()
            ->post(Api::endpoint('/mngappusrs'), [
                'requestAction' => 'forgotAccountPassword',
                'email' => $validated['email'],

            ]);

        if ($response) {
            $data = $response->json();
            return view("auth.forgot_password", compact('data'));
        }
    }
}
