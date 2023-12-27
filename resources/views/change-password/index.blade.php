@extends('layouts.app')

@section('content')
    <section class="credential_form signForm">
        <div>
        </div>
        <div class="login_page main_pg">
            <div class="inner-cred">
                <h4>Change Password</h4>
                @if (session()->has('error'))
                    <center>
                        <p style="color:red; font-weight: 400;">{{ session('error') }}</p>
                    </center>
                @endif
                @if (session()->has('success'))
                    <center>
                        <p style="color:rgb(0, 131, 0); font-weight: 400;">{{ session('success') }}</p>
                    </center>
                @endif
                <form method="POST" name="change_pass_frm" id="change_pass_frm" action="{{ route('password.update') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="inner-div dv22">
                                <div class="input_groupbox">
                                    <label class="contact-label">
                                        <div class="vertLine"></div>
                                        <input type="password" name="oldPassword" id="oldPassword"
                                            placeholder="Old Password" value="" maxlength="30" class="form-control">
                                        <img src="{{ asset('assets/images/lock.png') }}" class="icn">
                                    </label>
                                    <span class="error_box" id="span_oldPassword">
                                        @error('oldPassword')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="input_groupbox">
                                    <label class="contact-label">
                                        <div class="vertLine"></div>
                                        <input class="form-control" type="password" name="password" id="password"
                                            value="" placeholder="New Password" maxlength="30">
                                        <img src="{{ asset('assets/images/lock.png') }}" class="icn">
                                    </label>
                                    <span class="error_box" id="span_password">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="input_groupbox">
                                    <label class="contact-label">
                                        <div class="vertLine"></div>
                                        <input class="form-control" type="password" name="password_confirmation"
                                            id="cpassword" value="" placeholder="Confirm Password" maxlength="30">
                                        <img src="{{ asset('assets/images/lock.png') }}" class="icn">
                                    </label>
                                    <span class="error_box" id="span_cpassword">
                                        @error('password_confirmation')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <button class="btn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
