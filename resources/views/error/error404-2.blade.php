@extends('layouts.app')
@push('style')
@endpush
@section('content')
    <div class="container text-center">
        <div class="row align-items-center justify-content-center" style="height: 45vh; ">
            <div class="col-xl-7">
                <p class="fs-3 fw-semibold mb-3 text-white">{{ $error }}</p>
            </div>
        </div>
    </div>
@endsection
