@extends('layouts.app')

@section('meta-tags')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content='article' />
    <meta property="og:url" content="{{ url('/detailscreen/' . $series_details['stream_guid']) }}" />
    <meta name="twitter:title" content="{{ @$series_details['stream_title'] }}">
    <meta name="twitter:description" content="{{ @$series_details['stream_description'] }}">
    <meta property="og:title" content="{{ @$series_details['stream_title'] }}" />
    <meta property="og:image" content="{{ @$series_details['stream_poster'] }}" />
    <meta property="og:description" content="{{ @$series_details['stream_description'] }}" />
    {{-- Custom Css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/details-screen-styling.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <?php
    $isByPass = 'Y';
    $streamType = $series_details['stream_type'];

    $sharingURL = url('/') . '/series/' . $series_details['stream_guid'];

    session()->put('REDIRECT_TO_SCREEN', $sharingURL);

    $strQueryParm = "streamGuid={$series_details['stream_guid']}&userCode=" . session('USER_DETAILS.USER_CODE') . '&frmToken=' . session('SESSION_TOKEN');
    $is_embed = \App\Services\AppConfig::get()->app->is_embed ?? null;

    $stream_code = $series_details['stream_guid'];

    $postData = [
        'stream_code' => $stream_code,
    ];
    $ratingsCount = isset($series_details['ratings']) && is_array($series_details['ratings']) ? count($series_details['ratings']) : 0;

    $totalRating = 0;

    if ($ratingsCount !== 0) {
        foreach ($series_details['ratings'] as $review) {
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

        .responsive_video {
            display: flex;
            justify-content: center;
            align-items: center;
            padding-bottom: 0;
            height: 100%;
        }

        .responsive_video>div {
            height: 126%;
        }

        .movies_listview dt {
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

        .content_screen {
            border: 1px var(--themePrimaryTxtColor) solid !important;
        }

        /* Force content-timing to use flexbox for proper wrapping */
        .content-timing {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center;
            gap: 4px;
        }

        /* Safari: Force text to wrap to next line instead of showing ellipsis */
        @supports (-webkit-appearance: none) {
            .content-timing {
                overflow: visible !important;
                text-overflow: clip !important;
                display: flex !important;
                flex-wrap: wrap !important;
                -webkit-line-clamp: unset !important;
                -webkit-box-orient: unset !important;
                gap: 3px !important;
            }
            
            .content-timing .content_screen,
            .content_screen {
                white-space: normal !important;
                word-break: break-word;
                overflow: visible !important;
                text-overflow: clip !important;
                word-wrap: break-word;
                /* Prevent text cutting at bottom in Safari */
                line-height: 1.5 !important;
                padding-top: 4px !important;
                padding-bottom: 4px !important;
                min-height: auto !important;
                /* Add spacing between elements */
                margin-left: 3px !important;
                /* Ensure border is visible */
                border: 1px var(--themePrimaryTxtColor) solid !important;
                border-style: solid !important;
            }
            
            .content-timing .content_screen:first-child,
            .content-timing .content_screen:first-of-type,
            .content_screen:first-child {
                margin-left: 0 !important;
            }
        }

        /* Safari-specific: Force wrapping on next line */
        @media screen and (-webkit-min-device-pixel-ratio: 0) {
            .content-timing {
                overflow: visible !important;
                text-overflow: clip !important;
                display: flex !important;
                flex-wrap: wrap !important;
                -webkit-line-clamp: unset !important;
                -webkit-box-orient: unset !important;
                gap: 3px !important;
            }
            
            .content-timing .content_screen,
            .content_screen {
                white-space: normal !important;
                word-wrap: break-word;
                overflow: visible !important;
                text-overflow: clip !important;
                /* Prevent text cutting at bottom in Safari */
                line-height: 1.5 !important;
                padding-top: 4px !important;
                padding-bottom: 4px !important;
                min-height: auto !important;
                /* Add spacing between elements */
                margin-left: 3px !important;
                /* Ensure border is visible */
                border: 1px var(--themePrimaryTxtColor) solid !important;
                border-style: solid !important;
            }
            
            .content-timing .content_screen:first-child,
            .content-timing .content_screen:first-of-type,
            .content_screen:first-child {
                margin-left: 0 !important;
            }
        }

        /* On small screens, force views to wrap */
        @media (max-width: 768px) {
            .content-timing .content_screen {
                white-space: normal !important;
            }
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
                <div class="responsive_video">
                    <img src="{{ $series_details['stream_poster'] }}" alt="{{ $series_details['stream_title'] }}"
                        onerror="this.src='{{ url('/') }}/assets/images/default_img.jpg'">
                </div>
            </div>
            <div class="movie-detail-box desktop-data">
                <div
                    class="movie_detail_inner_box {{ isset($stream->title_logo, $stream->show_title_logo) && $stream->title_logo && $stream->show_title_logo === 1 ? 'with-logo' : 'without-logo' }}">
                    @if (isset($series_details['title_logo'], $series_details['show_title_logo']) &&
                            $series_details['title_logo'] &&
                            $series_details['show_title_logo'] == 1)
                        {{--  <div class="title_logo mb-1">
                            <img class="img-fluid" src="{{ $series_details['title_logo'] }}"
                                alt="{{ $series_details['stream_title'] ?? 'Logo' }}">
                        </div>  --}}
                        <div class="__logo">
                            <img class="logo_img" src="{{ $series_details['title_logo'] }}"
                                alt="{{ $series_details['stream_title'] ?? 'Logo' }}">
                        </div>
                    @else
                        <h1 class="content-heading" title="{{ $series_details['stream_title'] ?? '' }}">
                            {{ $series_details['stream_title'] ?? '' }}
                        </h1>
                    @endif
                    <div class="content-timing">
                        @if ($series_details['released_year'])
                            <a href="{{ route('year', $series_details['released_year']) }}" class="text-decoration-none">
                                <span class="year">{{ $series_details['released_year'] }}</span>
                            </a>
                            <span class="dot-sep"></span>
                        @endif
                        @if ($series_details['totalseason'] != null)
                            <span>{{ $series_details['totalseason'] ?? '' }}</span>
                            <span class="dot-sep"></span>
                        @endif
                        @if ($series_details['genre'])
                            <span class="movie_type">
                                @foreach ($series_details['genre'] ?? [] as $item)
                                    <a href="{{ route('category', $item['code']) }}?type=genre"
                                        class="px-0">{{ $item['title'] }}</a>{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </span>
                        @endif
                        @if ($series_details['content_qlt'] != '')
                            <span class="content_screen">
                                @php
                                    $content_qlt_arr = explode(',', $series_details['content_qlt']);
                                    $content_qlt_codes_arr = explode(',', $series_details['content_qlt_codes']);
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
                        @if ($series_details['content_rating'] != '')
                            <span class="content_screen">
                                @php
                                    $content_rating_arr = explode(',', $series_details['content_rating']);
                                    $content_rating_codes_arr = explode(',', $series_details['content_rating_codes']);
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
                            @if (isset($series_details['rating_type'], $series_details['video_rating']) &&
                                    $series_details['rating_type'] === 'stars' &&
                                    $series_details['video_rating'] == 1)
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
                            @elseif(isset($series_details['rating_type'], $series_details['video_rating']) &&
                                    $series_details['rating_type'] === 'hearts' &&
                                    $series_details['video_rating'] == 1)
                                <span class="content_screen themePrimaryTxtColr">
                                    <div class="star active" style="display: inline-flex;">
                                        <svg fill="#ffffff" width="15px" height="15px" viewBox="0 0 32 32" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg" stroke="#545454">
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
                            @elseif(isset($series_details['rating_type'], $series_details['video_rating']) &&
                                    $series_details['rating_type'] === 'thumbs' &&
                                    $series_details['video_rating'] == 1)
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
                        @if (isset($series_details['views']) && $series_details['views'] > 0)
                            <span class="content_screen">
                                <i class="bi bi-eye" style="margin-right: 4px;"></i>
                                {{ \App\Helpers\GeneralHelper::formatViews($series_details['views']) }} {{ $series_details['views'] == 1 ? 'view' : 'views' }}
                            </span>
                        @endif
                    </div>

                    <div class="about-movie aboutmovie_gaps">{{ $series_details['stream_description'] }}</div>
                    <dl class="movies_listview">
                        <dl>
                            @if (isset($series_details['cast']) || isset($series_details['director']) || isset($series_details['writer']))
                                @if ($series_details['cast'])
                                    <div class="content-person">
                                        <dt>Cast:</dt>
                                        <dd>
                                            {{ $series_details['cast'] }}
                                        </dd>
                                    </div>
                                @endif
                                @if ($series_details['director'])
                                    <div class="content-person">
                                        <dt>Director:</dt>
                                        <dd>
                                            {{ $series_details['director'] }}
                                        </dd>
                                    </div>
                                @endif
                                @if ($series_details['writer'])
                                    <div class="content-person">
                                        <dt>Writer:</dt>
                                        <dd>
                                            {{ $series_details['writer'] }}
                                        </dd>
                                    </div>
                                @endif
                            @else
                                @foreach ($series_details['starring_data'] as $roleKey => $persons)
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
                            @if (!empty($series_details['advisories']))
                                <div class="content-person">
                                    <dt>Advisory: </dt>
                                    <dd>
                                        @foreach ($series_details['advisories'] as $i => $val)
                                            <a class="person-link" href="{{ route('advisory', $val['code']) }}">
                                                {{ $val['title'] }}{{ $i < count($series_details['advisories']) - 1 ? ',' : '' }}
                                            </a>
                                        @endforeach
                                    </dd>
                                </div>
                            @endif

                            @if (!empty($series_details['languages']))
                                <div class="content-person">
                                    <dt>Language: </dt>
                                    <dd>
                                        @foreach ($series_details['languages'] as $i => $val)
                                            <a class="person-link" href="{{ route('language', $val['code']) }}">
                                                {{ $val['title'] }}{{ $i < count($series_details['languages']) - 1 ? ',' : '' }}
                                            </a>
                                        @endforeach
                                    </dd>
                                </div>
                            @endif
                            @if (!empty($series_details['tags']))
                                <div class="content-person">
                                    <dt>Tags: </dt>
                                    <dd>
                                        @foreach ($series_details['tags'] as $i => $val)
                                            @if ($i < 15)
                                                <a class="person-link" href="{{ route('tag', $val['code']) }}">
                                                    {{ $val['title'] }}{{ $i < 14 && $i < count($series_details['tags']) - 1 ? ',' : '' }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </dl>
                    <div class="button_groupbox d-flex align-items-center mb-1">

                        <div class="btn_box movieDetailPlay">
                            @if (isset($series_details['notify_label']) && $series_details['notify_label'] == 'available now')
                                <a href="{{ route('playerscreen', $series_details['stream_guid']) }}"
                                    class="app-primary-btn rounded">
                                    <i class="fa fa-play"></i>
                                    Available Now
                                </a>
                            @elseif (isset($series_details['notify_label']) && $series_details['notify_label'] == 'coming soon')
                                @if (session()->has('USER_DETAILS') && session('USER_DETAILS') !== null)
                                    <form id="remind-form-desktop" method="POST" action="{{ route('remind.me') }}">
                                        @csrf
                                        <input type="hidden" name="stream_code" id="stream-code"
                                            value="{{ $series_details['stream_guid'] }}">
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
                                        ($series_details['monetization_type'] == 'P' ||
                                            $series_details['monetization_type'] == 'S' ||
                                            $series_details['monetization_type'] == 'O') &&
                                        $series_details['is_buyed'] == 'N')
                                    <a href="{{ route('playerscreen', $series_details['stream_guid']) }}"
                                        class="app-primary-btn rounded">
                                         @if ($series_details['amount'])
                                            Buy Now <i class="fa fa-dollar"></i>{{ $series_details['amount'] }}
                                        @else
                                            <i class="fa fa-dollar"></i> Buy Now
                                        @endif

                                    </a>

                                    @if (isset($series_details['rental_status']) && $series_details['rental_status'] == 1)
                        </div>
                        <div class="me-4">
                            <form action="{{ route('rent.process') }}" method="post">
                                @csrf
                                <input type="hidden" name="stream_guid" value="{{ $series_details['stream_guid'] }}">
                                <input type="hidden" name="monetization_type" value="RP">
                                <input type="hidden" name="stream_title" value="{{ $series_details['stream_title'] }}">
                                <input type="hidden" name="stream_description"
                                    value="{{ $series_details['stream_description'] }}">
                                <input type="hidden" name="planFaq" value="{{ $series_details['rent_frequency'] }}">
                                <input type="hidden" name="plan_period" value="{{ $series_details['rent_period'] }}">
                                <input type="hidden" name="amount" value="{{ $series_details['rent_amount'] }}">
                                <input type="hidden" name="stream_poster"
                                    value="{{ $series_details['stream_poster'] }}">

                                <button type="submit" class="app-primary-btn rounded">
                                    Rent Now
                                    @if ($series_details['monetization_type'] != 'S' && $series_details['amount'])
                                        <span class="old-price">
                                            <i class="fa fa-dollar"></i>{{ $series_details['amount'] }}
                                        </span>
                                    @endif
                                    <span class="new-price">
                                        <i class="fa fa-dollar"></i>{{ $series_details['rent_amount'] }}
                                    </span>
                                </button>
                            </form>
                            @endif
                                @else
                                    <a href="{{ route('playerscreen', $series_details['episode_code']) }}"
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
                                if ($series_details['stream_is_stream_added_in_wish_list'] == 'Y') {
                                    // Update values for removing from wishlist
                                    $cls = 'fa fa-minus';
                                    $signStr = "-";
                                    $tooltip = "Remove from Watchlist";
                                }

                            if ($series_details['stream_is_stream_added_in_wish_list'] == 'Y') {
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
                        <?php
                        }
                        ?>
                        <div class="share_circle addWtchBtn" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                            <a href="javascript:void(0);" role="button" data-bs-toggle="tooltip" title="Share">
                                <i class="fa fa-share theme-active-color"></i>
                            </a>
                        </div>
                        @if (isset(\App\Services\AppConfig::get()->app->badge_status) && \App\Services\AppConfig::get()->app->badge_status === 1)
                            @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'])
                                @if (isset($series_details['gamified_content']) && $series_details['gamified_content'] == 1)
                                    <div class="share_circle addWtchBtn">
                                        <a href="{{ route('user.badge') }}" data-bs-toggle="tooltip"
                                            title="Gamified Content">
                                            <i class="fa-solid fa-award theme-active-color"></i>
                                        </a>
                                    </div>
                                @endif
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
                     @if (session('USER_DETAILS') &&
                            session('USER_DETAILS')['USER_CODE'] &&
                            $series_details['monetization_type'] != 'F' &&
                            $series_details['is_buyed'] == 'N' &&
                            isset($series_details['rent_note']) &&
                            $series_details['rent_note']
                    )
                        <div class="about-movie aboutmovie_gaps">🛍️ {{ $series_details['rent_note'] }}</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
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
                                <input type="hidden" name="stream_code" value="{{ $series_details['stream_guid'] }}">
                                <input type="hidden" name="type" value="S">
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
    <div class="desktop-tabs">
        @include('series-detailscreen.partials.tabs-desktop')
    </div>
    <div class="mobile-tabs">
        @include('series-detailscreen.partials.tabs-mobile')
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
                        @if ((isset($series_details['is_embed']) && $series_details['is_embed'] == 1) || $is_embed == 1)
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
                                href="https://t.me/share/url?url=<?php echo $sharingURL; ?>&text=<?php echo $series_details['stream_title']; ?>"
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
        $(document).ready(function() {
            // Function to initialize Slick slider only when needed
            function initializeSlider() {
                const sliderElement = $('.landscape_slider:not(.slick-initialized)');
                if (sliderElement.length) {
                    sliderElement.slick({
                        slidesToShow: 3,
                        slidesToScroll: 2,
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
    {{--  <script>
        $(document).ready(function() {
            function initSeasonDropdown(dropdownId, sliderClass, seasons) {
                const seasonDropdown = $(`#${dropdownId}`);
                const sliderContainer = $(`.${sliderClass}`);

                // Populate dropdown with seasons
                seasons.forEach((season, index) => {
                    seasonDropdown.append(
                        `<option value="${index}" ${index === 0 ? 'selected' : ''}>${season.season_title}</option>`
                    );
                });

                // Function to populate episodes in slider
                function populateEpisodes(episodes) {
                    sliderContainer.empty(); // Clear existing slider items

                    episodes.forEach((episode) => {
                        let strBrige = '';
                        if (episode.monetization_type === 'F') {
                            strBrige = "style='display: none;'";
                        }

                        let screen =
                            (episode.bypass_detailscreen == 1) ||
                            (typeof AppConfig !== 'undefined' && AppConfig.app.app_info
                                .bypass_detailscreen == 1) ?
                            'playerscreen' :
                            'detailscreen';

                        sliderContainer.append(`
                            <div>
                                <a href="{{ url('/') }}/${screen}/${episode.stream_guid}">
                                    <div class="thumbnail_img">
                                        <div class="trending_icon_box" ${strBrige}>
                                            <img src="{{ url('/') }}/assets/images/trending_icon.png" alt="${episode.stream_title}">
                                        </div>
                                        ${episode.is_newly_added === 'Y' ? `
                                                <div class="newly-added-label">
                                                    <span>New Episode</span>
                                                </div>
                                            ` : ''}
                                        <img onerror="this.src='{{ url('/') }}/assets/images/default_img.jpg'"
                                            src="${episode.stream_poster}" alt="${episode.stream_title}">
                                        <div class="detail_box_hide">
                                            <div class="detailbox_time">${episode.stream_duration_timeformat}</div>
                                            <div class="deta_box">
                                                <div class="season_title">${episode.stream_title}</div>
                                                <div class="content_description">${episode.stream_description}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        `);
                    });

                    // Initialize or refresh the slider
                    if (!sliderContainer.hasClass('slick-initialized')) {
                        sliderContainer.slick({
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: true,
                            arrows: true,
                            responsive: [{
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 2
                                    }
                                },
                                {
                                    breakpoint: 480,
                                    settings: {
                                        slidesToShow: 1
                                    }
                                },
                            ],
                        });
                    } else {
                        sliderContainer.slick('refresh');
                    }
                }
                // On season change, update episodes
                seasonDropdown.change(function() {
                    const selectedIndex = $(this).val();
                    const selectedSeason = seasons[selectedIndex];
                    // Populate the new episodes
                    sliderContainer.empty(); // Clear existing slider items
                    sliderContainer.slick('refresh');
                    populateEpisodes(selectedSeason.episodes);
                });
                // Initial population of episodes (first season)
                if (seasons.length > 0) {
                    populateEpisodes(seasons[0].episodes); // Display episodes of the first season
                }
            }

            // Parse JSON-encoded PHP data
            const seasons = @json($seasons);

            // Initialize for desktop
            initSeasonDropdown('seasonDropdown', 'landscape_slider', seasons);

            // Initialize for mobile
            initSeasonDropdown('seasonDropdownMobile', 'landscape_slider_mobile', seasons);
        });
    </script>  --}}
    <script>
        $(document).ready(function() {
            function initSeasonDropdown(dropdownId, sliderClass, seasons) {
                const seasonDropdown = $(`#${dropdownId}`);
                const sliderContainer = $(`.${sliderClass}`);

                // Populate dropdown with seasons
                seasons.forEach((season, index) => {
                    seasonDropdown.append(
                        `<option value="${index}" ${index === 0 ? 'selected' : ''}>${season.season_title}</option>`
                    );
                });

                // Function to populate episodes in slider
                function populateEpisodes(episodes) {
                    // Destroy existing slider if initialized
                    if (sliderContainer.hasClass('slick-initialized')) {
                        sliderContainer.slick('unslick'); // Destroy previous instance
                    }

                    sliderContainer.empty(); // Clear existing episodes

                    episodes.forEach((episode) => {
                        let strBrige = '';
                        if (episode.monetization_type === 'F') {
                            strBrige = "style='display: none;'";
                        }

                        let screen =
                            (episode.bypass_detailscreen == 1) ||
                            (typeof AppConfig !== 'undefined' && AppConfig.app.app_info
                                .bypass_detailscreen == 1) ?
                            'playerscreen' :
                            'detailscreen';

                        sliderContainer.append(`
                        <div>
                            <a href="{{ url('/') }}/${screen}/${episode.stream_guid}">
                                <div class="thumbnail_img">
                                    <div class="trending_icon_box" ${strBrige}>
                                        <img src="{{ url('/') }}/assets/images/trending_icon.png" alt="${episode.stream_title}">
                                    </div>
                                    ${episode.is_newly_added === 'Y' ? `
                                                            <div class="newly-added-label">
                                                                <span>New Episode</span>
                                                            </div>
                                                        ` : ''}
                                    <img onerror="this.src='{{ url('/') }}/assets/images/default_img.jpg'"
                                        src="${episode.stream_poster}" alt="${episode.stream_title}">
                                    <div class="detail_box_hide">
                                        <div class="detailbox_time">${episode.stream_duration_timeformat}</div>
                                        <div class="deta_box">
                                            <div class="season_title">${episode.stream_title}</div>
                                            <div class="content_description">${episode.stream_description}</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `);
                    });

                    // Reinitialize the slider with fresh content
                    sliderContainer.slick({
                        slidesToShow: 5,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: true,
                        arrows: true,
                        responsive: [{
                            breakpoint: 1740,
                            settings: {
                                slidesToShow: 4,
                                slidesToScroll: 2,
                                dots: true,
                                arrows: true
                            }
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 2,
                                dots: true,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 2,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1,
                                dots: false,
                                arrows: false,
                            }
                        }
                    ],
                    });
                }

                // On season change, update episodes
                seasonDropdown.change(function() {
                    const selectedIndex = $(this).val();
                    const selectedSeason = seasons[selectedIndex];

                    // Populate the new episodes
                    populateEpisodes(selectedSeason.episodes);
                });

                // Initial population of episodes (first season)
                if (seasons.length > 0) {
                    populateEpisodes(seasons[0].episodes);
                }
            }

            // Parse JSON-encoded PHP data
            const seasons = @json($seasons);

            // Initialize for desktop
            initSeasonDropdown('seasonDropdown', 'landscape_slider', seasons);

            // Initialize for mobile
            initSeasonDropdown('seasonDropdownMobile', 'landscape_slider_mobile', seasons);
        });
    </script>


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

                        }


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
@endpush
