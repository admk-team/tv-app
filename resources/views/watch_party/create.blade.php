@extends('layouts.app')
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <style>
        .custom_color {
            color: #000 !important;
            background-color: #fff !important;
        }
    </style>
@endsection



@section('content')
    <section class="sliders topSlider gridSection"
        style="background: url(https://admk.24flix.tv/images/oops.gif) no-repeat; background-size: cover; background-position:center;height: 100vh;">
        <div class="container">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }} <!-- Accessing the 'error' session -->
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }} <!-- Accessing the 'success' session -->
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title fw-semibold">{{ __('Host a Watch Party') }}</h5>
                    </div>
                </div>
                <div class="card-body pt-0 mx-2">
                    <form action="{{ route('store.watch.party') }}" method="POST">
                        @csrf
                        <!-- Watch Party Details -->
                        <div class="col-lg-12 my-3">
                            <div class="row">
                                 <div class="col-lg-3 my-2">
                                    <label for="title" class="form-label ">{{ __('Title') }}</label>
                                    <input type="text" name="title" class="form-control custom_color" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-3 my-2">
                                    <label for="start_date" class="form-label ">{{ __('Start Date') }}</label>
                                    <input type="date" name="start_date" class="form-control custom_color" required>
                                    @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-3 my-2">
                                    <label for="start_time" class="form-label">{{ __('Start Time') }}</label>
                                    <input type="time" name="start_time" class="form-control custom_color" required>
                                    @error('start_time')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="col-lg-3 my-2">
                                    <label for="end_date" class="form-label">{{ __('End Date') }}</label>
                                    <input type="date" name="end_date" class="form-control custom_color" required>
                                    @error('end_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-3 my-2">
                                    <label for="end_time" class="form-label">{{ __('End Time') }}</label>
                                    <input type="time" name="end_time" class="form-control custom_color" required>
                                    @error('end_time')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Stream Code (Hidden Field) -->
                        <input type="hidden" name="stream_code[]" value="{{ request()->route('streamCode') }}">
                        <input type="hidden" name="host_email"
                            value="{{ session('USER_DETAILS')['USER_EMAIL'] ?? null }}">
                        <div class="col-lg-6 my-2">
                            <label for="viewer_emails" class="form-label">{{ __('Viewer Emails:') }}</label>
                            <select name="viewer_emails[]" id="viewer_emails" class="form-control" required multiple>
                                @foreach ($viewerEmails ?? [] as $email)
                                    <option value="{{ $email }}" selected>{{ $email }}</option>
                                @endforeach
                            </select>
                            @error('viewer_emails.*')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="app-primary-btn my-3 float-end rounded">SAVE</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#viewer_emails').select2({
            tags: true,
            tokenSeparators: [',', ' ', '\n'],
            placeholder: "Enter viewer emails",
            width: '100%',
            minimumResultsForSearch: Infinity
        });
        $(".stream-select2-multiple").select2({
            tags: false,
            placeholder: "Select",
            maximumSelectionLength: 1,
        });
    </script>
@endpush
