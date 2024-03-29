{{-- @extends('errors::minimal') --}}
@extends('layouts.app')
@section('content')
    <div class="container ">
        <div class="d-flex flex-column  align-items-center justify-content-center " style="height: 50vh;">
            <h2 class="text-white">Something Went Wrong</h2>
            <p class="text-white">Please get in touch with the admin for support</p>
        </div>
    </div>
@endsection
{{-- @section('title', __('Server Error')) --}}
{{-- @section('title', __('Something Went Wrong'))
@section('code', '500') --}}
{{-- @section('message', __('Server Error')) --}}
{{-- @section('message', __('Something Went Wrong')) --}}
