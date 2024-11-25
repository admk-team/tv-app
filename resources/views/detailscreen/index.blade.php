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
    <!-- Video.js CSS and JS -->
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-youtube@2.6.1/dist/Youtube.min.js"></script>
@endsection

@section('content')
    <?php
    $isByPass = 'Y';
    $streamType = $stream_details['stream_type'];
    $streamUrl = $stream_details['stream_promo_url'];
    $mType = '';
    if ($streamUrl) {
        if (strpos($streamUrl, '.m3u8') !== false) {
            $mType = "type='application/x-mpegURL'";
        } elseif (strpos($streamUrl, 'youtube.com') !== false) {
            $mType = "type='video/youtube'";
        } elseif (strpos($streamUrl, 'youtu.be') !== false) {
            $isShortYouTube = preg_match('/youtu\.be\/([^?&]+)/', $streamUrl, $shortYouTubeMatches);
            if ($isShortYouTube) {
                $urlId = $shortYouTubeMatches[1];
                $streamUrl = 'https://www.youtube.com/watch?v=' . $urlId;
                $mType = "type='video/youtube'";
            }
        } elseif (strpos($streamUrl, 'vimeo.com') !== false) {
            $mType = "type='video/vimeo'";
        }
    }
    $sharingURL = url('/') . '/detailscreen/' . $stream_details['stream_guid'];

    session()->put('REDIRECT_TO_SCREEN', $sharingURL);

    $strQueryParm = "streamGuid={$stream_details['stream_guid']}&userCode=" . session('USER_DETAILS.USER_CODE') . '&frmToken=' . session('SESSION_TOKEN');
    $is_embed = \App\Services\AppConfig::get()->app->is_embed ?? null;

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
                    @if ($streamUrl == '')
                        <img src="{{ $stream_details['stream_poster'] }}" alt="{{ $stream_details['stream_title'] }}"
                            onerror="this.src='{{ url('/') }}/assets/images/default_img.jpg'">
                    @else
                        <!-- Video Player -->
                        <video id="plyerId" class="video-js vjs-fluid vjs-16-9 vjs-default-skin js-big-play-centered"
                            poster="{{ $stream_details['stream_poster'] }}" autoplay muted loop>
                            <source src="{{ $streamUrl }}" {!! $mType !!}>
                        </video>


                        <script>
                            // Initialize Video.js player
                            var player = videojs('plyerId', {
                                fluid: true,
                                techOrder: ['youtube', 'vimeo', 'html5'],
                                html5: {
                                    hls: {
                                        overrideNative: false
                                    },
                                    nativeVideoTracks: true,
                                    nativeAudioTracks: true,
                                    nativeTextTracks: true
                                }
                            });

                            // Function to attempt autoplay
                            function attemptAutoplay() {
                                player.play().then(function() {
                                    console.log("Autoplay started successfully.");
                                }).catch(function(error) {
                                    console.log('Autoplay blocked or failed. Error:', error);
                                });
                            }

                            // Ensure the player is fully ready before attempting to play
                            player.ready(function() {
                                attemptAutoplay(); // Try autoplay
                            });

                            // Add event listener to trailer button to restart/replay the video
                            window.addEventListener('load', () => {
                                var trailerButton = document.getElementById('trailer-id');
                                if (trailerButton) {
                                    trailerButton.addEventListener('click', function() {
                                        player.currentTime(0);
                                        player.play().then(function() {
                                            console.log("Video played from start.");
                                        }).catch(function(error) {
                                            console.log('Error playing video manually:', error);
                                        });
                                    });
                                }
                            });

                            // Prevent player from reloading while video is already playing
                            player.on('loadstart', function() {
                                console.log("Player load started.");
                            });
                        </script>
                    @endif
                </div>


            </div>
            <div class="movie-detail-box desktop-data">
                <div
                    class="movie_detail_inner_box {{ isset($stream_details['title_logo']) && $stream_details['title_logo'] ? 'with-logo' : 'without-logo' }}">
                    @if (isset($stream_details['title_logo']) && $stream_details['title_logo'])
                        <div class="title_logo mb-1">
                            <img class="img-fluid" src="{{ $stream_details['title_logo'] }}"
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
                            @if ($stream_details['genre'])
                                <span class="movie_type">
                                    @foreach ($stream_details['genre'] ?? [] as $item)
                                        <a href="{{ route('category', $item['code']) }}?type=genre"
                                            class="px-0">{{ $item['title'] }}</a>{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </span>
                            @endif
                        @endif
                        @if ($streamType == 'S')
                            @if ($stream_details['stream_episode_title'])
                                <span
                                    class="movie_type">{{ $stream_details['stream_episode_title'] && $stream_details['stream_episode_title'] !== 'NULL' ? $stream_details['stream_episode_title'] : '' }}</span>
                            @endif
                            @if ($stream_details['show_name'])
                                <span class="movie_type">{{ $stream_details['show_name'] }}</span>
                            @endif
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
                                                        <a class="person-link" href="{{ route('person', $person['id']) }}">
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
                                                <!-- Only show the first 15 tags -->
                                                <a class="person-link" href="{{ route('tag', $val['code']) }}">
                                                    {{ $val['title'] }}{{ $i < 14 ? ',' : '' }}
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
                        @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'])
                            @if (!empty($stream_details['is_watch_party']) && $stream_details['is_watch_party'] == 1)
                                <div class="share_circle">
                                    <a href="{{ route('create.watch.party', $stream_details['stream_guid']) }}">
                                        <i class="fa fa-users"></i>
                                    </a>
                                </div>
                            @endif
                        @endif
                        <?php
                    }
                    ?>
                        <div class="share_circle addWtchBtn" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                            <a href="javascript:void(0)"><i class="fa fa-share"></i></a>
                        </div>
                        @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'])
                            @if (
                                !empty($stream_details['is_gift']) &&
                                    $stream_details['is_gift'] == 1 &&
                                    ($stream_details['monetization_type'] == 'P' ||
                                        $stream_details['monetization_type'] == 'S' ||
                                        $stream_details['monetization_type'] == 'O'))
                                <div class="share_circle addWtchBtn" data-bs-toggle="modal" data-bs-target="#giftModal">
                                    <a href="javascript:void(0);"><i class="fa-solid fa-gift"></i></a>
                                </div>
                            @endif
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
                        @if (isset($stream_details['is_embed']) || $is_embed)
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
@endsection

@push('scripts')
    //for desktop tabs
    <script>
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
    //for mobile tabs
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
@endpush
