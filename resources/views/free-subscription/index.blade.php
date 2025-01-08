@extends('layouts.app')

@section('content')
    <section class="credential_form signForm">
        <div class="login_page topinnew_gaps pt-0">
            <div class="full_video_container">
                <main class="price_table w-100 m-auto">
                    <div class="container py-3">
                        <div class="detailtitle">Subscription</div>
                        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                            <div class="col mx-auto">
                                <div class="card mb-4 rounded-3 shadow-sm">
                                    <div class="card-header py-3 bg-primary">
                                        <h4 class="my-0 fw-bold text-uppercase text-white">Subscription Status</h4>
                                    </div>
                                    <div class="card-body">
                                        <h1 class="card-title text-success mt-4">Great!</h1>
                                        <small class="fw-bold text-success"></small>
                                        <ul class="list-unstyled mt-3 mb-4">
                                            Payment saved successfully. </ul>
                                        <a href="{{ url('/') }}" class="w-100 btn btn-md btn-outline-primary"> Go to
                                            Homepage</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>

    <script>
        @if (session('REDIRECT_TO_SCREEN'))
            var timer = setTimeout(function() {
                window.location = '{{ session('REDIRECT_TO_SCREEN') }}'
            }, 3000);
        @endif
    </script>
@endsection
