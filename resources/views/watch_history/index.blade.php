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
    </style>
@endpush

@section('content')
    <section class="">
        <div class="">
            <div class="listing_box" style="padding-left: 350px">
                <div class="slider_title_box">
                    <div class="list_heading">
                        <h1>Watch History</h1>
                    </div>
                </div>
                @foreach ($data['app']['streams'] as $key => $stream)
                    @if ($key >= 30)
                    @break
                @endif
                <div class="d-flex gap-4 mt-4 mb-4" style="max-width: 1000px;">
                    <div class="">
                        <div class="ripple">
                            <a href="{{ route('detailscreen', $stream['stream_guid']) }}">
                                <div class="thumbnail_img">
                                    {{--  <div class="trending_icon_box" {!! $stream['stream_guid'] == 'F' ? 'style="display: none;"' : '' !!}>
                                        <img src="{{ url('/') }}/assets/images/trending_icon.png" alt="Trending">
                                    </div>  --}}
                                    <div>
                                        <img src="{{ $stream['stream_poster'] }}" alt="{{ $stream['stream_title'] }}">
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
                            </a>
                        </div>
                    </div>
                    <div class="">
                        <div class="content_title mt-5" style="font-size: 28px;">{{ $stream['stream_title'] }}
                        </div>
                        <div class="content_description mt-5 mb-1"
                            style=" font-size: 14px;line-height: 22px !important; ">
                            {{ $stream['stream_description'] }}
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
@endsection
