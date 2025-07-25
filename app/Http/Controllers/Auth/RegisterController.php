<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\Api;
use App\Services\AppConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        if(session('USER_DETAILS')){
            return redirect("/");
        }
        $data = $request->input();
        unset($data['_token']);
        return view('auth.register', compact('data'));
    }

    public function register(Request $request)
    {
        $complexity = \App\Services\AppConfig::get()->app->password_complexity ?? 'simple';
         $rules = [
            'name' => 'required|max:40',
            'email' => 'required|email',
            'password_confirmation' => 'required|same:password',
        ];

        $messages = [
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least :min characters.',
            'password.regex' => 'Password must include uppercase, lowercase, number, and special character.',
            'password_confirmation.same' => 'Passwords do not match.',
        ];

        if ($complexity === 'simple') {
            $rules['password'] = ['required', 'string', 'min:6'];
        } elseif ($complexity === 'moderate') {
            $rules['password'] = [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ];
        } elseif ($complexity === 'strong') {
            $rules['password'] = [
                'required',
                'string',
                'min:12',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ];
        }

        $request->validate($rules, $messages);
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

        $xyz = base64_encode(request()->ip());
        session([
            'USER_DETAILS' => [
                'USER_ACCOUNT_PASS' => $request->password ?? null,
                'USER_CODE' => $responseJson['app']['data']['user_code'] ?? null,
                'USER_NAME' => $responseJson['app']['data']['name'] ?? null,
                'USER_PICTURE' => $responseJson['app']['data']['picture'] ?? null,
                'USER_ACCOUNT_STATUS' => $responseJson['app']['data']['account_status'] ?? null,
                'USER_EMAIL' => $responseJson['app']['data']['email'] ?? null,
                'USER_ID' => $responseJson['app']['data']['user_id'] ?? null,
                'GROUP_USER' => $responseJson['app']['data']['group_user'] ?? null,
            ],
            'msgTrue' => 1,
        ]);

        if ($responseJson['app']['form'] && $responseJson['app']['form']['status'] == 1) {
            $fields = $responseJson['app']['form'];
            return view('auth.registertion_form', ['form' => $fields]);
        }

        $profile = \App\Services\AppConfig::get()->app->app_info->profile_manage;

        if (session()->has('REDIRECT_TO_SCREEN')) {
            $redirectUrl = session('REDIRECT_TO_SCREEN');
            session()->forget('REDIRECT_TO_SCREEN');
            return redirect($redirectUrl);
        }
        $finalresultDevice = null;
        // If subscription is required and is not subscribed redirect to subscription page
        if (GeneralHelper::subscriptionIsRequired()) {
            return redirect(route('subscription'));
        }
        if ($profile == 1) {
            // Make an API call if the profile condition is true
            $responseprofile = Http::withHeaders(Api::headers())
                ->asForm()
                ->get(Api::endpoint("/userprofiles?id={$responseJson['app']['data']['user_id']}&user_data={$xyz}&user_device={$finalresultDevice}"));

            // Decode the response JSON data
            $user_data = $responseprofile->json();

            // Return the 'profile.index' view with the fetched user data
            return view('profile.index', compact('user_data'));
        } else {
            // If $profile is not 1, redirect to the home page ('/')
            return redirect('/');
        }
    }

    public function storeRegistertaionForm($id, Request $request)
    {
        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->post(Api::endpoint("/storeRegistretionForm/{$id}/formData"), $request->all());

        $res = $response->json();

        if (session()->has('REDIRECT_TO_SCREEN')) {
            $redirectUrl = session('REDIRECT_TO_SCREEN');
            session()->forget('REDIRECT_TO_SCREEN');
            return redirect($redirectUrl);
        }

        if (GeneralHelper::subscriptionIsRequired()) {
            return redirect()->route('subscription');
        }

        $profile = \App\Services\AppConfig::get()->app->app_info->profile_manage;

        if ($profile == 1) {
            $userId = session('USER_DETAILS.USER_ID');
            $xyz = base64_encode(request()->ip());

            $responseprofile = Http::withHeaders(Api::headers())
                ->asForm()
                ->get(Api::endpoint("/userprofiles?id={$userId}&user_data={$xyz}&user_device="));

            $user_data = $responseprofile->json();

            return view('profile.index', compact('user_data'));
        }

        return redirect('/');
    }



    public function socialLogin()
    {
        return Socialite::driver('google')->with(['prompt' => 'select_account'])->redirect();
    }
    public function socialfacebook(){
        return Socialite::driver('facebook')->with(['auth_type' => 'reauthenticate'])->redirect();
    }
    public function socialLinkedin(){
        return Socialite::driver('linkedin-openid')->with(['prompt' => 'select_account'])->redirect();
    }

    public function redirectfaceook(){
        $facebookUser = Socialite::driver('facebook')->stateless()->user();
        return $this->sendSocialData($facebookUser->id,$facebookUser->name,$facebookUser->email);
    }

    public function redirectLinkedin(){
        $linkedinUser = Socialite::driver('linkedin-openid')->user();
        return $this->sendSocialData($linkedinUser->id,$linkedinUser->name,$linkedinUser->email);
    }

    public function redirectBack(){
        $googleUser = Socialite::driver('google')->stateless()->user();
        return $this->sendSocialData($googleUser->id,$googleUser->name,$googleUser->email);
        
    }

    public function sendSocialData($id,$name,$email)
    {

        $response = Http::timeout(300)->withHeaders(Api::headers(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ))
            ->asForm()
            ->post(Api::endpoint('/mngappusrs'), [
                'requestAction' => 'socialLogin',
                'name' => $name,
                'email' => $email,
                'social_id' => $id,
            ]);
        $responseJson1 = $response->json();
        
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
        $partnerlink = session('partner_url');
        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->asForm()
            ->post(Api::endpoint("/mngappusrs?user_data={$xyz}&user_device={$finalresultDevice}"), [
                'requestAction' => 'validateUserAccount',
                'social_id' => $id ?? null,
                'name' => $responseJson1['app']['data']['name'] ?? null,
                'email' => $responseJson1['app']['data']['email'] ?? null,
                'isBypassEmailVerificationStep' => 'Y',
                'partner_url' => $partnerlink ?? null
            ]);
        
        $responseJson = $response->json();
        
        if ($responseJson['app']['status'] === 0) {
            return redirect()->route('login')->with('error', $responseJson['app']['msg']);
        }

        session([
            'USER_DETAILS' => [
                'USER_ACCOUNT_PASS' => $request->password ?? null,
                'USER_CODE' => $responseJson['app']['data']['user_code'] ?? null,
                'USER_NAME' => $responseJson['app']['data']['name'] ?? null,
                'FULL_USER_NAME' => $responseJson['app']['data']['name'] ?? null,
                'USER_PICTURE' => $responseJson['app']['data']['picture'] ?? null,
                'USER_ACCOUNT_STATUS' => $responseJson['app']['data']['account_status'] ?? null,
                'USER_EMAIL' => $responseJson['app']['data']['email'] ?? null,
                'USER_ID' => $responseJson['app']['data']['user_id'] ?? null,
                'GROUP_USER' => $responseJson['app']['data']['group_user'] ?? null,
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
        if ($profile == 1) {
            // Make an API call if the profile condition is true
            $responseprofile = Http::withHeaders(Api::headers())
                ->asForm()
                ->get(Api::endpoint("/userprofiles?id={$responseJson['app']['data']['user_id']}&user_data={$xyz}&user_device={$finalresultDevice}"));

            // Decode the response JSON data
            $user_data = $responseprofile->json();

            // Return the 'profile.index' view with the fetched user data
            return view('profile.index', compact('user_data'));
        } else {
            // If $profile is not 1, redirect to the home page ('/')
            return redirect('/');
        }
    }
}
