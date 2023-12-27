@extends('layouts.app')

@section('content')
    <section class="credential_form signForm">
        <div class="login_page main_pg">
            <div class="inner-cred">
                <h4>Payment Status</h4>
                <center>
                    <p style="color:white">Payment saved successfully.</p>
                </center>
                <div class="row">
                    <div class="col-md-12">
                        <div class="inner-div dv22">
                            <h2 style="color:yellow">Congratulation !</h2>
                            <p style="color:green"><b>Transaction ID:</b> {{ $transactionId }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
