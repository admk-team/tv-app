@extends('layouts.app')

@section('content')
    <section class="credential_form signForm">
        <div class="login_page main_pg">
            <div class="inner-cred">
                <h4>FORGOT PASSWORD</h4>
                <center>
                    @if (isset($data['app']['status']) && $data['app']['status'] == 0)
                        <p style="color:red; font-weight: 400;">
                            @isset($data['app']['msg'])
                                {{ $data['app']['msg'] }}
                            @endisset
                        </p>
                    @endif
                    @if (isset($data['app']['status']) && $data['app']['status'] == 1)
                        <p style="color:rgb(0, 131, 0); font-weight: 400;">
                            @isset($data['app']['msg'])
                                {{ $data['app']['msg'] }}
                            @endisset
                        </p>
                    @endif
                </center>
                <form name="verify_frm" id="verify_frm" method="POST" action="{{ route('forgot') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="inner-div dv22">
                                <div class="input_groupbox">
                                    <label class="contact-label">
                                        <div class="vertLine"></div>
                                        <input id="email" type="text" class="form-control" placeholder="Email"
                                            name="email" autocomplete="email" autofocus>
                                        <img src="{{ asset('assets/images/mail.png') }}" class="icn mll">
                                    </label>
                                    @error('email')
                                        <span class="error_box">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn submit">Submit</button>
                                </div>
                                <div class="input_groupbox alreadyText mt-4">
                                    <a class="text-decoration-none" href="{{ route('login') }}">Go back to Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
