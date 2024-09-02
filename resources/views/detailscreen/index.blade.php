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
@endsection

@section('content')
    <?php
    $isByPass = 'Y';
    $streamType = $stream_details['stream_type'];
    $streamUrl = $stream_details['stream_promo_url'];
    $mType = '';
    if (strpos($streamUrl, '.m3u8')) {
        $mType = "type='application/x-mpegURL'";
    }
    $sharingURL = url('/') . '/detailscreen/' . $stream_details['stream_guid'];

 
    session()->put('REDIRECT_TO_SCREEN', $sharingURL);
    
    
    $strQueryParm = "streamGuid={$stream_details['stream_guid']}&userCode=" . session('USER_DETAILS.USER_CODE') . '&frmToken=' . session('SESSION_TOKEN');
    
    $stream_code = $stream_details['stream_guid'];
    
    $postData = [
        'stream_code' => $stream_code,
    ];
    
    // $ch = curl_init('https://octv.shop/stage/apis/feeds/v1/get_reviews.php');
    
    // curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // $response = curl_exec($ch);
    
    // if (curl_errno($ch)) {
    //     die('Curl error: ' . curl_error($ch));
    // }
    
    // curl_close($ch);
    
    // $resultArray = json_decode($response, true);
    
    // $userDidComment = false;
    // foreach ($resultArray as $review) {
    //     if (session('USER_DETAILS') && $review['user']['userCode'] === session('USER_DETAILS')['USER_CODE']) {
    //         $userDidComment = true;
    //     }
    // }
    
    ?>
    <link href="https://vjs.zencdn.net/8.5.2/video-js.css" rel="stylesheet" />
    <!-- <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script> -->
    <script src="https://vjs.zencdn.net/8.5.2/video.min.js"></script>

    <style>
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

        .person-link {
            display: inline !important;
        }

        dt {
            margin-right: 15px;
        }

        .test-comma {
            color: gray;
        }

        .movie_detail_inner_box {
            top: 30px !important;
        }
    </style>

    <!--Start of banner section-->
    <section class="banner detailBanner">
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
                    @if ($streamUrl == '')
                        <img src="{{ $stream_details['stream_poster'] }}" alt="{{-- $stream_details['stream_title'] --}}"
                            onerror="this.src='{{ url('/') }}/assets/images/default_img.jpg'">
                    @else
                        {{-- <video id="plyerId" class="video-js vjs-fluid vjs-16-9 vjs-default-skin js-big-play-centered" poster="https://cms.octv.shop/uploads/media_assets/imgs/1676459098_3fa25f0_bWcd9bSl6gz0dH8f2SSwyJVtf8Y0lVzBPCqDjzns65U.jpeg" autoplay data-viblast-key="N8FjNTQ3NDdhZqZhNGI5NWU5ZTI=">
                    <source src="https://stream.adilo.com/adilo-encoding/6V2XCgoJu4HogrlQ/yeB66OuJ/hls/master.m3u8" type='application/x-mpegURL'>
                </video>
                <script>
                    //var player = videojs('plyerId', {fluid: true});
                    var overrideNative = false;

                    var player = videojs('plyerId', {
                        html5: {
                            hls: {
                                overrideNative: overrideNative
                            },
                            nativeVideoTracks: !overrideNative,
                            nativeAudioTracks: !overrideNative,
                            nativeTextTracks: !overrideNative
                        }
                    });
                    player.play();
                </script> --}}

                        <video id="plyerId" class="video-js vjs-fluid vjs-16-9 vjs-default-skin js-big-play-centered"
                            poster="{{ $stream_details['stream_poster'] }}" autoplay loop
                            data-viblast-key="N8FjNTQ3NDdhZqZhNGI5NWU5ZTI=">
                            <source src="{{ $streamUrl }}" {!! $mType !!}>
                        </video>
                        <script>
                            //var player = videojs('plyerId', {fluid: true});
                            var overrideNative = false;

                            var player = videojs('plyerId', {
                                html5: {
                                    hls: {
                                        overrideNative: overrideNative
                                    },
                                    nativeVideoTracks: !overrideNative,
                                    nativeAudioTracks: !overrideNative,
                                    nativeTextTracks: !overrideNative
                                }
                            });
                            player.play();
                        </script>
                    @endif
                </div>
            </div>
            <div class="movie-detail-box">
                <div class="movie_detail_inner_box">
                    <ul class="starpoint" style="display:none;">
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                    </ul>
                    <h1 class="content-heading" title="{{ $stream_details['stream_title'] }}">
                        {{ $stream_details['stream_title'] }}</h1>
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
                            {{-- <span class="movie_type">{{ $stream_details['cat_title'] }}</span> --}}
                            <span class="movie_type">
                                @foreach ($stream_details['genre'] ?? [] as $item)
                                    <a href="{{ route('category', $item['code']) }}?type=genre"
                                        class="px-0">{{ $item['title'] }}</a>{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </span>
                        @endif
                        @if ($streamType == 'S')
                            <span
                                class="movie_type">{{ $stream_details['stream_episode_title'] && $stream_details['stream_episode_title'] !== 'NULL' ? $stream_details['stream_episode_title'] : '' }}</span>
                            <span class="movie_type">{{ $stream_details['show_name'] }}</span>
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
                                                            href="{{ route('person', $person['id']) }}">{{ $person['title'] }}</a>
                                                        @if (!$loop->last)
                                                            <span class="test-comma">, </span>
                                                        @endif
                                                    @else
                                                        <a class="person-link"
                                                            href="{{ route('person', $person) }}">{{ $person }}</a>
                                                        @if (!$loop->last)
                                                            <span class="test-comma">, </span>
                                                        @endif
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
                                            <a class="person-link"
                                                href="{{ route('advisory', $val['code']) }}">{{ $val['title'] }}</a>
                                            @if (count($stream_details['advisories']) - 1 !== $i)
                                                <span class="test-comma">, </span>
                                            @endif
                                        @endforeach
                                    </dd>
                                </div>
                            @endif

                            @if (!empty($stream_details['languages']))
                                <div class="content-person">
                                    <dt>Language: </dt>
                                    <dd>
                                        @foreach ($stream_details['languages'] as $i => $val)
                                            <a class="person-link"
                                                href="{{ route('language', $val['code']) }}">{{ $val['title'] }}</a>
                                            @if (count($stream_details['languages']) - 1 !== $i)
                                                <span class="test-comma">, </span>
                                            @endif
                                        @endforeach
                                    </dd>
                                </div>
                            @endif
                            @if (!empty($stream_details['tags']))
                                <div class="content-person">
                                    <dt>Tags: </dt>
                                    <dd>
                                        @foreach ($stream_details['tags'] as $i => $val)
                                            <a class="person-link"
                                                href="{{ route('tag', $val['code']) }}">{{ $val['title'] }}</a>
                                            @if (count($stream_details['tags']) - 1 !== $i)
                                                <span class="test-comma">, </span>
                                            @endif
                                        @endforeach
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </dl>

                    <div class="button_groupbox d-flex align-items-center mt-4">
                        <div class="btn_box movieDetailPlay">
                            <a href="{{ route('playerscreen', $stream_details['stream_guid']) }}"
                                class="app-primary-btn rounded">
                                <i class="fa fa-play"></i>
                                Play Now
                            </a>
                        </div>

                        <?php
                    if (session('USER_DETAILS.USER_CODE')) {
                        $signStr = "+";
                        $cls = 'fa fa-plus';
                        if ($stream_details['stream_is_stream_added_in_wish_list'] == 'Y') {
                            $cls = 'fa fa-minus';
                            $signStr = "-";
                        }
                    ?>
                        <div class="share_circle addWtchBtn">
                            <a href="javascript:void(0);" onClick="javascript:manageFavItem();"><i id="btnicon-fav"
                                    class="<?php echo $cls; ?>"></i></a>
                            <input type="hidden" id="myWishListSign" value='<?php echo $signStr; ?>' />
                            <input type="hidden" id="strQueryParm" value='<?php echo $strQueryParm; ?>' />
                            <input type="hidden" id="reqUrl" value='{{ route('wishlist.toggle') }}' />
                            @csrf
                        </div>
                        <?php
                    }
                    ?>
                        <div class="share_circle addWtchBtn" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                            <a href="javascript:void(0)"><i class="fa fa-share"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered sharing-madal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Share</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <ul class="share_list">
                        <li>
                            <a data-toggle="tooltip" data-placement="top" title="facebook"
                                href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $sharingURL; ?>" target="_blank">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tooltip" data-placement="top" title="whatsapp"
                                href="https://wa.me/?text=<?php echo $sharingURL; ?>" target="_blank">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tooltip" data-placement="top" title="twitter"
                                href="https://twitter.com/intent/tweet?text=<?php echo $sharingURL; ?>" target="_blank">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tooltip" data-placement="top" title="telegram"
                                href="https://t.me/share/url?url=<?php echo $sharingURL; ?>&text=<?php echo $stream_details['stream_title']; ?>"
                                target="_blank">
                                <i class="fa fa-telegram"></i>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tooltip" data-placement="top" title="linkdin"
                                href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $sharingURL; ?>"
                                target="_blank">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                    <form class="form-inline">
                        <input type="text" class="share_formbox" id="sharingURL" value="<?php echo $sharingURL; ?>"
                            readonly>
                        <input type="button" class="submit_btn share_btnbox" value="Copy">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End of banner section-->


    <div class="sec-device content-wrapper px-2 px-md-3">
        <div class="tab-btns d-flex gap-3 gap-sm-3 gap-md-4 gap-lg-5">
            <!-- Start of season section -->
            <?php
            $arrSeasonData = isset($seasons) ? $seasons['streams'] : null;
            
            if (!empty($arrSeasonData)) {
                // Display the Season tab if data is available
                echo '<div class="tab active" data-tab="like"><span>Season</span></div>';
            } else {
                // Display the "You Might Also Like" tab if no season data is available
                echo '<div class="tab active" data-tab="like"><span>You Might Also Like</span></div>';
            }
            ?>
            <!--End of season section-->
            @if (isset($stream_details['video_rating']) && $stream_details['video_rating'] === 'E')
                <div class="tab" data-tab="reviews"><span>Reviews</span></div>
            @endif
            @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !empty($stream_details['images']))
                <div class="tab" data-tab="images"><span>Images</span></div>
            @endif
            @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !empty($stream_details['pdf']))
                <div class="tab" data-tab="pdf"><span>Pdf</span></div>
            @endif
        </div>
    </div>

    <div class="tab-content">
        <div id="like" class="content">
            <!--Start of season section-->
            <?php
            $arrSeasonData = isset($seasons) ? $seasons['streams'] : null;
    
            if (!empty($arrSeasonData)) {
            ?>
            <!-- Season listing -->
            <div class="season_boxlists">
                <ul class="season_listings">
                    <?php
                        foreach ($arrSeasonData as $seasonData) {
                            $cls = '';
                            if ($seasonData['is_selected'] == 'Y') {
                                $cls = "class='seasonactive rounded'";
                            }
                        ?>
                    <li><a class="rounded" href="<?php echo url('/'); ?>/detailscreen/<?php echo $seasonData['stream_guid']; ?>"
                            <?php echo $cls; ?>><?php echo $seasonData['season_title']; ?></a></li>
                    <?php
                        }
                        ?>
                </ul>
            </div>
            <?php
            }
            ?>
            <!--End of season section-->
            @if (!empty($latest_items))
                <!--Start of thumbnail slider section-->
                <section class="sliders">
                    <div class="slider-container">
                        <!-- Start shows -->
                        <div class="listing_box">
                            <div class="slider_title_box">
                                <div class="list_heading">
                                    <h1>{{ $latest_items['title'] }}</h1>
                                </div>
                            </div>
                            <div class="landscape_slider slider slick-slider">
                                @foreach ($latest_items['streams'] as $arrStreamsData)
                                    @php
                                        if ($arrStreamsData['stream_guid'] === $stream_details['stream_guid']) {
                                            continue;
                                        }

                                        $strBrige = '';
                                        if ($arrStreamsData['monetization_type'] == 'F') {
                                            $strBrige = "style='display: none;'";
                                        }
                                    @endphp
                                    <div>
                                        <a href="{{ url('/') }}/detailscreen/{{ $arrStreamsData['stream_guid'] }}">
                                            <div class="thumbnail_img">
                                                <div class="trending_icon_box" {!! $strBrige !!}><img
                                                        src="{{ url('/') }}/assets/images/trending_icon.png"
                                                        alt="{{ $arrStreamsData['stream_title'] }}"></div>
                                                @if (($arrStreamsData['is_newly_added'] ?? 'N') === 'Y')
                                                    <div class="newly-added-label">
                                                        <span>New Episode</span>
                                                    </div>
                                                @endif
                                                <img onerror="this.src='{{ url('/') }}/assets/images/default_img.jpg'"
                                                    src="{{ $arrStreamsData['stream_poster'] }}"
                                                    alt="{{ $arrStreamsData['stream_title'] }}">
                                                <div class="detail_box_hide">
                                                    <div class="detailbox_time">
                                                        {{ $arrStreamsData['stream_duration_timeformat'] }}
                                                    </div>
                                                    <div class="deta_box">
                                                        <div class="season_title">
                                                            {{ $arrStreamsData['stream_episode_title'] && $arrStreamsData['stream_episode_title'] !== 'NULL' ? $arrStreamsData['stream_episode_title'] : '' }}
                                                        </div>
                                                        <div class="content_title">{{ $arrStreamsData['stream_title'] }}
                                                        </div>
                                                        <div class="content_description">
                                                            {{ $arrStreamsData['stream_description'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- End Shows -->
                    </div>
                </section>
            @endif
        </div>
        @if (isset($stream_details['video_rating']) && $stream_details['video_rating'] === 'E')
            <div id="reviews" class="content d-none"><!--Start of Ratings section-->
                <div class="item-ratings">
                    <h1 class="section-title">Reviews</h1>
                    @php
                        if (sizeof($stream_details['ratings'] ?? []) < 1) {
                            echo '<p class="text-white" style="margin-bottom: -8px !important;">No reviews found.</p>';
                        }

                        $userDidComment = false;
                        foreach ($stream_details['ratings'] ?? [] as $rating) {
                            if (
                                session()->has('USER_DETAILS') &&
                                $rating['user']['id'] == session('USER_DETAILS')['USER_ID']
                            ) {
                                $userDidComment = true;
                            }
                        }
                    @endphp
                    @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !$userDidComment && !$userDidComment)
                        {{-- Stars  --}}
                        @if (isset($stream_details['rating_type']) && $stream_details['rating_type'] === 'stars')
                            <div class="review-rating user-rating">
                                <div class="star" data-rating="1" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>star</title>
                                            <path
                                                d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="2" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>star</title>
                                            <path
                                                d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="3" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>star</title>
                                            <path
                                                d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="4" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>star</title>
                                            <path
                                                d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="5" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>star</title>
                                            <path
                                                d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        @elseif (isset($stream_details['rating_type']) && $stream_details['rating_type'] === 'hearts')
                            {{-- Hearts  --}}
                            <div class="review-rating user-rating">
                                <div class="star" data-rating="1" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>heart</title>
                                            <path
                                                d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="2" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>heart</title>
                                            <path
                                                d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="3" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>heart</title>
                                            <path
                                                d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="4" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>heart</title>
                                            <path
                                                d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="5" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>heart</title>
                                            <path
                                                d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            {{-- @php
                        $isHearted = 0;
                    @endphp
                    <div class="review-rating user-rating" role="button">
                        <div class="heart" data-rating="{{ $isHearted ? 1 : 0 }}" onclick="handleHeartRating(this)">
                            <svg fill="{{ $isHearted ? '#c54f3f' : '#ffffff' }}" height="27px" width="27px"
                                version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 471.701 471.701"
                                xml:space="preserve" stroke="#bfbfbf">
                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <path
                                            d="M433.601,67.001c-24.7-24.7-57.4-38.2-92.3-38.2s-67.7,13.6-92.4,38.3l-12.9,12.9l-13.1-13.1 c-24.7-24.7-57.6-38.4-92.5-38.4c-34.8,0-67.6,13.6-92.2,38.2c-24.7,24.7-38.3,57.5-38.2,92.4c0,34.9,13.7,67.6,38.4,92.3 l187.8,187.8c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-3.9l188.2-187.5c24.7-24.7,38.3-57.5,38.3-92.4 C471.801,124.501,458.301,91.701,433.601,67.001z M414.401,232.701l-178.7,178l-178.3-178.3c-19.6-19.6-30.4-45.6-30.4-73.3 s10.7-53.7,30.3-73.2c19.5-19.5,45.5-30.3,73.1-30.3c27.7,0,53.8,10.8,73.4,30.4l22.6,22.6c5.3,5.3,13.8,5.3,19.1,0l22.4-22.4 c19.6-19.6,45.7-30.4,73.3-30.4c27.6,0,53.6,10.8,73.2,30.3c19.6,19.6,30.3,45.6,30.3,73.3 C444.801,187.101,434.001,213.101,414.401,232.701z" />
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div> --}}
                        @else
                            {{-- Thumbs  --}}
                            <div class="user-rating" style=" margin-top: 25px; display: flex; gap: 12px;">
                                <div class="like" style="rotate: 180deg" role="button"
                                    onclick="handleRating(this, 'like')">
                                    <input class="form-check-input" type="radio" name="like_status" id="like_status"
                                        value="5" style="display: none">
                                    <label class="form-check-label" for="like_status" role="button">
                                        <svg fill="#6e6e6e" height="27px" width="27px" version="1.1" id="Capa_1"
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
                                    </label>
                                </div>
                                <div class="dislike" role="button" onclick="handleRating(this, 'dislike')">
                                    <input class="form-check-input" type="radio" name="like_status"
                                        id="dislike_status" value="1" style="display: none">
                                    <label class="form-check-label" for="dislike_status" role="button">
                                        <svg fill="#6e6e6e" height="27px" width="27px" version="1.1" id="Capa_1"
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
                                    </label>

                                </div>
                            </div>
                        @endif

                        <span class="text-danger">
                            @error('rating')
                                {{ $message }}
                            @enderror
                        </span>
                        <form action="{{ route('addrating') }}" method="POST" onsubmit="return submitOnce()">
                            @csrf
                            <textarea name="comment" cols="30" rows="10" placeholder="Let others know what you think..."></textarea>
                            <input type="hidden" name="rating" id="hiddenRating">
                            <input type="hidden" name="stream_code" value="{{ $stream_details['stream_guid'] }}">
                            <input type="hidden" name="type" value="stream">
                            <input class="rounded" type="submit" id="submitButton" value="Submit">
                        </form>
                        <hr>
                    @endif

                    <div
                        class="member-reviews mt-2 {{ !session('USER_DETAILS') || !session('USER_DETAILS')['USER_CODE'] || $userDidComment ? 'mt-4' : '' }}">
                        <?php
                foreach ($stream_details['ratings'] as $review) {
                    $name = $review['user']['name'];
                    $name_arr = explode(' ', $name);
                    $name_symbol = '';

                    $name_symbol .= $name_arr[0][0];

                    if (sizeof($name_arr) > 1)
                        $name_symbol .= $name_arr[1][0];

                    ?>

                        <div class="review">
                            <div class="user">
                                <div class="profile-name"><?= $name_symbol ?></div>
                                <h4 class="username mb-0"><?= $review['user']['name'] ?></h4>
                            </div>
                            <div class="review-rating member">

                                @if (isset($stream_details['rating_type']) && $stream_details['rating_type'] === 'stars')
                                    @for ($i = 0; $i < $review['rating']; $i++)
                                        <div class="star active">
                                            <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                                version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <title>star</title>
                                                    <path
                                                        d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                                    </path>
                                                </g>
                                            </svg>
                                        </div>
                                    @endfor
                                @elseif (isset($stream_details['rating_type']) && $stream_details['rating_type'] === 'hearts')
                                    @for ($i = 0; $i < $review['rating']; $i++)
                                        <div class="star active">
                                            <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                                version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <title>heart</title>
                                                    <path
                                                        d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                                    </path>
                                                </g>
                                            </svg>
                                        </div>
                                    @endfor
                                @else
                                    {{-- Thumbs  --}}
                                    <div class="user-rating" style="margin-top: 25px; display: flex; gap: 12px;">
                                        @if ($review['rating'] >= 3)
                                            <div class="like active" style="rotate: 180deg">
                                                <svg fill="#c54f3f" height="27px" width="27px" version="1.1"
                                                    id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    viewBox="0 0 208.666 208.666" xml:space="preserve" stroke="#6e6e6e">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round">
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
                                        @else
                                            <div class="dislike">
                                                <svg fill="#c54f3f" height="27px" width="27px" version="1.1"
                                                    id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    viewBox="0 0 208.666 208.666" xml:space="preserve" stroke="#6e6e6e">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round">
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
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <p class="member-comment">{{ $review['comment'] }}</p>
                        </div>
                        <hr>
                        <?php
                }
            ?>
                    </div>
                </div>

            </div>
        @endif
        @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !empty($stream_details['images']))
            <div id="images" class="content d-none">
                <div class="container">
                    <div class="custom-gallery row custom-border p-4">

                        <!-- Featured Image -->
                        <div class="custom-placeholder col-md-7 mb-4" id="custom-featured">
                            <img src="{{ $stream_details['images'][0]['video_url_local'] }}" class="img-fluid p-2"
                                style="width: 100%; height: auto; object-fit: cover;">
                        </div>

                        <!-- Thumbnail Images -->
                        <div class="custom-gallery-images col-md-5">
                            <div class="row">
                                @foreach ($stream_details['images'] as $image)
                                    <div class="custom-image col-4 mb-2">
                                        <img src="{{ $image['video_url_local'] }}" data-id="{{ $loop->index }}"
                                            class="img-fluid custom-border p-2"
                                            style="width: 100%; height: 80%; object-fit: cover; cursor: pointer;">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif

        @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !empty($stream_details['pdf']))
            <div id="pdf" class="content d-none">
                <div class="row">
                    @foreach ($stream_details['pdf'] as $pdf)
                        <div class="col-md-3 mb-4 d-flex justify-content-center">
                            <a href="{{ $pdf['video_url_local'] }}" target="_blank"
                                class="d-block text-center custom-link">
                                @if (Str::endsWith($pdf['video_url_local'], ['.pdf']))
                                    <i class="fas fa-file-pdf custom-icon pdf-icon"></i>
                                @elseif (Str::endsWith($pdf['video_url_local'], ['.doc', '.docx']))
                                    <i class="fas fa-file-word custom-icon word-icon"></i>
                                @else
                                    <i class="fas fa-file-alt custom-icon other-icon"></i>
                                @endif
                                <p class="mt-2 custom-text">{{ $pdf['name'] }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
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
                element.querySelector('svg').style.fill = 'red'; // Change to hearted color
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
                likeButton.querySelector('svg').style.fill = '#c54f3f'; // Change to liked color
                dislikeButton.querySelector('svg').style.fill = '#6e6e6e'; // Reset dislike button color
                hiddenRating.value = 5; // Set hidden input value to 1 for like
            } else {
                dislikeButton.querySelector('svg').style.fill = '#c54f3f'; // Change to disliked color
                likeButton.querySelector('svg').style.fill = '#6e6e6e'; // Reset like button color
                hiddenRating.value = 1; // Set hidden input value to 0 for dislike
            }
        }


        function submitOnce() {
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
                        slidesToShow: 3, // Adjust as needed
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true,
                        arrows: true,
                        responsive: [{
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 2,
                                }
                            },
                            {
                                breakpoint: 480,
                                settings: {
                                    slidesToShow: 1,
                                }
                            }
                        ]
                    });
                }
            }

            // Initialize slider for the first tab by default
            initializeSlider();

            // Handle tab switching
            const tabs = document.querySelectorAll('.sec-device .tab');
            const contents = document.querySelectorAll('.tab-content .content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs and hide all content
                    tabs.forEach(t => t.classList.remove('active'));
                    contents.forEach(c => c.classList.add('d-none'));

                    // Add active class to the clicked tab and show the corresponding content
                    this.classList.add('active');
                    const activeContent = document.getElementById(this.getAttribute('data-tab'));
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

            // Handle image click for custom gallery
            $('.custom-image img').click(function() {
                var src = $(this).attr('src');
                var img = $('#custom-featured img');

                img.fadeOut('fast', function() {
                    $(this).attr('src', src).fadeIn('fast');
                });
            });
        });
    </script>
@endpush
