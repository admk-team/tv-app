@extends('layouts.app')

@section('content')
<div class="container">
    <section class="credential_form signForm"> 
        <div>
                </div>
        <div class="login_page main_pg">
          
            <div class="inner-cred py-5 my-5">
                <h5 class="text-white">Screener will be started at {{ $startTime }}</h5>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')

@endpush
