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
                <div class="cred_form">
                    <div class="row">

                        <div class="col-md-6 ind1">
                            <div class="inner-div dv1">

                                <div class="social_space">
                                    <a class="btn_facebook text-decoration-none rounded" id="quickstart-sign-in"
                                        href="https://www.facebook.com/v2.5/dialog/oauth?client_id=927370914972377&amp;state=311e2d3d38cf44f2b7e8021e417dd935&amp;response_type=code&amp;sdk=php-sdk-5.7.0&amp;redirect_uri=https%3A%2F%2Fstage.24flix.tv%2Fcallback-fb.php&amp;scope=email"><i
                                            class="fa fa-facebook"></i> Login with Facebook</a>
                                </div>


                                <div class="social_space">
                                    <a class="btn_twitter text-decoration-none rounded"
                                        href="https://stage.24flix.tv/callback-lin.php"><i class="fa fa-linkedin"></i> Login
                                        with LinkedIn</a>
                                </div>


                                <div class="social_space">
                                    <a class="btn_google text-decoration-none rounded"
                                        href="https://accounts.google.com/o/oauth2/auth?response_type=code&amp;redirect_uri=https%3A%2F%2Fstage.24flix.tv%2Fcallback-google.php&amp;client_id=175923497855-e7bju0ipjeli0bofo62cqkj9ld83qqnp.apps.googleusercontent.com&amp;scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email&amp;access_type=offline&amp;approval_prompt=force"><i
                                            class="fa fa-google"></i> Login with Google</a>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-6">
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
                                        <input id="password" type="password" class="form-control pswFld" name="password"
                                            placeholder="Password" data-gtm-form-interact-field-id="1">
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
            </div>
        </form>
    </section>
@endsection
