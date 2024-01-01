@extends('layouts.app')

@section('content')
    <section class="sliders topSlider gridSection" style="padding-top: 38px;">
        <div class="slider-container">
            <div class="listing_box allVideosBox">
                <div class="col-md-12">
                    <form action="{{ route('search') }}">
                        <div class="searchbox">
                            <input type="text" class="search_bar" name="searchKeyword" id="searchKeyword" value=""
                                placeholder="Search" required="">
                            <span class="search_icon"><button type="submit"
                                    style="text-decoration:none;border: none;background-color: #ffffff;"><img
                                        src="https://stage.24flix.tv/images/searchs.png"></button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    <div class="list_heading">
                        <h1>{{ $searchResult['total_rcd'] }} Records Match for this Keyboard "{{ $keyword }}"</h1>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="innerAlVidBox">
                        @foreach ($searchResult['streams'] as $stream)
                            <div class="resposnive_Box">
                                <a href="{{ route('detailscreen', $stream['stream_guid']) }}">
                                    <div class="thumbnail_img">
                                        <div class="trending_icon_box" style="display: none;"><img
                                                src="https://stage.24flix.tv/images/trending_icon.png"
                                                alt="A Case of Identity">
                                        </div>
                                        <img
                                            src="{{ $stream['stream_poster'] ?? '' }}"
                                            alt="A Case of Identity">
                                        <div class="detail_box_hide">
                                            <div class="detailbox_time">{{ $stream['stream_duration_timeformat'] }}</div>
                                            <div class="deta_box">
                                                <div class="season_title">{{ $stream['stream_episode_title'] ?? '' }}</div>
                                                <div class="content_title">{{ $stream['stream_title'] }}</div>
                                                <div class="content_description">{{ $stream['stream_description'] ?? '' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
