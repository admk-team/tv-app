@extends('layouts.app')

@section('content')
    <style>
        .tab-nav-wrapper p span {
            color: white !important;
        }

        .actor-img {
            width: auto !important;
            height: 365px;
            max-width: 100%;
        }

        .container {
            margin-right: 0px;
            margin-left: 0px;
            padding-left: 37px;
        }

        @media (max-width: 486px) {
            .container {
                margin-right: 0px;
                margin-left: 0px;
                padding-left: 8px;
            }
        }
    </style>
    <section class="banner detailBanner">
        <div class="container-fluid actor-container">
            <div class="container mt-4">
                <div class="d-flex detail-writer">
                    <ul class="row">
                        <li class="list-unstyled actor-desc text-white"></li>
                    </ul>
                </div>
                <div class="d-flex row">
                    <div class=" col-12 col-md-4 d-flex col-lg-4">
                        @if ($data['poster'] != '')
                            <img class="" src="{{ $data['poster'] }}" class="actor-img" alt="none"
                                style="max-width: 100%;">
                        @else
                            <img class="w-100 actor-img" src="{{ asset('assets/images/default.png') }}" alt="none">
                        @endif
                    </div>
                    <div
                        class="video-container col-12 col-md-8 actor-video d-flex col-lg-8 d-flex flex-column align-items-right align-self-center">
                        <h1 class="text-white">
                            {{ $data['name'] }}
                        </h1>
                        @if (session()->has('USER_DETAILS') && session('USER_DETAILS') !== null)
                            @if ($follows)
                                <div class="d-inline-block mt-3 mb-3">
                                    <a href="{{ route('toggle.follow', $data['code']) }}"
                                        class="auth app-secondary-btn rounded">Unfollow</a>
                                </div>
                            @else
                                <div class="d-inline-block mt-3 mb-3">
                                    <a href="{{ route('toggle.follow', $data['code']) }}"
                                        class="auth app-secondary-btn rounded">Follow</a>
                                </div>
                            @endif
                        @endif
                        @if ($data['description'])
                            <div class="about-actor text-white" style="font-size:large;">
                                {!! $data['description'] !!}
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="overflow-hidden">
        <div class="listing_box">
            <div class="slider_title_box">
                <div class="list_heading">
                    <h1>Media pertaining to {{ $data['name'] }}</h1>
                </div>
            </div>
            <div class="sliders">
                <div class="slider-container">
                    <div class="landscape_slider slider slick-slider">
                        @foreach ($data['streams'] as $stream)
                            <div class="item">
                                <div class="thumbnail_img">
                                    @php
                                        $url = $stream['contentType'] == 'series' ? 'series' : 'detailscreen';
                                    @endphp
                                    <a href="{{ route($url, $stream['stream_guid']) }}">
                                        <div class="ripple">
                                            <div class="trending_icon_box" {!! $stream['monetization_type'] == 'F' ? 'style="display: none;"' : '' !!}><img
                                                    src="{{ url('/') }}/assets/images/trending_icon.png"
                                                    alt="{{ $stream['stream_title'] }}">
                                            </div>
                                            <div class="">
                                                <img src="{{ $stream['stream_poster'] }}" alt="{{ $stream['stream_title'] }}">
                                            </div>
                                            <div class="detail_box_hide">
                                                {{-- <div class="detailbox_time">
                                                    {{ $stream['duration'] ?? '' }}
                                                </div> --}}
                                                <div class="deta_box">
                                                    <div class="season_title"></div>
                                                    <div class="content_title">{{ $stream['stream_title'] }}</div>
                                                    <div class="content_description">{{ $stream['stream_description'] }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
