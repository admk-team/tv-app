@extends('layouts.app')

@section('meta-tags')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content='article' />
    <meta property="og:url" content="{{ url('/detailscreen/' . $stream_details['stream_guid']) }}" />
    <meta name="twitter:title" content="{{ @$stream_details['stream_title'] }}">
    <meta name="twitter:description" content="{{ @$stream_details['stream_description'] }}">
    <meta property="og:title" content="{{ @$stream_details['stream_title'] }}" />
    <meta property="og:image" content="{{ @$stream_details['stream_poster'] }}" />
    <meta property="og:description" content="{{ @$stream_details['stream_description'] }}" />
    {{-- Custom Css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/details-screen-styling.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mvp/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mvp/mvp.css') }}" />
    <script src="{{ asset('assets/js/mvp/new.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/vast.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/share_manager.js') }}"></script>
    <script src="{{ asset('assets/js/cache.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/ima.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/playlist_navigation.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/youtubeLoader.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/vimeoLoader.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection
@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/cards-item.css') }}" />
@endsection

@section('content')
    <?php
    $isByPass = 'Y';
    $streamType = $stream_details['stream_type'];
    $streamUrl = $stream_details['stream_promo_url'];
    $mType = '';
    if ($streamUrl) {
        $isShortYouTube = preg_match('/youtu\.be\/([^?&]+)/', $streamUrl, $shortYouTubeMatches);
        $isSingleVideo = preg_match('/[?&]v=([^&]+)/', $streamUrl, $videoMatches);
        $isVimeo = preg_match('/vimeo\.com\/(\d+)/', $streamUrl, $vimeoMatches);
        if ($isShortYouTube) {
            $streamUrl = $shortYouTubeMatches[1]; // Extract only the video ID
            $mType = 'youtube_single';
        } elseif ($isSingleVideo) {
            $streamUrl = $videoMatches[1]; // Extract only the video ID
            $mType = 'youtube_single';
        } elseif ($isVimeo) {
            $streamUrl = $vimeoMatches[1]; // Extract only the Vimeo ID
            $mType = 'vimeo_single';
        }
    }
    $mType = isset($mType) ? $mType : 'video';
    if (strpos($streamUrl, '.m3u8')) {
        $mType = 'hls';
    }
    $sharingURL = url('/') . '/detailscreen/' . $stream_details['stream_guid'];
    
    session()->put('REDIRECT_TO_SCREEN', $sharingURL);
    
    $strQueryParm = "streamGuid={$stream_details['stream_guid']}&userCode=" . session('USER_DETAILS.USER_CODE') . '&frmToken=' . session('SESSION_TOKEN');
    $is_embed = \App\Services\AppConfig::get()->app->is_embed ?? null;
    
    $stream_code = $stream_details['stream_guid'];
    
    $postData = [
        'stream_code' => $stream_code,
    ];
    $ratingsCount = isset($stream_details['ratings']) && is_array($stream_details['ratings']) ? count($stream_details['ratings']) : 0;
    
    $totalRating = 0;
    
    if ($ratingsCount !== 0) {
        foreach ($stream_details['ratings'] as $review) {
            $totalRating += $review['rating'];
        }
        $ratingsCount = $totalRating / $ratingsCount;
        $ratingsCount = number_format($ratingsCount, 1); // Round to 1 decimal place
    }
    ?>
    <style>
        .mobile-dot-sep:before {
            content: '\25CF';
            font-size: 13px;
            color: var(--themePrimaryTxtColor);
            position: relative;
        }

        .responsive_video1 {
            display: flex;
            justify-content: center;
            align-items: center;
            padding-bottom: 0;
            height: 100%;
        }

        {{--  .responsive_video>div {
            height: 126%;
        }  --}} .movies_listview dt {
            width: 70px;
        }

        dl {
            margin-top: 0;
            margin-bottom: 0rem !important;
        }

        dt {
            margin-right: 15px;
        }

        .test-comma {
            color: var(--themePrimaryTxtColor);
        }

        .movie_detail_inner_box.with-logo {
            top: 0px !important;
        }

        .movie_detail_inner_box.without-logo {
            top: 30px !important;
        }

        @media (max-width: 600px) {
            .slick-slide {
                width: 170px !important;
            }

            .thumbnail_img {
                height: 100px !important;
            }

            .thumbnail_img:first-child {
                margin-left: 1px !important;
            }
        }

        @media (max-width: 400px) {
            .thumbnail_img {
                height: 95px !important;
            }
        }

        .videocentalize {
            position: relative;
        }

        .videocentalize {
            max-width: 1000px;
            width: 100%;
            text-align: center;
            margin: 0px auto;
        }

        .mvp-player-controls-main {
            display: none !important;
        }

        .mvp-big-play {
            display: none !important;
        }

        .mvp-solo-seekbar-visible {
            display: none !important;
        }
    </style>

    <!--Start of banner section-->
    <section class="banner detailBanner mt-2">
        <div class="slide">
            <div class="poster_image_box">
                <div class="prs_webseri_video_sec_icon_wrapper " style="display:none;">
                    <ul>
                        <li><a class="test-popup-link button" rel="external" href="#" title="title"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor"
                                    class="bi bi-play" viewBox="0 0 16 16">
                                    <path
                                        d="M10.804 8 5 4.633v6.734L10.804 8zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C4.713 12.69 4 12.345 4 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692z" />
                                </svg> </a>
                        </li>
                    </ul>
                </div>
                <div class="responsive_video1">
                    @if ($streamUrl == '')
                        <img class="slide-img" src="{{ $stream_details['stream_poster'] }}" alt="{{ $stream_details['stream_title'] }}"
                            onerror="this.src='{{ url('/') }}/assets/images/default_img.jpg'">
                    @else
                        <!-- Video Player -->
                        <div class="container-costum">
                            <div id="wrapper">
                            </div>
                            <!-- LIST OF PLAYLISTS -->
                            <div id="mvp-playlist-list">
                                <div class="mvp-global-playlist-data"></div>
                                <div class="playlist-video">
                                    <div class="mvp-playlist-item" data-type="{{ $mType }}"
                                        data-path="{{ $streamUrl }}" data-noapi data-title="" data-description="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>


            </div>
            <div class="movie-detail-box desktop-data">
                <div
                    class="movie_detail_inner_box {{ isset($stream->title_logo, $stream->show_title_logo) && $stream->title_logo && $stream->show_title_logo === 1 ? 'with-logo' : 'without-logo' }}">
                    @if (isset($stream_details['title_logo'], $stream_details['show_title_logo']) &&
                            $stream_details['title_logo'] &&
                            $stream_details['show_title_logo'] == 1)
                        {{--  <div class="title_logo mb-1">
                            <img class="img-fluid" src="{{ $stream_details['title_logo'] }}"
                                alt="{{ $stream_details['stream_title'] ?? 'Logo' }}">
                        </div>  --}}
                        <div class="__logo">
                            <img class="logo_img" src="{{ $stream_details['title_logo'] }}"
                                alt="{{ $stream_details['stream_title'] ?? 'Logo' }}">
                        </div>
                    @else
                        <h1 class="content-heading" title="{{ $stream_details['stream_title'] ?? '' }}">
                            {{ $stream_details['stream_title'] ?? '' }}
                        </h1>
                    @endif
                    <div class="content-timing">
                        @if ($stream_details['released_year'])
                            <a href="{{ route('year', $stream_details['released_year']) }}" class="text-decoration-none">
                                <span class="year">{{ $stream_details['released_year'] }}</span>
                            </a>
                            <span class="dot-sep"></span>
                        @endif
                        @if ($streamType != 'S')
                            @if ($stream_details['stream_duration'] && $stream_details['stream_duration'] !== '0')
                                <span>{{ \App\Helpers\GeneralHelper::showDurationInHourAndMins($stream_details['stream_duration']) }}</span>
                                <span class="dot-sep"></span>
                            @endif
                        @endif
                        @if ($streamType == 'S')
                            @if ($stream_details['show_name'])
                                <a class="text-decoration-none" href="{{ route('series', $stream_details['show_guid']) }}">
                                    <span class="movie_type">{{ $stream_details['show_name'] }}</span>
                                </a>
                            @endif
                            @if ($stream_details['stream_episode_title'])
                                <span
                                    class="movie_type">{{ $stream_details['stream_episode_title'] && $stream_details['stream_episode_title'] !== 'NULL' ? $stream_details['stream_episode_title'] : '' }}</span>
                            @endif
                        @endif
                        @if ($stream_details['genre'])
                            <span class="movie_type">
                                @foreach ($stream_details['genre'] ?? [] as $item)
                                    <a href="{{ route('category', $item['code']) }}?type=genre"
                                        class="px-0">{{ $item['title'] }}</a>{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </span>
                        @endif
                        @if ($stream_details['content_qlt'] != '')
                            <span class="content_screen">
                                @php
                                    $content_qlt_arr = explode(',', $stream_details['content_qlt']);
                                    $content_qlt_codes_arr = explode(',', $stream_details['content_qlt_codes']);
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
                        @if ($stream_details['content_rating'] != '')
                            <span class="content_screen">
                                @php
                                    $content_rating_arr = explode(',', $stream_details['content_rating']);
                                    $content_rating_codes_arr = explode(',', $stream_details['content_rating_codes']);
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
                        @if ($ratingsCount > 0)
                            @if (isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                    $stream_details['rating_type'] === 'stars' &&
                                    $stream_details['video_rating'] == 1)
                                <span class="content_screen themePrimaryTxtColr">
                                    <div class="star active" style="display: inline-flex;">
                                        <svg fill="#ffffff" width="15px" height="15px" viewBox="0 0 32 32" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <title>star</title>
                                                <path
                                                    d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                                </path>
                                            </g>
                                        </svg>
                                    </div>
                                    {{ $ratingsCount ?? 0 }}
                                </span>
                            @elseif(isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                    $stream_details['rating_type'] === 'hearts' &&
                                    $stream_details['video_rating'] == 1)
                                <span class="content_screen themePrimaryTxtColr">
                                    <div class="star active" style="display: inline-flex;">
                                        <svg fill="#ffffff" width="15px" height="15px" viewBox="0 0 32 32"
                                            version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <title>heart</title>
                                                <path
                                                    d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                                </path>
                                            </g>
                                        </svg>
                                    </div>
                                    {{ $ratingsCount ?? 0 }}
                                </span>
                            @elseif(isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                    $stream_details['rating_type'] === 'thumbs' &&
                                    $stream_details['video_rating'] == 1)
                                <span class="content_screen themePrimaryTxtColr">
                                    <div class="star active" style="display: inline-flex; rotate: 180deg">
                                        <svg fill="#6e6e6e" width="15px" height="15px" version="1.1" id="Capa_1"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            viewBox="0 0 208.666 208.666" xml:space="preserve" stroke="#6e6e6e">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g>
                                                    <path
                                                        d="M54.715,24.957c-0.544,0.357-1.162,0.598-1.806,0.696l-28.871,4.403c-2.228,0.341-3.956,2.257-3.956,4.511v79.825 c0,1.204,33.353,20.624,43.171,30.142c12.427,12.053,21.31,34.681,33.983,54.373c4.405,6.845,10.201,9.759,15.584,9.759 c10.103,0,18.831-10.273,14.493-24.104c-4.018-12.804-8.195-24.237-13.934-34.529c-4.672-8.376,1.399-18.7,10.989-18.7h48.991 c18.852,0,18.321-26.312,8.552-34.01c-1.676-1.32-2.182-3.682-1.175-5.563c3.519-6.572,2.86-20.571-6.054-25.363 c-2.15-1.156-3.165-3.74-2.108-5.941c3.784-7.878,3.233-24.126-8.71-27.307c-2.242-0.598-3.699-2.703-3.405-5.006 c0.909-7.13-0.509-20.86-22.856-26.447C133.112,0.573,128.281,0,123.136,0C104.047,0.001,80.683,7.903,54.715,24.957z">
                                                    </path>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    {{ $ratingsCount ?? 0 }}
                                </span>
                            @else
                                {{-- Thumbs  --}}
                                <span class="content_screen themePrimaryTxtColr">
                                    <div class="star active" style="display: inline-flex; rotate: 180deg">
                                        <svg fill="#6e6e6e" width="15px" height="15px" version="1.1" id="Capa_1"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            viewBox="0 0 208.666 208.666" xml:space="preserve" stroke="#6e6e6e">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g>
                                                    <path
                                                        d="M54.715,24.957c-0.544,0.357-1.162,0.598-1.806,0.696l-28.871,4.403c-2.228,0.341-3.956,2.257-3.956,4.511v79.825 c0,1.204,33.353,20.624,43.171,30.142c12.427,12.053,21.31,34.681,33.983,54.373c4.405,6.845,10.201,9.759,15.584,9.759 c10.103,0,18.831-10.273,14.493-24.104c-4.018-12.804-8.195-24.237-13.934-34.529c-4.672-8.376,1.399-18.7,10.989-18.7h48.991 c18.852,0,18.321-26.312,8.552-34.01c-1.676-1.32-2.182-3.682-1.175-5.563c3.519-6.572,2.86-20.571-6.054-25.363 c-2.15-1.156-3.165-3.74-2.108-5.941c3.784-7.878,3.233-24.126-8.71-27.307c-2.242-0.598-3.699-2.703-3.405-5.006 c0.909-7.13-0.509-20.86-22.856-26.447C133.112,0.573,128.281,0,123.136,0C104.047,0.001,80.683,7.903,54.715,24.957z">
                                                    </path>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    {{ $ratingsCount ?? 0 }}
                                </span>
                            @endif
                        @endif
                    </div>

                    <div class="about-movie aboutmovie_gaps">{{ $stream_details['stream_description'] }}</div>
                    <dl class="movies_listview">
                        <dl>
                            @if (isset($stream_details['cast']) || isset($stream_details['director']) || isset($stream_details['writer']))
                                @if ($stream_details['cast'])
                                    <div class="content-person">
                                        <dt>Cast:</dt>
                                        <dd>
                                            {{ $stream_details['cast'] }}
                                        </dd>
                                    </div>
                                @endif
                                @if ($stream_details['director'])
                                    <div class="content-person">
                                        <dt>Director:</dt>
                                        <dd>
                                            {{ $stream_details['director'] }}
                                        </dd>
                                    </div>
                                @endif
                                @if ($stream_details['writer'])
                                    <div class="content-person">
                                        <dt>Writer:</dt>
                                        <dd>
                                            {{ $stream_details['writer'] }}
                                        </dd>
                                    </div>
                                @endif
                            @else
                                @foreach ($stream_details['starring_data'] as $roleKey => $persons)
                                    @if (!empty($persons))
                                        <div class="content-person">
                                            <dt>{{ $roleKey }}:</dt>
                                            <dd>
                                                @php
                                                    if (!is_array($persons)) {
                                                        $persons = explode(',', $persons);
                                                    }
                                                @endphp

                                                @foreach ($persons as $i => $person)
                                                    @if (is_array($person))
                                                        <a class="person-link"
                                                            href="{{ route('person', $person['id']) }}">
                                                            {{ $person['title'] }}{{ !$loop->last ? ', ' : '' }}
                                                        </a>
                                                    @else
                                                        <a class="person-link" href="{{ route('person', $person) }}">
                                                            {{ $person }}{{ !$loop->last ? ', ' : '' }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </dd>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if (!empty($stream_details['advisories']))
                                <div class="content-person">
                                    <dt>Advisory: </dt>
                                    <dd>
                                        @foreach ($stream_details['advisories'] as $i => $val)
                                            <a class="person-link" href="{{ route('advisory', $val['code']) }}">
                                                {{ $val['title'] }}{{ $i < count($stream_details['advisories']) - 1 ? ',' : '' }}
                                            </a>
                                        @endforeach
                                    </dd>
                                </div>
                            @endif

                            @if (!empty($stream_details['languages']))
                                <div class="content-person">
                                    <dt>Language: </dt>
                                    <dd>
                                        @foreach ($stream_details['languages'] as $i => $val)
                                            <a class="person-link" href="{{ route('language', $val['code']) }}">
                                                {{ $val['title'] }}{{ $i < count($stream_details['languages']) - 1 ? ',' : '' }}
                                            </a>
                                        @endforeach
                                    </dd>
                                </div>
                            @endif
                            @if (!empty($stream_details['tags']))
                                <div class="content-person">
                                    <dt>Tags: </dt>
                                    <dd>
                                        @foreach ($stream_details['tags'] as $i => $val)
                                            @if ($i < 15)
                                                <a class="person-link" href="{{ route('tag', $val['code']) }}">
                                                    {{ $val['title'] }}{{ $i < 14 && $i < count($stream_details['tags']) - 1 ? ',' : '' }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </dl>

                    <div class="button_groupbox d-flex align-items-center mb-4">

                        <div class="btn_box movieDetailPlay">
                            @if (isset($stream_details['notify_label']) && $stream_details['notify_label'] == 'available now')
                                <a href="{{ route('playerscreen', $stream_details['stream_guid']) }}"
                                    class="app-primary-btn rounded">
                                    <i class="fa fa-play"></i>
                                    Available Now
                                </a>
                            @elseif (isset($stream_details['notify_label']) && $stream_details['notify_label'] == 'coming soon')
                                @if (session()->has('USER_DETAILS') && session('USER_DETAILS') !== null)
                                    <form id="remind-form-desktop" method="POST" action="{{ route('remind.me') }}">
                                        @csrf
                                        <input type="hidden" name="stream_code" id="stream-code"
                                            value="{{ $stream_details['stream_guid'] }}">
                                        <button class="app-primary-btn rounded" id="remind-button-desktop">
                                            <i id="desktop-remind-icon" class="fas fa-bell"></i>
                                            <span id="desktop-remind-text">Remind me</span>
                                        </button>
                                        <div id="response-message">{{ session('status') }}</div>
                                    </form>
                                @else
                                    <a class="app-primary-btn rounded">
                                        <i class="fa fa-play"></i>
                                        Coming Soon
                                    </a>
                                @endif
                            @else
                                @if (session('USER_DETAILS') &&
                                        session('USER_DETAILS')['USER_CODE'] &&
                                        ($stream_details['monetization_type'] == 'P' ||
                                            $stream_details['monetization_type'] == 'S' ||
                                            $stream_details['monetization_type'] == 'O') &&
                                        $stream_details['is_buyed'] == 'N')
                                    <a href="{{ route('playerscreen', $stream_details['stream_guid']) }}"
                                        class="app-primary-btn rounded">
                                        <i class="fa fa-dollar"></i>
                                        Buy Now
                                    </a>
                                @else
                                    <a href="{{ route('playerscreen', $stream_details['stream_guid']) }}"
                                        class="app-primary-btn rounded">
                                        <i class="fa fa-play"></i>
                                        Play Now
                                    </a>
                                @endif
                            @endif

                        </div>
                        <?php
                    if (session('USER_DETAILS.USER_CODE')) {
                        $signStr = "+";
                        $cls = 'fa fa-plus';
                                $tooltip = "Add to Watchlist";

                            // Check if the stream is already in the wishlist
                            if ($stream_details['stream_is_stream_added_in_wish_list'] == 'Y') {
                                // Update values for removing from wishlist
                                $cls = 'fa fa-minus';
                                $signStr = "-";
                                $tooltip = "Remove from Watchlist";
                            }

                        if ($stream_details['stream_is_stream_added_in_wish_list'] == 'Y') {
                            $cls = 'fa fa-minus';
                            $signStr = "-";
                        }
                    ?>
                        <div class="share_circle addWtchBtn">
                            <a href="javascript:void(0);" onClick="manageFavItem();">
                                <i id="btnicon-fav" class="{{ $cls }} theme-active-color"
                                    data-bs-toggle="tooltip" title="{{ $tooltip }}"></i>
                            </a>
                            <input type="hidden" id="myWishListSign" value="{{ $signStr }}" />
                            <input type="hidden" id="strQueryParm" value="{{ $strQueryParm }}" />
                            <input type="hidden" id="reqUrl" value="{{ route('wishlist.toggle') }}" />
                            @csrf
                        </div>
                        @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'])
                            @if (!empty($stream_details['is_watch_party']) && $stream_details['is_watch_party'] == 1)
                                <div class="share_circle addWtchBtn">
                                    <a href="{{ route('create.watch.party', $stream_details['stream_guid']) }}"
                                        data-bs-toggle="tooltip" title="Create a Watch Party">
                                        <i class="fa fa-users theme-active-color"></i>
                                    </a>
                                </div>
                            @endif
                        @endif
                        <?php
                    }
                    ?>
                        <div class="share_circle addWtchBtn" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                            <a href="javascript:void(0);" role="button" data-bs-toggle="tooltip" title="Share">
                                <i class="fa fa-share theme-active-color"></i>
                            </a>
                        </div>
                        @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'])
                            @if (
                                !empty($stream_details['is_gift']) &&
                                    $stream_details['is_gift'] == 1 &&
                                    ($stream_details['monetization_type'] == 'P' ||
                                        $stream_details['monetization_type'] == 'S' ||
                                        $stream_details['monetization_type'] == 'O'))
                                <div class="share_circle addWtchBtn" data-bs-toggle="modal" data-bs-target="#giftModal">
                                    <a href="javascript:void(0);"><i class="fa-solid fa-gift theme-active-color"></i></a>
                                </div>
                            @endif
                        @endif
                        @if (isset(\App\Services\AppConfig::get()->app->badge_status) && \App\Services\AppConfig::get()->app->badge_status === 1)
                            @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'])
                                @if (isset($stream_details['gamified_content']) && $stream_details['gamified_content'] == 1)
                                    <div class="share_circle addWtchBtn">
                                        <a href="{{ route('user.badge') }}" data-bs-toggle="tooltip"
                                            title="Gamified Content">
                                            <i class="fa-solid fa-award theme-active-color"></i>
                                        </a>
                                    </div>
                                @endif
                            @endif
                        @endif

                        @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'])
                            @if (isset($stream_details['tip_jar']) && $stream_details['tip_jar'] == 1)
                                <div class="share_circle addWtchBtn">
                                    <form id="tipjarForm" action="{{ route('tipjar.view') }}" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{ $stream_details['stream_guid'] }}"
                                            name="streamcode" />
                                        <input type="hidden" value="{{ $stream_details['stream_poster'] }}"
                                            name="streamposter" />
                                    </form>
                                    <a href="javascript:void(0);" data-bs-toggle="tooltip" title="Tip Jar"
                                        onclick="document.getElementById('tipjarForm').submit();">
                                        <i class="fa-solid fa-hand-holding-dollar theme-active-color"></i>
                                    </a>
                                </div>
                            @endif
                        @endif
                        @if (session('USER_DETAILS') &&
                                session('USER_DETAILS')['USER_CODE'] &&
                                isset(\App\Services\AppConfig::get()->app->frnd_option_status) &&
                                \App\Services\AppConfig::get()->app->frnd_option_status === 1)
                            <div class="share_circle addWtchBtn" data-bs-toggle="modal" data-bs-target="#recommendation">
                                <a href="javascript:void(0);" role="button" data-bs-toggle="tooltip"
                                    title="Recommendations">
                                    <i class="fa-solid fa-film theme-active-color"></i>
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="desktop-tabs">
        @include('detailscreen.partials.tabs-desktop')
    </div>
    <div class="mobile-tabs">
        @include('detailscreen.partials.tabs-mobile')
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered sharing-madal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Share</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="share_list d-flex justify-content-between">
                        @if ((isset($stream_details['is_embed']) && $stream_details['is_embed'] == 1) || $is_embed == 1)
                            <li data-bs-toggle="modal" data-bs-target="#exampleModalCenter2">
                                <a data-toggle="tooltip" data-placement="top" title="embed" href="javascript:void(0)">
                                    <i class="fa-solid fa-code fa-xs"></i>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a data-toggle="tooltip" data-placement="top" title="facebook"
                                href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $sharingURL; ?>" target="_blank">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tooltip" data-placement="top" title="whatsapp"
                                href="https://wa.me/?text=<?php echo $sharingURL; ?>" target="_blank">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tooltip" data-placement="top" title="twitter"
                                href="https://twitter.com/intent/tweet?text=<?php echo $sharingURL; ?>" target="_blank">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tooltip" data-placement="top" title="telegram"
                                href="https://t.me/share/url?url=<?php echo $sharingURL; ?>&text=<?php echo $stream_details['stream_title']; ?>"
                                target="_blank">
                                <i class="fa-brands fa-telegram"></i>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tooltip" data-placement="top" title="linkedin"
                                href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $sharingURL; ?>"
                                target="_blank">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                        </li>
                    </ul>

                    <form class="form-inline d-flex mt-3">
                        <input type="text" class="share_formbox" id="sharingURL" value="<?php echo $sharingURL; ?>"
                            readonly>
                        <input type="button" class="submit_btn share_btnbox" value="Copy">
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- stream embed Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenter2Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Embed stream "{{ $stream_details['stream_title'] }}"
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="border pt-4 p-3 rounded-2 position-relative">
                        <!-- Copy Button -->
                        <button onclick="copyText(this)" id="copy-btn"
                            class="btn btn-sm btn-outline-secondary rounded-3" type="button" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Copy to Clipboard"
                            style="position: absolute; top: 10px; right: 10px; padding: 5px 10px;">
                            Copy
                        </button>

                        <!-- Code block to display and copy -->
                        <code id="copy-code"></code>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var videoSrc = '{{ $stream_details['stream_url'] }}';
        var copyCodeElement = document.getElementById("copy-code");

        function getMediaType(url) {
            const cleanUrl = url.split('?')[0];
            const extension = cleanUrl.split('.').pop().toLowerCase();
            return extension;
        }

        const mediaType = getMediaType(videoSrc);

        let embedCode = "";

        if (mediaType === 'm3u8') {
            embedCode = `&lt;script src="https://cdn.jsdelivr.net/npm/hls.js@1"&gt;&lt;/script&gt;
                        &lt;video id="video" controls width="720" height="420"&gt;&lt;/video&gt;
                        &lt;script&gt;
                        var video = document.getElementById('video');
                        if (Hls.isSupported()) {
                            var hls = new Hls();
                            hls.loadSource('${videoSrc}');
                            hls.attachMedia(video);
                        }
                        &lt;/script&gt;`;
        } else if (mediaType === 'mp3') {
            embedCode = `&lt;audio controls&gt;
                            &lt;source src="${videoSrc}" type="audio/mpeg"&gt;
                            Your browser does not support the audio element.
                            &lt;/audio&gt;`;
        } else if (mediaType === 'mp4') {
            embedCode = `&lt;video id="video" controls width="720" height="420"&gt;
                            &lt;source src="${videoSrc}" type="video/mp4"&gt;
                            Your browser does not support the video element.
                            &lt;/video&gt;`;
        } else {
            embedCode = "Unsupported media format.";
        }

        copyCodeElement.innerHTML = embedCode.replace(/</g, "&lt;").replace(/>/g, "&gt;");

        document.getElementById("copy-btn").onclick = function() {
            navigator.clipboard.writeText(copyCodeElement.textContent);
            this.textContent = "Copied!";
            this.classList.remove("btn-outline-secondary");
            this.classList.add("btn-success");

            setTimeout(() => {
                this.textContent = "Copy";
                this.classList.remove("btn-success");
                this.classList.add("btn-outline-secondary");
            }, 2000);
        };
    </script>
    <!--End of banner section-->

    {{-- Gift Modal  --}}
    <div class="modal fade" id="giftModal" tabindex="-1" role="dialog" aria-labelledby="giftModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send as a Gift</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        $suffix = '';
                        if ((int) $stream_details['planFaq'] > 1) {
                            $suffix = 's';
                        }
                        $sArr['MONETIZATION_GUID'] = $stream_details['stream_guid'];
                        $sArr['MONETIZATION_TYPE'] = $stream_details['monetization_type'];
                        $sArr['SUBS_TYPE'] = $stream_details['monetization_type'];
                        $sArr['PAYMENT_INFORMATION'] = $stream_details['stream_title'];
                        $sArr['STREAM_DESC'] = $stream_details['stream_description'];
                        $sArr['PLAN'] = $stream_details['planFaq'] . ' ' . $stream_details['plan_period'] . $suffix;
                        $sArr['AMOUNT'] = $stream_details['amount'];
                        $sArr['POSTER'] = $stream_details['stream_poster'];
                        session(['MONETIZATION' => $sArr]);
                        session()->save();
                        if ($stream_details['monetization_type'] == 'S') {
                            $actionRoute = route('subscription');
                        } else {
                            $actionRoute = route('monetization');
                        }
                    @endphp
                    <form action="{{ $actionRoute }}" method="get">
                        @csrf
                        <div class="form-group">
                            <label for="recipient_email" class="btn text-black">Recipients Email:</label>

                            <input type="email" class="form-control text-black" id="recipient_email"
                                name="recipient_email">
                            @error('recipient_email')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="app-primary-btn rounded my-2">Send Gift</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Recommendation Modal --}}
    <div class="modal fade" id="recommendation" tabindex="-1" aria-labelledby="recommendationLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add to Friends Recommendation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="recommendationForm">
                        @csrf
                        @if (isset($fav_freinds) && !empty($fav_freinds))
                            <div class="col-lg-12">
                                <input type="hidden" name="stream_code" value="{{ $stream_details['stream_guid'] }}">
                                <input type="hidden" name="type" value="M">
                                <label for="text" class="form-label">Select Favorite Friends:</label>
                                <select name="fav_friends[]" id="fav_friends" class="select2-multiple"
                                    multiple="multiple">
                                    <option disabled>{{ __('Select') }}</option>
                                    @foreach ($fav_freinds as $friend)
                                        <option value="{{ $friend['code'] }}">{{ $friend['name'] }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger d-none" id="fav_friends_error"></span>
                            </div>
                            <button type="submit" id="submitRecommendation" class="app-primary-btn rounded my-2">
                                <span class="button-text">Send</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        @else
                            <h6 class="title">No Favorite Friend Found!</h6>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        var themeActiveColor = "{{ \App\Services\AppConfig::get()->app->website_colors->themeActiveColor }}";

        function handleStarRating(element) {
            let rating = element.dataset.rating;
            let starsWrapper = document.getElementsByClassName("user-rating")[0];
            let stars = starsWrapper.getElementsByClassName("star");
            let ratingField = document.getElementsByName("rating")[0];

            for (let i = 0; i < stars.length; i++) {
                if (stars[i].classList.contains("active"))
                    stars[i].classList.remove("active")
            }

            for (let i = 0; i < rating; i++) {
                if (!stars[i].classList.contains("active"))
                    stars[i].classList.add("active")
            }

            ratingField.value = parseInt(rating);
        }

        function handleHeartRating(element) {
            var heart = element.getAttribute('data-rating');
            var newRating = heart == 1 ? 0 : 1;

            if (newRating == 1) {
                element.setAttribute('data-rating', 1);
                element.querySelector('svg').style.fill = themeActiveColor; // Change to hearted color
            } else {
                element.setAttribute('data-rating', 0);
                element.querySelector('svg').style.fill = '#ffffff'; // Change to unhearted color
            }
            document.getElementById('hiddenRating').value = newRating;

        }

        function handleRating(element, type) {
            var likeButton = document.querySelector('.like');
            var dislikeButton = document.querySelector('.dislike');
            var hiddenRating = document.getElementById('hiddenRating');
            var isLike = type === 'like';

            if (isLike) {
                likeButton.querySelector('svg').style.fill = themeActiveColor; // Change to liked color
                dislikeButton.querySelector('svg').style.fill = '#6e6e6e'; // Reset dislike button color
                hiddenRating.value = 5; // Set hidden input value to 1 for like
            } else {
                dislikeButton.querySelector('svg').style.fill = themeActiveColor; // Change to disliked color
                likeButton.querySelector('svg').style.fill = '#6e6e6e'; // Reset like button color
                hiddenRating.value = 1; // Set hidden input value to 0 for dislike
            }
        }


        function submitOnce() {
            document.getElementById('submitButton').disabled = true;
            return true;
        }
    </script>
    <script>
        var themeActiveColor = "{{ \App\Services\AppConfig::get()->app->website_colors->themeActiveColor }}";

        function handleStarRatingMobile(element) {
            // Get the rating from the data attribute
            let rating = element.dataset.ratingMobile;

            // Get the wrapper containing all stars
            let starsWrapper = document.getElementsByClassName("user-rating-mobile")[0];

            // Get all star elements
            let stars = starsWrapper.getElementsByClassName("star-mobile");

            // Get the hidden input field to store the rating value
            let ratingField = document.getElementsByName("rating_mobile")[0];

            // Remove the 'active' class from all stars
            for (let i = 0; i < stars.length; i++) {
                stars[i].classList.remove("active");
                // Reset the star fill color
                stars[i].querySelector('svg').style.fill = "#ffffff"; // Reset to original color
            }

            // Add the 'active' class to the stars up to the selected rating
            for (let i = 0; i < rating; i++) {
                stars[i].classList.add("active");
                // Change the star fill color to the active theme color
                stars[i].querySelector('svg').style.fill = themeActiveColor;
            }

            // Set the hidden input field value to the selected rating
            ratingField.value = parseInt(rating);
        }

        function handleHeartRatingMobile(element) {
            var heart = element.getAttribute('data-rating-mobile');
            var newRating = heart == 1 ? 0 : 1;

            if (newRating == 1) {
                element.setAttribute('data-rating-mobile', 1);
                element.querySelector('svg').style.fill = themeActiveColor; // Change to hearted color
            } else {
                element.setAttribute('data-rating', 0);
                element.querySelector('svg').style.fill = '#ffffff'; // Change to unhearted color
            }
            document.getElementById('hiddenRatingMobile').value = newRating;

        }

        function handleRatingMolbile(element, type) {
            var likeButton = document.querySelector('.like-mobile');
            var dislikeButton = document.querySelector('.dislike-mobile');
            var hiddenRatingMobile = document.getElementById('hiddenRatingMobile');
            var isLike = type === 'like';

            if (isLike) {
                likeButton.querySelector('svg').style.fill = themeActiveColor; // Change to liked color
                dislikeButton.querySelector('svg').style.fill = '#6e6e6e'; // Reset dislike button color
                hiddenRatingMobile.value = 5; // Set hidden input value to 1 for like
            } else {
                dislikeButton.querySelector('svg').style.fill = themeActiveColor; // Change to disliked color
                likeButton.querySelector('svg').style.fill = '#6e6e6e'; // Reset like button color
                hiddenRatingMobile.value = 1; // Set hidden input value to 0 for dislike
            }
        }


        function submitOnceMobile() {
            document.getElementById('submitButton').disabled = true;
            return true;
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(document).on('submit', '#reviewForm', function(e) {
            e.preventDefault(); // Prevent form submission

            const form = $(this);
            const formData = form.serialize();
            const submitButton = form.find('button[type="submit"]');
            const buttonText = submitButton.find('.button-text');
            const spinner = submitButton.find('.spinner-border');

            // Disable the button and show spinner
            submitButton.prop('disabled', true);
            // buttonText.hide();
            spinner.show();

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    // Clear any existing messages
                    $('#desktopMessageContainer').html('').hide();
                },
                success: function(response) {
                    $('#desktopMessageContainer').html('').fadeOut();
                    $('#mobileMessageContainer').html('').fadeOut();
                    if (response.success) {
                        $('.member-reviews').html(response.newReviewHtml);

                        if (response.totalReviews > 0) {
                            $('.no-reviews-message').hide();
                        } else {
                            $('.no-reviews-message').show();
                        }
                        if (response.ratingsCount !== undefined) {
                            $('.section-title .ratings-count').text(`(${response.ratingsCount})`);
                            console.log(response);
                        }
                        console.log(response);

                        // Update average rating
                        if (response.averageRating !== undefined) {
                            $('.section-title .average-rating').text(`${response.averageRating}`);
                        }
                        if (response.ratingIconHtml !== undefined) {
                            $('#rating-icon').html(response.ratingIconHtml);
                        }
                        if (response.ratingIconHtml !== undefined) {
                            $('#rating-icon-mobile').html(response.ratingIconHtml);
                        }
                        if (response.totalReviews > 0) {
                            $('.no-reviews-message-mobile').hide();
                        } else {
                            $('.no-reviews-message-mobile').show();
                        }
                        form[0].reset();
                        $('#desktopMessageContainer').html(
                                `<div style="color: var(--themeActiveColor);">Review added.</div>`)
                            .fadeIn();
                        setTimeout(function() {
                            $('#desktopMessageContainer').fadeOut();
                        }, 3000);
                        $('#mobileMessageContainer').html(
                                `<div style="color: var(--themeActiveColor);">Review added.</div>`)
                            .fadeIn();
                        setTimeout(function() {
                            $('#mobileMessageContainer').fadeOut();
                        }, 3000);

                    }
                },
                error: function(xhr) {
                    $('#desktopMessageContainer').html('').fadeOut();
                    $('#mobileMessageContainer').html('').fadeOut();
                    console.error(xhr.responseJSON.message);
                    const errorMessage = xhr.responseJSON.message ||
                        'An error occurred. Please try again later.';
                    // Display the error message
                    $('#desktopMessageContainer').html(
                        `<div style="color: var(--themeActiveColor); display:block;">${errorMessage}</div>`
                    ).fadeIn();
                    setTimeout(function() {
                        $('#desktopMessageContainer').fadeOut();
                    }, 3000);
                    $('#mobileMessageContainer').html(
                        `<div style="color: var(--themeActiveColor); display:block;">${errorMessage}</div>`
                    ).fadeIn();
                    setTimeout(function() {
                        $('#mobileMessageContainer').fadeOut();
                    }, 3000);

                },
                complete: function() {
                    // Re-enable the button and hide spinner
                    submitButton.prop('disabled', false);
                    buttonText.show();
                    spinner.hide();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Function to initialize Slick slider only when needed
            function initializeSlider() {
                const sliderElement = $('.landscape_slider:not(.slick-initialized)');
                if (sliderElement.length) {
                    sliderElement.slick({
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true,
                        arrows: true,
                        responsive: [{
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 3,
                                }
                            },
                            {
                                breakpoint: 480,
                                settings: {
                                    slidesToShow: 3,
                                }
                            }
                        ]
                    });
                }
            }

            // Initialize slider for the first tab by default
            initializeSlider();
            const tabs = document.querySelectorAll('.sec-device .tab');
            const contents = document.querySelectorAll('.tab-content .content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs and hide all content
                    tabs.forEach(t => t.classList.remove('active'));
                    contents.forEach(c => c.classList.add('d-none'));

                    // Add active class to the clicked tab and show the corresponding content
                    this.classList.add('active');
                    const activeContent = this.closest('.my-tabs').querySelector(
                        `[data-tab-content=${this.getAttribute('data-tab')}]`);
                    if (activeContent) {
                        activeContent.classList.remove('d-none');

                        // If the active content contains the slider, initialize or update it
                        if (activeContent.querySelector('.landscape_slider')) {
                            initializeSlider();
                            $('.landscape_slider').slick('setPosition');
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Fetch stream codes from the hidden inputs
            const desktopStreamCode = $('#stream-code').val();
            const mobileStreamCode = $('#mobile-stream-code').val();

            if (desktopStreamCode || mobileStreamCode) {
                // Function to toggle bell icon based on subscription status
                function updateBellIcon(streamCode, iconId, textId) {
                    if (!streamCode) return; // Prevent unnecessary AJAX calls

                    $.ajax({
                        url: "{{ route('check.remind.me') }}",
                        method: "GET",
                        data: {
                            stream_code: streamCode
                        },
                        success: function(response) {
                            if (response.reminded) {
                                $(`#${iconId}`).removeClass('fa-bell').addClass('fa-check-circle');
                                $(`#${textId}`).text('Reminder set');
                            } else {
                                $(`#${iconId}`).removeClass('fa-check-circle').addClass('fa-bell');
                                $(`#${textId}`).text('Remind me');
                            }
                        },
                        error: function(xhr) {
                            console.error('Error checking subscription status:', xhr.responseText);
                        }
                    });
                }

                // Initial icon status check
                updateBellIcon(desktopStreamCode, 'desktop-remind-icon', 'desktop-remind-text');
                updateBellIcon(mobileStreamCode, 'mobile-remind-icon', 'mobile-remind-text');
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function detectMob() {
                const toMatch = [
                    /Android/i,
                    /webOS/i,
                    /iPhone/i,
                    /iPad/i,
                    /iPod/i,
                    /BlackBerry/i,
                    /Windows Phone/i
                ];
                return toMatch.some((toMatchItem) => navigator.userAgent.match(toMatchItem));
            }

            var pListPostion = detectMob() ? 'hb' : 'vrb';

            var settings = {
                skin: 'sirius', // Choose an appropriate skin
                playlistPosition: pListPostion,
                sourcePath: "",
                useMobileChapterMenu: true,
                vimeoPlayerType: "chromeless",
                youtubePlayerType: "chromeless",
                activeItem: 0,
                activePlaylist: ".playlist-video",
                playlistList: "#mvp-playlist-list",
                instanceName: "player1",
                hidePlaylistOnMinimize: true,
                volume: 0.75,
                createAdMarkers: false,
                autoPlay: true, // Ensure autoplay
                loopingOn: true, // Enable looping
                mediaEndAction: 'loop',
                crossorigin: "link",
                playlistOpened: false,
                randomPlay: false,
                useEmbed: false,
                useTime: false,
                usePip: false,
                useCc: false,
                useAirPlay: false,
                usePlaybackRate: false,
                useNext: false,
                usePrevious: false,
                useRewind: false,
                useSkipBackward: false,
                useSkipForward: false,
                showPrevNextVideoThumb: false,
                rememberPlaybackPosition: false,
                useQuality: false,
                useTheaterMode: false,
                useSubtitle: false,
                useTranscript: false,
                useChapterToggle: false,
                useCasting: false,
                useAdSeekbar: false,
                disableSeekbar: false,
            };

            // Initialize player
            if (!window.player) {
                window.player = new mvp(document.getElementById('wrapper'), settings);
                  setTimeout(unmutedVoice, 500);
            }

            // Trailer button logic
            window.addEventListener('load', () => {
                var trailerButton = document.getElementById('trailer-id');
                if (trailerButton) {
                    trailerButton.addEventListener('click', function() {
                        console.log("Player load started.");
                        console.log(player);
                        player.seek(0); // Reset video to start
                        player.playMedia();
                    });
                }
            });
             function unmutedVoice() {
            //alert("hi");
            player.toggleMute();
            player.playMedia();
        }

        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Initialize Select2
        $('.select2-multiple').select2({
            placeholder: "Select favorite friends",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#recommendation')
        });
    </script>
    <script>
        $(document).on('submit', '#recommendationForm', function(e) {
            e.preventDefault();

            let form = $(this);
            let button = $('#submitRecommendation');
            let buttonText = button.find('.button-text');
            let spinner = button.find('.spinner-border');

            // Show spinner and disable button
            button.prop('disabled', true);
            spinner.removeClass('d-none');
            buttonText.text('Sending...');

            $.ajax({
                url: "{{ route('recommendation.store') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form.serialize(),
                success: function(response) {
                    console.log(response);
                    if (response.status) {
                        Swal.fire({
                            icon: "success",
                            title: response.message,
                        }).then(() => {
                            // Hide the modal after Swal confirmation
                            $('#recommendation').modal('hide');
                            form[0].reset(); // Reset form
                        });
                    } else {
                        Swal.fire({
                            icon: "warning",
                            title: response.message,
                        }).then(() => {
                            // Hide the modal after Swal confirmation
                            $('#recommendation').modal('hide');
                            form[0].reset(); // Reset form
                        });
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    if (errors && errors.fav_friends) {
                        $('#fav_friends_error').text(errors.fav_friends[0]).removeClass('d-none');
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Something went wrong! Please try again.",
                        });
                    }
                },
                complete: function() {
                    // Hide spinner, enable button, restore text
                    spinner.addClass('d-none');
                    button.prop('disabled', false);
                    buttonText.text('Send');
                }
            });
        });
    </script>
    <script>
        console.log('Like-tab-slider script loaded at', new Date().toISOString());

        // Function to initialize Slick sliders
        function initializeSlider(container, isMobile = false) {
            console.log('initializeSlider called for container:', container, 'isMobile:', isMobile);
            const sliderElements = jQuery(container).find(
                '.slick-slider:not(.slick-initialized), .landscape_slider:not(.slick-initialized)');
            if (sliderElements.length && typeof jQuery !== 'undefined' && jQuery.fn.slick) {
                sliderElements.each(function() {
                    const $slider = jQuery(this);
                    const itemsPerRow = 5;
                    const autoplay = $slider.data('autoplay') === false;

                    console.log('Initializing Slick Slider for:', $slider[0], 'itemsPerRow:', itemsPerRow);

                   $slider.slick({
                        dots: true,
                        infinite: true,
                        loop: true,
                        autoplay: autoplay ||
                            false, // Use the autoplay data attribute or default to false
                        autoplaySpeed: 3000,
                        slidesToShow: itemsPerRow,
                        slidesToScroll: 1,
                        swipeToSlide: true,
                        responsive: [{
                                breakpoint: 1740,
                                settings: (itemsPerRow == 2) ? {
                                    slidesToShow: 2,
                                    slidesToScroll: 1,
                                    swipeToSlide: true,
                                    arrows: true
                                } : {
                                    slidesToShow: Math.max(itemsPerRow - 1, 1),
                                    slidesToScroll: 1,
                                    swipeToSlide: true,
                                    dots: true,
                                    arrows: true
                                }
                            },
                            {
                                breakpoint: 1200,
                                settings: (itemsPerRow == 2) ? {
                                    slidesToShow: 2,
                                    slidesToScroll: 1,
                                    swipeToSlide: true,
                                    arrows: false
                                } : {
                                    slidesToShow: Math.max(itemsPerRow - 1, 1),
                                    slidesToScroll: 1,
                                    swipeToSlide: true,
                                    dots: true,
                                    arrows: false
                                }
                            },
                            {
                                // Condition: If itemsPerRow is 2, always keep it at 2
                                breakpoint: 770,
                                settings: (itemsPerRow == 2) ? {
                                    slidesToShow: 2,
                                    slidesToScroll: 1,
                                    swipeToSlide: true,
                                    arrows: false
                                } : {
                                    slidesToShow: Math.max(itemsPerRow - 1, 1),
                                    slidesToScroll: 1,
                                    swipeToSlide: true,
                                    dots: true,
                                    arrows: false
                                }
                            },
                            {
                                breakpoint: 600,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 1,
                                    swipeToSlide: true,
                                    arrows: false
                                }
                            },
                            {
                                breakpoint: 480,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 1,
                                    swipeToSlide: true,
                                    dots: false,
                                    arrows: false
                                }
                            }
                        ]
                    });
                });
            } else if (!sliderElements.length) {
                console.log('No uninitialized sliders found in:', container);
                console.log('Container HTML:', container.innerHTML.substring(0, 200) + '...');
            } else {
                console.error('Slick Slider or jQuery not loaded for:', sliderElements);
            }
        }

        // Function to force DOM reflow
        function forceReflow(element) {
            element.offsetHeight;
        }

        // Function to load related streams for both containers
        function loadRelatedStreams(desktopContainer, mobileContainer) {
            console.log('loadRelatedStreams called for containers:', {
                desktop: desktopContainer,
                mobile: mobileContainer
            });
            const streamGuid = desktopContainer.dataset.streamGuid || mobileContainer.dataset.streamGuid;
            if (!streamGuid) {
                console.error('No stream GUID found for related streams');
                desktopContainer.style.display = 'none';
                mobileContainer.style.display = 'none';
                return;
            }
            console.log('Stream GUID:', streamGuid);

            const desktopSkeleton = desktopContainer.querySelector('.skeleton-loader');
            const mobileSkeleton = mobileContainer.querySelector('.skeleton-loader');
            console.log('Skeleton loaders found:', {
                desktop: !!desktopSkeleton,
                mobile: !!mobileSkeleton
            });

            const contentDiv = document.getElementById('like');
            console.log('Content div found:', !!contentDiv);

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            console.log('CSRF token found:', !!csrfToken);

            if (!csrfToken) {
                console.error('CSRF token missing, cannot make AJAX request');
                desktopContainer.innerHTML = '<p>Error: CSRF token missing</p>';
                mobileContainer.innerHTML = '<p>Error: CSRF token missing</p>';
                desktopContainer.style.display = 'block';
                mobileContainer.style.display = 'block';
                return;
            }

            console.log('Initiating fetch to /streams/related for stream:', streamGuid);
            fetch('{{ url('/streams/related') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        stream_guid: streamGuid
                    })
                })
                .then(response => {
                    console.log(`Response status for /streams/related: ${response.status}`);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}, statusText: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(`Related streams fetched for stream: ${streamGuid}`, data);
                    if (!data.success || !data.data.streams || data.data.streams.length === 0) {
                        console.log(`No related streams for stream: ${streamGuid}, hiding containers`);
                        desktopContainer.style.display = 'none';
                        mobileContainer.style.display = 'none';
                        return;
                    }

                    console.log('Initiating fetch to /render-you-might-like');
                    return fetch('{{ url('/render-you-might-like') }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            streams: data.data.streams
                        })
                    });
                })
                .then(response => {
                    console.log(`Response status for /render-you-might-like: ${response.status}`);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}, statusText: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(renderData => {
                    console.log(`You-might-like rendered for stream: ${streamGuid}`, renderData);
                    if (renderData.success && renderData.html) {
                        requestAnimationFrame(() => {
                            // Show content div
                            if (contentDiv) {
                                console.log('Showing content div');
                                contentDiv.classList.remove('d-none');
                            }

                            // Update desktop container
                            if (desktopSkeleton) {
                                console.log('Hiding desktop skeleton loader');
                                desktopSkeleton.style.display = 'none';
                            }
                            console.log('Updating desktop container with new HTML');
                            desktopContainer.innerHTML = renderData.html;
                            forceReflow(desktopContainer);
                            initializeSlider(desktopContainer, false);

                            // Update mobile container
                            if (mobileSkeleton) {
                                console.log('Hiding mobile skeleton loader');
                                mobileSkeleton.style.display = 'none';
                            }
                            console.log('Updating mobile container with new HTML');
                            mobileContainer.innerHTML = renderData.html;
                            forceReflow(mobileContainer);
                            initializeSlider(mobileContainer, true);

                            console.log(`UI updated for related streams: ${streamGuid}`);
                        });
                    } else {
                        console.log(`Render failed for stream: ${streamGuid}, hiding containers`);
                        desktopContainer.style.display = 'none';
                        mobileContainer.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error(`Error processing streams for stream: ${streamGuid}:`, error);
                    desktopContainer.innerHTML = '<p class="text-white no-reviews-message m-3 mt-2">Content Not Avaiable yet</p>';
                    mobileContainer.innerHTML = '<p class="text-white no-reviews-message m-3 mt-2">Content Not Avaiable yet</p>';
                    desktopContainer.style.display = 'block';
                    mobileContainer.style.display = 'block';
                    if (contentDiv) {
                        contentDiv.classList.remove('d-none');
                    }
                });
        }
        // Load related streams after page is fully loaded
        window.onload = () => {
            console.log('window.onload fired at', new Date().toISOString());
            const desktopContainer = document.querySelector('.like-tab-slider-container');
            const mobileContainer = document.querySelector('.like-tab-slider-mobile-container');
            if (desktopContainer && mobileContainer) {
                console.log('Container found:', mobileContainer);
                loadRelatedStreams(desktopContainer, mobileContainer);
            } else {
                console.error('Related streams container not found');
            }
        };
    </script>
@endpush
