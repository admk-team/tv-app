@extends('layouts.app')

@push('style')
    <style>
        body {
            overflow-x: hidden;
        }

        .main-div {
            height: 100% !important;
        }

        .whoIsWatching {
            padding-top: 120px;
        }

        .addIcon i {
            font-size: 7.9vw !important;
        }

        .item {
            padding: 10px;
        }

        .card:hover img {
            transform: scale(1.1); /* Adjust the scale factor as needed */
            transition: transform 0.3s ease-in-out;
        }
    </style>
@endpush

@section('content')
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="listing_box">
                    <div class="slider_title_box">
                        <div class="list_heading text-center">
                            <h1>Watch History</h1>
                        </div>
                    </div>
                    @foreach ($data['app']['streams'] as $key => $stream)
                        @if ($key >= 30)
                            @break
                        @endif
                        <div class="card mb-4 mt-4" style="background-color: black; color:white;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <a href="{{ route('detailscreen', $stream['stream_guid']) }}">
                                        <img src="{{ $stream['stream_poster'] }}" alt="{{ $stream['stream_title'] }}"
                                            class="img-fluid" style="position: relative;">
                                        @if ($stream['stream_watched_dur_in_pct'] > 1)
                                            <div class="progress" style="background-color:#555455;height:5px; border-radius:2px;">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    style="background-color:#07659E;height:5px;border-radius:2px;width: {{ $stream['stream_watched_dur_in_pct'] }}%"
                                                    aria-valuenow="{{ $stream['stream_watched_dur_in_pct'] }}"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                <div class="col-md-8 mt-5">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $stream['stream_title'] }}</h5>
                                        <p class="card-text text-truncate" style="max-height: 8em; overflow: hidden;">
                                            {{ Illuminate\Support\Str::limit($stream['stream_description'], $limit = 300, $end = '...') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
