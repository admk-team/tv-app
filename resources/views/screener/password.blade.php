@extends('layouts.app')

@section('content')
<div class="container">
    <section class="credential_form signForm"> 
        <div>
                </div>
        <div class="login_page main_pg">
          
            <div class="inner-cred">
                <h4>Enter Password</h4>
                <center><p style="color:red"></p></center>
                <form method="POST" action="{{ route('screener.authenticate', $code) }}" class="cred_form"> 
                  @csrf
                  <input type="hidden" name="stream_guid" value="">
                  <input type="hidden" name="key" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="inner-div dv2">                        
                                <div class="input_groupbox">
                                    <label class="contact-label">
                                        <div class="vertLine"></div>
                                        <input type="hidden" name="email" value="{{ request()->email }}">
                                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" aria-autocomplete="list">                                    
                                        <img src="/images/lock.png" class="icn">                                    
                                        <span id="eye_password" toggle="#password" class="far fa-light fa-eye field-icon toggle-password" style="display:none;"></span>
                                    </label>
                                    <?php if (session()->has('error')): ?>
                                      <span class="error_box" id="span_password">{{ session('error') }}</span> 
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <button class="btn" name="checkPassword" value="true">SUBMIT</button>                              
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')

@endpush
