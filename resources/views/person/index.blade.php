@extends('layouts.app')

@section('content')
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
                            <img class="" src="{{ env('BASE_URL') . '/storage/' . $data['poster'] }}" class="actor-img"
                                alt="none">
                        @else
                            <img class="w-100" src="{{ asset('assets/images/default.png') }}" class="actor-img"
                                alt="none">
                        @endif
                    </div>
                    <div class="col-12 col-md-8 actor-video d-flex col-lg-8">
                        <div class="video-container d-flex align-items-center">
                            <p class="text-white">
                                {{ $data['description'] }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="about-actor">
                </div>
            </div>
        </div>
    </section>
    <section class="overflow-hidden">
        <div class="listing_box">
            <div class="slider_title_box">
                <div class="list_heading">
                    <h1>Related videos</h1>
                </div>
            </div>
            <div class="sliders">
                <div class="slider-container">
                    <div class="landscape_slider slider slick-slider">
                        @foreach ($data['streams'] as $stream)
                            <div class="item">
                                <div class="thumbnail_img">
                                    <a href='{{ route('detailscreen', $stream['code']) }}'>
                                        <div class="ripple">
                                            <div class="trending_icon_box" style='display: none;'><img
                                                    src="{{ $stream['next_screen_feed_url'] ?? '' }}" alt="Gallows Road">
                                            </div>
                                            <div class="">
                                                <img src="{{ env('BASE_URL') . '/storage/' . $stream['poster'] }}"
                                                    alt="Gallows Road">
                                            </div>
                                            <div class="detail_box_hide">
                                                {{-- <div class="detailbox_time">
                                                    {{ $stream['duration'] ?? '' }}
                                                </div> --}}
                                                <div class="deta_box">
                                                    <div class="season_title"></div>
                                                    <div class="content_title">{{ $stream['title'] }}</div>
                                                    <div class="content_description">{{ $stream['short_description'] }}
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
