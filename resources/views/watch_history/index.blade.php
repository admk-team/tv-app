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
            transform: scale(1.1);
            /* Adjust the scale factor as needed */
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
                    @if (isset($data['app']['streams']) && is_array($data['app']['streams']))
                        @foreach ($data['app']['streams'] as $key => $stream)
                            @if ($key >= 30)
                            @break
                        @endif
                        <div class="card mb-4 mt-4" style="background-color: black; color:white;">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    {{--  <a href="{{ route('detailscreen', $stream['stream_guid']) }}">
                                    <div class="thumbnail_img">
                                        <div>
                                            <img src="{{ $stream['stream_poster'] }}"
                                                alt="{{ $stream['stream_title'] }}">
                                        </div>
                                        <div class="detail_box_hide">
                                            <div class="detailbox_time">
                                                {{ $stream['stream_duration_timeformat'] ?? '' }}
                                            </div>
                                            <div class="deta_box">
                                                <div class="season_title">
                                                </div>
                                                <div class="content_title"> {{ $stream['stream_title'] }}</div>
                                                <div class="content_description">
                                                    {{ $stream['stream_description'] }}
                                                </div>
                                                @if ($stream['stream_watched_dur_in_pct'] > 1)
                                                    <div
                                                        style="background-color:#555455;height:5px; border-radius:2px;margin-top:10px;">
                                                        <div
                                                            style="background-color:#07659E;height:5px;border-radius:2px;width:{{ $stream['stream_watched_dur_in_pct'] }}%">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>  --}}
                                    <a href="{{ route('detailscreen', $stream['stream_guid']) }}">
                                        <img src="{{ $stream['stream_poster'] }}" alt="{{ $stream['stream_title'] }}"
                                            class="img-fluid" style="position: relative;">
                                        @if ($stream['stream_watched_dur_in_pct'] > 1)
                                            <div class="progress"
                                                style="background-color:#555455;height:5px; border-radius:2px;">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    style="background-color:#07659E;height:5px;border-radius:2px;width: {{ $stream['stream_watched_dur_in_pct'] }}%"
                                                    aria-valuenow="{{ $stream['stream_watched_dur_in_pct'] }}"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                <div class="col-md-8 ">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $stream['stream_title'] }}</h5>
                                        <div class="content-timing">
                                            @if ($stream['released_year'])
                                                <a href="{{ route('year', $stream['released_year']) }}"
                                                    class="text-decoration-none">
                                                    <span class="year">{{ $stream['released_year'] }}</span>
                                                </a>
                                                <span class="dot-sep"></span>
                                            @endif
                                            @if ($stream['stream_type'] != 'S')
                                                @if ($stream['stream_duration'] && $stream['stream_duration'] !== '0')
                                                    <span>{{ \App\Helpers\GeneralHelper::showDurationInHourAndMins($stream['stream_duration']) }}</span>
                                                    <span class="dot-sep"></span>
                                                @endif
                                                {{-- <span class="movie_type">{{ $stream['cat_title'] }}</span> --}}
                                                <span class="movie_type">
                                                    @foreach ($stream['genre'] ?? [] as $item)
                                                        <a href="{{ route('category', $item['code']) }}?type=genre"
                                                            class="px-0">{{ $item['title'] }}</a>{{ !$loop->last ? ', ' : '' }}
                                                    @endforeach
                                                </span>
                                            @endif
                                            @if ($stream['stream_type'] == 'S')
                                                <span
                                                    class="movie_type">{{ $stream['stream_episode_title'] && $stream['stream_episode_title'] !== 'NULL' ? $stream['stream_episode_title'] : '' }}</span>
                                            @endif
                                            @if ($stream['content_qlt'] != '')
                                                <span class="content_screen">
                                                    @php
                                                        $content_qlt_arr = explode(',', $stream['content_qlt']);
                                                        $content_qlt_codes_arr = explode(
                                                            ',',
                                                            $stream['content_qlt_codes'],
                                                        );
                                                    @endphp
                                                    @foreach ($content_qlt_arr as $i => $item)
                                                        <a
                                                            href="{{ route('quality', trim($content_qlt_codes_arr[$i])) }}">{{ $item }}</a>
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </span>
                                            @endif
                                            @if ($stream['content_rating'] != '')
                                                <span class="content_screen">
                                                    @php
                                                        $content_rating_arr = explode(',', $stream['content_rating']);
                                                        $content_rating_codes_arr = explode(
                                                            ',',
                                                            $stream['content_rating_codes'],
                                                        );
                                                    @endphp
                                                    @foreach ($content_rating_arr as $i => $item)
                                                        <a
                                                            href="{{ route('rating', trim($content_rating_codes_arr[$i])) }}">{{ $item }}</a>
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </span>
                                            @endif
                                        </div>
                                        <p class="card-text " style="max-height: 8em; overflow: hidden;">
                                            {{ Illuminate\Support\Str::limit($stream['stream_description'], $limit = 200, $end = '...') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
