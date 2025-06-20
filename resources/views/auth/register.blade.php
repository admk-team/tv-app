@extends('layouts.app')

@section('content')
    <!-- Start of Sign Up form section  -->
    <section class="credential_form signForm">
        <div class="login_page main_pg">

            <div class="inner-cred">
                <h4>Create an Account</h4>
                @if (session()->has('error'))
                    <center>
                        <p style="color:red">{{ session()->get('error') }}</p>
                    </center>
                @endif
                <form method="POST" name='registeration_form' id="registerationForm" action="{{ route('register') }}"
                    class="cred_form">
                    @csrf
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

                            $col = $isFacebookActive || $isGoogleActive || $isLinkedinActive ? 'col-md-6' : 'col-md-12';
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
                                        <input id="name" type="text" class="form-control " placeholder="Name"
                                            name="name" value="" autocomplete="name" autofocus="">
                                        <img src="{{ asset('assets/images/ussr.png') }}" class="icn">
                                    </label>
                                    @error('name')
                                        <span class="error_box-register" id="span_name">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input_groupbox">
                                    <label class="contact-label">
                                        <div class="vertLine"></div>
                                        <input id="email" type="email" class="form-control" placeholder="Email"
                                            name="email"
                                            value="{{ old('email') ?? (isset($data) && isset($data['email']) ? $data['email'] : '') }}"
                                            autocomplete="email" autofocus>

                                        <img src="{{ asset('assets/images/mail.png') }}" class="icn mll">
                                    </label>
                                    @error('email')
                                        <span class="error_box-register" id="span_email">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input_groupbox">
                                    <label class="contact-label">
                                        <div class="vertLine"></div>
                                        <input id="password" type="password" class="form-control" name="password"
                                            placeholder="Password">
                                        <img src="{{ asset('assets/images/lock.png') }}" class="icn">
                                        <span id="eye_password" toggle="#password"
                                            class="far fa-light fa-eye field-icon toggle-password"
                                            style="display:none;"></span>
                                    </label>
                                
                                    @if ($errors->has('password'))
                                    <span class="error_box-register" id="span_password">
                                        @foreach ($errors->get('password') as $message)
                                            {{ $message }}
                                        @endforeach
                                        </span>
                                    @endif
                                </div>
                            
                                <div class="input_groupbox">
                                    <label class="contact-label">
                                        <div class="vertLine"></div>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            id="cpassword" placeholder="Confirm Password">
                                        <img src="{{ asset('assets/images/lock.png') }}" class="icn">
                                        <span id="eye_password" toggle="#cpassword"
                                            class="fa fa-light fa-eye field-icon toggle-password2"
                                            style="display:none;"></span>
                                    </label>
                                    @error('password_confirmation')
                                        <span class="error_box-register" id="span_cpassword">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-4">
                                    <button class="btn rounded" class="submit">SUBMIT</button>
                                </div>
                                <div class="input_groupbox alreadyText">
                                    <p class="fw-medium">Already have an account ? <a href="{{ route('login') }}">Click
                                            here to Login</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
