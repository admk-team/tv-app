@extends('layouts.app')




@section('content')
    <style>
        .card-custom {
            background-color: var(--bgcolor);
            color: var(--themePrimaryTxtColor);
            border: 1px solid var(--themeActiveColor) !important;
            /* Correct border declaration */
            border-radius: 4px !important;
            /* Optional: Adjust as needed */
        }
    </style>
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="listing_box">
                    @if (isset($data['app']['streams']) && is_array($data['app']['streams']) && count($data['app']['streams']) > 0)
                        <div class="slider_title_box" style="margin-top: 50px;">
                            <div class="list_heading text-center">
                                <h1>Watch History</h1>
                            </div>
                        </div>
                        @foreach ($data['app']['streams'] as $key => $stream)
                            @if ($key >= 30)
                            @break
                        @endif
                        <div class="card mb-4 mt-4 card-custom p-2">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    @php
                                        if (
                                            (isset(
                                                \App\Services\AppConfig::get()->app->app_info->bypass_detailscreen,
                                            ) &&
                                                \App\Services\AppConfig::get()->app->app_info->bypass_detailscreen ==
                                                    1) ||
                                            $stream['bypass_detailscreen'] == 1
                                        ) {
                                            $screen = 'playerscreen';
                                        } else {
                                            $screen = 'detailscreen';
                                        }
                                    @endphp
                                    <a href="{{ url('/') }}/{{ $screen }}/{{ $stream['stream_guid'] }}">
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
                                    <div class="card-body p-0">
                                        <h5 class="card-title">{{ $stream['stream_title'] }}</h5>
                                        <div class="content-timing">
                                            @if ($stream['released_year'] && $stream['released_year'] !== 'NULL')
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
                                                    @foreach ($stream['genres'] ?? [] as $genre)
                                                        <a href="{{ route('category', $genre['code']) }}?type=genre"
                                                            class="px-0">{{ $genre['title'] }}</a>{{ !$loop->last ? ', ' : '' }}
                                                    @endforeach
                                                </span>
                                            @endif
                                            @if ($stream['stream_type'] == 'S')
                                                <span
                                                    class="movie_type">{{ $stream['stream_episode_title'] && $stream['stream_episode_title'] !== 'NULL' ? $stream['stream_episode_title'] : '' }}</span>
                                            @endif
                                            @if (!empty($stream['content_qlt']))
                                                <span class="content_screen">
                                                    @php
                                                        $ratingTitle = $stream['content_qlt']['title'];
                                                        $ratingCode = $stream['content_qlt']['code'];
                                                    @endphp
                                                    <a
                                                        href="{{ route('quality', trim($ratingCode)) }}">{{ $ratingTitle }}</a>
                                                </span>
                                            @endif
                                            @if (!empty($stream['content_rating']))
                                                <span class="content_screen">
                                                    @php
                                                        $ratingTitle = $stream['content_rating']['title'];
                                                        $ratingCode = $stream['content_rating']['code'];
                                                    @endphp
                                                    <a
                                                        href="{{ route('rating', trim($ratingCode)) }}">{{ $ratingTitle }}</a>
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
                @else
                    <div class="slider_title_box" style="margin-top: 50px; margin-bottom: 50px;">
                        <div class="list_heading text-center">
                            <h1>To start building your watch history, please begin watching content</h1>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
