<?php

namespace App\Http\Controllers\Auth;

use App\Services\Api;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view("auth.login");
    }

    public function login(LoginRequest $request)
    {
        $finalresultDevice = null;
        // Get the user agent string
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        Log::info($userAgent);

        // Check if the user agent indicates a mobile device
        $isMobile = (bool)preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i', $userAgent);

        // Check if the user agent indicates a tablet device
        $isTablet = (bool)preg_match('/iPad|Android|Tablet/i', $userAgent);

        // Initialize a variable to store the matched browser
        $matchedBrowser = "Unknown";

        // Detect browsers
        if (strpos($userAgent, 'Edge') !== false) {
            // New Edge based on Chromium
            $matchedBrowser = "Microsoft Edge (Chromium)";
        } elseif (strpos($userAgent, 'Edg') !== false) {
            // Legacy Edge
            $matchedBrowser = "Microsoft Edge (Legacy)";
        } elseif (strpos($userAgent, 'Chrome') !== false) {
            $matchedBrowser = "Chrome";
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            $matchedBrowser = "Firefox";
        } elseif (strpos($userAgent, 'Safari') !== false && strpos($userAgent, 'Chrome') === false) {
            // Ensure it's not Chrome disguised as Safari
            $matchedBrowser = "Safari";
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

        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->asForm()
            ->post(Api::endpoint("/mngappusrs?user_data={$xyz}&user_device={$finalresultDevice}&user_code={$request->user_code}&admin_code={$request->admin_code}"), [
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

        if (session()->has('REDIRECT_TO_SCREEN')) {
            $redirectUrl = session('REDIRECT_TO_SCREEN');
            session()->forget('REDIRECT_TO_SCREEN');
            return redirect($redirectUrl);
        }

        // If subscription is required and is not subscribed redirect to subscription page
        if (GeneralHelper::subscriptionIsRequired()) {
            return redirect(route('subscription'));
        }

        $responseprofile = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint("/userprofiles?id={$responseJson['app']['data']['user_id']}&user_data={$xyz}&user_device={$finalresultDevice}"));

        $user_data = $responseprofile->json();
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
