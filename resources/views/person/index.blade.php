@extends('layouts.app')

@section('content')
<style>
    .tab-nav-wrapper p  span {
        color: white !important;
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
                            <img class="" src="{{ env('BASE_URL') . '/storage/' . $data['poster'] }}" class="actor-img" width="400px" height="600px"alt="none">
                        @else
                            <img class="w-100" src="{{ asset('assets/images/default.png') }}" class="actor-img" width="400px" height="600px"
                                alt="none">
                        @endif
                    </div>
                    <div class="col-12 col-md-8 actor-video d-flex col-lg-8">
                        <div class="video-container d-flex align-items-center">
                            <h1 class="text-white">
                                {{ $data['name'] }}
                            </h1>
                            
                        </div>
                    </div>
                    @if($data['description'])
                    <div class="about-actor text-white" style="font-size:x-large;">
                        <h1>Bio</h1>
                        {!! $data['description'] !!}
                    </div>
                    @endif
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
                                    <a href='{{ route('detailscreen', $stream['code']) }}'>
                                        <div class="ripple">
                                            <div class="trending_icon_box" {!! $stream['monetization_type'] == 'F'? 'style="display: none;"': '' !!}><img
                                                    src="{{ url('/') }}/assets/images/trending_icon.png" alt="{{ $stream['title'] }}">
                                            </div>
                                            <div class="">
                                                <img src="{{ $stream['poster'] }}"
                                                    alt="{{ $stream['title'] }}">
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
