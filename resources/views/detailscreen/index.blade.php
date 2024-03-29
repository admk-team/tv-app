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

    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
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
                            @if (!empty($stream_details['advisories']))
                                <div class="content-person">
                                    <dt>Advisory: </dt>
                                    <dd>
                                        @foreach ($stream_details['advisories'] as $i => $val)
                                            <a class="person-link"
                                                href="{{ route('advisory', $val['code']) }}">{{ $val['title'] }}
                                                @if (count($stream_details['advisories']) - 1 !== $i)
                                                    ,
                                                @endif
                                        @endforeach
                                    </dd>
                                </div>
                            @endif

                            @if (!empty($stream_details['languages']))
                                <div class="content-person" style="margin-bottom: 20px">
                                    <dt>Language: </dt>
                                    <dd>
                                        @foreach ($stream_details['languages'] as $i => $val)
                                            <a class="person-link"
                                                href="{{ route('language', $val['code']) }}">{{ $val['title'] }}
                                                @if (count($stream_details['languages']) - 1 !== $i)
                                                    ,
                                                @endif
                                        @endforeach
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </dl>

                    <div class="button_groupbox d-flex align-items-center">
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
    @if (isset($stream_details['video_rating']) && $stream_details['video_rating'] === 'E')
        <div class="item-ratings">
            <h1 class="section-title">Reviews</h1>
            @php
                if (sizeof($stream_details['ratings'] ?? []) < 1) {
                    echo '<p class="text-white" style="margin-bottom: -8px !important;">No reviews found.</p>';
                }

                $userDidComment = false;
                foreach ($stream_details['ratings'] ?? [] as $rating) {
                    if (session()->has('USER_DETAILS') && $rating['user']['id'] == session('USER_DETAILS')['USER_ID']) {
                        $userDidComment = true;
                    }
                }
            @endphp

            @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !$userDidComment && !$userDidComment)
                <div class="review-rating user-rating">
                    <div class="star" data-rating="1" onclick="handleStarRating(this)">
                        <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
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
                        <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
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
                        <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
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
                        <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
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
                        <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
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
                <span class="text-danger">
                    @error('rating')
                        {{ $message }}
                    @enderror
                </span>
                <form action="{{ route('addrating') }}" method="POST" onsubmit="return submitOnce()">
                    @csrf
                    <textarea name="comment" cols="30" rows="10" placeholder="Let others know what you think..."></textarea>
                    <input type="hidden" name="rating">
                    <input type="hidden" name="stream_code" value="{{ $stream_details['stream_guid'] }}">
                    <input type="hidden" name="type" value="stream">
                    <input type="submit" id="submitButton" value="Submit">
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
                        <?php
                        
                        for ($i = 0; $i < $review['rating']; $i++) {
                            echo '<div class="star active">                                                                                                                                                                                                                                                                                </div>';
                        }
                        
                        ?>
                    </div>
                    <p class="member-comment">{{ $review['comment'] }}</p>
                </div>
                <hr>
                <?php
                }
            ?>
            </div>
        </div>
    @endif

    <?php
    $arrSeasonData = isset($seasons)? $seasons['streams']: null;

    if (!empty($arrSeasonData)) {
    ?>
    <!-- Season listing -->
    <div class="season_boxlists">
        <ul class="season_listings">
            <?php
                foreach ($arrSeasonData as $seasonData) {
                    $cls = '';
                    if ($seasonData['is_selected'] == 'Y') {
                        $cls = "class='seasonactive'";
                    }
                ?>
            <li><a href="<?php echo url('/'); ?>/detailscreen/<?php echo $seasonData['stream_guid']; ?>"
                    <?php echo $cls; ?>><?php echo $seasonData['season_title']; ?></a></li>
            <?php
                }
                ?>
        </ul>
    </div>
    <?php
    }
    ?>

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
                                                <!-- <div class="play_icon"><a href="/details/21"><i class="fa fa-play" aria-hidden="true"></i></a>
                                                                                                                                                                                              </div> -->
                                                <div class="content_title">{{ $arrStreamsData['stream_title'] }}</div>
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

        function submitOnce() {
            document.getElementById('submitButton').disabled = true;
            return true;
        }
    </script>
@endsection

@push('scripts')
@endpush
