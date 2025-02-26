@extends('layouts.app')

@section('content')
    <section class="credential_form signForm">
        <form name="signin_frm" id="signin_frm" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="login_page main_pg inner-cred">
                <h4>Login</h4>
                <center>
                    <p style="color:green">
                        @if (session()->has('success'))
                            {{ session('success') }}
                        @endif
                    </p>
                    <p style="color:red">
                        @if (session()->has('error'))
                            {{ session('error') }}
                        @endif
                    </p>
                    <p style="color:red">
                        @isset($data['app']['msg'])
                            {{ $data['app']['msg'] }}
                        @endisset
                    </p>
                </center>
                @if (Request::get('user_login') & Request::get('token'))
                    <div class="cred_form2">
                        <div class="row">
                            {{-- <div class="col-md-12"> --}}
                            <div class="inner-div">
                                <div class="form-group">
                                    <input type="hidden" name="requestAction" value="validateUserAccount">
                                    <input type="hidden" name="user_code" value="{{ Request::get('user_login') }}">
                                    <input type="hidden" name="admin_code" value="{{ Request::get('token') }}">
                                    <input type="hidden" name="headerRedirectUrl" value="signin">
                                    <button class="btn rounded"
                                        style="max-width: 220px; margin-left: 40%; margin-bottom:10%" type="submit">Login
                                        As Viewer</button>
                                </div>
                            </div>
                            {{-- </div> --}}
                        </div>
                    </div>
                @else
                    <div class="cred_form">
                        <div class="row">
                            @php
                                $branding = \App\Services\AppConfig::get()->app->colors_assets_for_branding;
                                $isFacebookActive =
                                    isset($branding->is_facebook_feature_active) &&
                                    $branding->is_facebook_feature_active === 'true';
                                $isGoogleActive =
                                    isset($branding->is_google_feature_active) &&
                                    $branding->is_google_feature_active === 'true';
                                $isLinkedinActive =
                                    isset($branding->is_linkedin_feature_active) &&
                                    $branding->is_linkedin_feature_active === 'true';

                                $col = $isFacebookActive || $isGoogleActive || $isLinkedinActive
                                        ? 'col-md-6'
                                        : 'col-md-12';
                            @endphp
                            @if ($col == 'col-md-6')
                                <div class="col-md-6 ind1">
                                    <div class="inner-div dv1">
                                        @if (isset(\App\Services\AppConfig::get()->app->colors_assets_for_branding->is_facebook_feature_active) &&
                                                \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_facebook_feature_active === 'true')
                                            <div class="social_space">
                                                <a class="btn_facebook text-decoration-none rounded" id="quickstart-sign-in"
                                                    href="{{ route('facebook') }}"><i class="fa-brands fa-facebook"></i>
                                                    Login
                                                    with Facebook</a>
                                            </div>
                                        @endif

                                        @if (isset(\App\Services\AppConfig::get()->app->colors_assets_for_branding->is_linkedin_feature_active) &&
                                                \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_linkedin_feature_active === 'true')
                                            <div class="social_space">
                                                <a class="btn_twitter text-decoration-none rounded"
                                                    href="{{ route('linkedin') }}"><i class="fa-brands fa-linkedin"></i>
                                                    Login
                                                    with LinkedIn</a>
                                            </div>
                                        @endif


                                        @if (isset(\App\Services\AppConfig::get()->app->colors_assets_for_branding->is_google_feature_active) &&
                                                \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_google_feature_active === 'true')
                                            <div class="social_space">
                                                <a class="btn_google text-decoration-none rounded"
                                                    href="{{ route('social') }}"><i class="fa-brands fa-google"></i> Login
                                                    with
                                                    Google</a>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endif
                            <div class="{{ $col }}">
                                <div class="inner-div dv2">
                                    <div class="input_groupbox">

                                        <label class="contact-label">
                                            <div class="vertLine"></div>
                                            <input id="email" type="text" class="form-control " placeholder="Email"
                                                name="email" autocomplete="email" autofocus=""
                                                data-gtm-form-interact-field-id="0">
                                            <img src="{{ asset('assets/images/mail.png') }}" class="icn mll">
                                        </label>
                                        <span class="error_box" id="span_email">
                                            @error('email')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="input_groupbox">
                                        <label class="contact-label">
                                            <div class="vertLine"></div>
                                            <input id="password" type="password" class="form-control pswFld"
                                                name="password" placeholder="Password" data-gtm-form-interact-field-id="1">
                                            <!-- <i class="fa fa-lock"></i> -->
                                            <img src="{{ asset('assets/images/lock.png') }}" class="icn">
                                            <span toggle="#password"
                                                class="fa fa-light fa-eye field-icon toggle-password3"></span>
                                        </label>
                                        <span class="error_box" id="span_password">
                                            @error('password')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group text-right forgotPsw">
                                        <div class="d-flex justify-content-between">
                                            <p class="py-1"><a class="text-decoration-none" href="/verify">EMAIL
                                                    VERIFICATION?</a></p>
                                            <p class="py-1"><a class="text-decoration-none" href="/forgot">FORGOT
                                                    PASSWORD?</a></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn rounded" type="submit">LOGIN</button>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="frmToken" value="72ad5973dcc371103a37ec121283a979">
                                        <input type="hidden" name="requestAction" value="validateUserAccount">
                                        <input type="hidden" name="headerRedirectUrl" value="signin">
                                    </div>
                                    @if (\App\Services\AppConfig::get()->app->app_info->is_signup_btn_show === 'Y')
                                        <div class="input_groupbox alreadyText mt-3">
                                            <p>Do not have an account? <a class="text-decoration-none"
                                                    href="{{ route('register') }}">Click here to Register</a></p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @endif

            </div>
        </form>
    </section>
@endsection
