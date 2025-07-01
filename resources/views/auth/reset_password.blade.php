@extends('layouts.app')

@section('content')
    <section class="credential_form signForm">
        <form method="POST" name="change_pass_frm" id="change_pass_frm" action="{{ route('reset.password') }}">
            @csrf
            <input type="hidden" name="userCode" value="{{ session('USER_DETAILS.USER_CODE') }}">

            <div class="login_page main_pg inner-cred">
                <h4>Reset Your Password</h4>

                {{-- Global Flash Messages --}}
                <center>
                    @if (session()->has('success'))
                        <p style="color:green; font-weight: 400;">{{ session('success') }}</p>
                    @endif
                    @if (session()->has('error'))
                        <p style="color:red; font-weight: 400;">{{ session('error') }}</p>
                    @endif

                    {{-- Laravel Validation Errors --}}
                    @if ($errors->any())
                        <div style="color:red;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <p style="color:red">
                        @isset($data['msg'])
                            {{ $data['msg'] }}
                        @endisset
                    </p>
                </center>

                <div class="cred_form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="inner-div dv22">

                                {{-- Old Password --}}
                                <div class="input_groupbox">
                                    <label class="contact-label">
                                        <div class="vertLine"></div>
                                        <input class="form-control" type="password" name="oldPassword" id="oldPassword"
                                               placeholder="Old Password" maxlength="30" required>
                                        <img src="{{ asset('assets/images/lock.png') }}" class="icn">
                                    </label>
                                    <span class="error_box" id="span_oldPassword">
                                        @error('oldPassword') {{ $message }} @enderror
                                    </span>
                                </div>

                                {{-- New Password --}}
                                <div class="input_groupbox">
                                    <label class="contact-label">
                                        <div class="vertLine"></div>
                                        <input class="form-control" type="password" name="password" id="password"
                                               placeholder="New Password" maxlength="30" required>
                                        <img src="{{ asset('assets/images/lock.png') }}" class="icn">
                                    </label>
                                    <span class="error_box" id="span_password">
                                        @error('password') {{ $message }} @enderror
                                    </span>
                                </div>

                                {{-- Confirm Password --}}
                                <div class="input_groupbox">
                                    <label class="contact-label">
                                        <div class="vertLine"></div>
                                        <input class="form-control" type="password" name="password_confirmation"
                                               id="password_confirmation" placeholder="Confirm Password" maxlength="30" required>
                                        <img src="{{ asset('assets/images/lock.png') }}" class="icn">
                                    </label>
                                    <span class="error_box" id="span_password_confirmation">
                                        @error('password_confirmation') {{ $message }} @enderror
                                    </span>
                                </div>

                                {{-- Submit --}}
                                <div class="form-group">
                                    <button type="submit" class="btn rounded">Reset Password</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
