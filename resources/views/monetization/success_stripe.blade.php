@extends('layouts.app')

@section('content')
    <section class="credential_form signForm"> 
        <div>
                </div>
        <div class="login_page main_pg">
        
            <div class="inner-cred">
                <h4>Payment Status</h4>
                <center><p style="color:white">{{ session()->get('statusMsg') }}</p></center>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="inner-div dv22">
                            <h2 style="color:yellow">{{ session()->get('title') }}</h2>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </section>
    <script>
            var timer = setTimeout(function() {
                window.location='{{ session('REDIRECT_TO_SCREEN') }}'
            }, 3000);
    </script>
@endsection
