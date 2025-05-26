@extends('layouts.app')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mvp.css') }}" />
    <script src="{{ asset('assets/js/new.js') }}"></script>
    <script src="{{ asset('assets/js/vast.js') }}"></script>
    <script src="{{ asset('assets/js/share_manager.js') }}"></script>
    <script src="{{ asset('assets/js/cache.js') }}"></script>
    <script src="{{ asset('assets/js/ima.js') }}"></script>
    <script src="{{ asset('assets/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/playlist_navigation.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
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

            return toMatch.some((toMatchItem) => {
                return navigator.userAgent.match(toMatchItem);
            });
        }
        //alert(detectMob());
    </script>
    <style>
        .channel-btn-1 {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5px 24px;
            border-radius: 50px;
            background: var(--headerBgColor);
            color: #fff;
            transition: all 0.3s ease;
            min-width: 200px;
            border: none;
        }

        .channel-btn-1:hover:not(:disabled) {
            transform: translateY(-3px);
            cursor: pointer;
        }

        .channel-btn-1:disabled {
            background: var(--headerBgColor);
            opacity: 0.6;
            color: #fff;
            cursor: not-allowed;
            pointer-events: none;
        }

        .channel-btn-1 small {
            font-size: 0.75rem;
            opacity: 0.8;
        }
    </style>
@endpush
@section('content')
    @php
        if (
            isset(\App\Services\AppConfig::get()->app->app_info->is_bypass_login) &&
            \App\Services\AppConfig::get()->app->app_info->is_bypass_login == 'N'
        ) {
            if (!session('USER_DETAILS') || !session('USER_DETAILS')['USER_CODE']) {
                // Extract parameters from the current request
                $channelGuid = request()->route('channelGuid');
                $slug = request()->route('slug');

                // Store the full intended route in session
                session([
                    'REDIRECT_TO_SCREEN' => route('player.tvguide', ['channelGuid' => $channelGuid, 'slug' => $slug]),
                ]);
                session()->save();
                // Redirect to login
                \Illuminate\Support\Facades\Redirect::to(route('login'))->send();
            }
        }

        if (isset($_COOKIE['timezoneStr']) && !empty($_COOKIE['timezoneStr'])) {
            date_default_timezone_set($_COOKIE['timezoneStr']);
        } else {
            date_default_timezone_set('America/New_York');
        }

        // $adUrl = \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_site_ad_url;

        if (!session('ADS_INFO')) {
            session([
                'ADS_INFO' => [
                    'adUrl' => \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_site_ad_url,
                    'channelName' => \App\Services\AppConfig::get()->app->app_info->app_name,
                    'domain_name' => \App\Services\AppConfig::get()->app->colors_assets_for_branding->domain_name,
                ],
            ]);
        }

        $cb = time();
        $isLocalHost = false;
        $userIP = \App\Helpers\GeneralHelper::getRealIpAddr();
        $channelName = urlencode(\App\Services\AppConfig::get()->app->app_info->app_name);
        $appStoreUrl = urlencode(\App\Services\AppConfig::get()->app->colors_assets_for_branding->roku_app_store_url);
        $userAgent = urlencode(request()->server('HTTP_USER_AGENT'));

        $host = parse_url(url()->current())['host'];
        if (in_array($host, ['localhost', '127.0.0.1'])) {
            $isLocalHost = true;
        }

        // $adMacros =
        //     $adUrl .
        //     "&width=1920&height=1080&cb=$cb" .
        //     (!$isLocalHost ? "&uip=$userIP" : '') .
        //     "&device_id=RIDA&vast_version=2&app_name=$channelName&device_make=ROKU&device_category=5&app_store_url=$appStoreUrl&ua=$userAgent";

    @endphp

    <div class="top_gaps">
        <div class="container-fluid containinax">
            <div class="row">
                <div class="col-md-12">
                    <div class="videocentalize" id="render-page">
                        <div id="wrapper"></div>
                        <div id="mvp-playlist-list">
                            <div class="mvp-global-playlist-data"></div>
                            <div class="playlist-video">
                                @php
                                    $leftTime = 0; // Playback offset within the current stream
                                    $currentStream = null; // The stream that is currently playing
                                    $curUnixTime = now()->timestamp; // Current timestamp

                                    foreach ($data['channel'] ?? [] as $channel) {
                                        foreach ($channel['playlists'] as $playlist) {
                                            // Calculate playlist start and end timestamps
                                            $playlistStartDateTime = strtotime(
                                                $playlist['start_date'] . ' ' . $playlist['start_time'],
                                            );
                                            $playlistEndDateTime = strtotime(
                                                $playlist['end_date'] . ' ' . $playlist['end_time'],
                                            );

                                            // Check if the current time falls within the playlist duration
                                            if (
                                                $curUnixTime >= $playlistStartDateTime &&
                                                $curUnixTime <= $playlistEndDateTime
                                            ) {
                                                // Calculate total stream duration for one cycle (all streams)
                                                $totalStreamDuration =
                                                    array_sum(array_column($playlist['streams'], 'duration')) * 60;

                                                // Calculate elapsed time within the playlist
                                                $elapsedTimeInPlaylist = $curUnixTime - $playlistStartDateTime;

                                                // Find the elapsed time within the repeated stream cycle
                                                $loopedElapsedTime = $elapsedTimeInPlaylist % $totalStreamDuration;

                                                $adUrl = $playlist['vmap'];
                                                // $adUrl = "http://127.0.0.1:8000/vast-tags/41/xml";

                                                $adMacros = '';
                                                $parsed_url = parse_url($adUrl);
                                                if (isset($parsed_url['query'])) {
                                                    $adMacros =
                                                        $adUrl .
                                                        "&width=1920&height=1080&cb=$cb" .
                                                        (!$isLocalHost ? "&uip=$userIP" : '') .
                                                        "&device_id=RIDA&vast_version=2&app_name=$channelName&device_make=ROKU&device_category=5&app_store_url=$appStoreUrl&ua=$userAgent";
                                                } else {
                                                    $adMacros =
                                                        $adUrl .
                                                        "?width=1920&height=1080&cb=$cb" .
                                                        (!$isLocalHost ? "&uip=$userIP" : '') .
                                                        "&device_id=RIDA&vast_version=2&app_name=$channelName&device_make=ROKU&device_category=5&app_store_url=$appStoreUrl&ua=$userAgent";
                                                }

                                                $dataVast = 'data-vast="' . url('/get-ad') . '"';
                                                $dataVast = "data-vast='$adMacros'";
                                                if ($adUrl == '') {
                                                    $dataVast = '';
                                                }

                                                // Iterate over the streams to determine the current stream
                                                $streamStartTime = 0; // Start at the beginning of the stream cycle
                                                foreach ($playlist['streams'] as $stream) {
                                                    $streamDurationInSeconds = $stream['duration'] * 60; // Convert minutes to seconds
                                                    $streamEndTime = $streamStartTime + $streamDurationInSeconds;

                                                    // Check if the looped elapsed time falls within the current stream
                                                    if (
                                                        $loopedElapsedTime >= $streamStartTime &&
                                                        $loopedElapsedTime < $streamEndTime
                                                    ) {
                                                        $currentStream = $stream; // Set the current stream
                                                        $leftTime = $loopedElapsedTime - $streamStartTime; // Calculate playback offset
                                                        break 2; // Exit both loops
                                                    }

                                                    $streamStartTime = $streamEndTime; // Move to the next stream
                                                }
                                            }
                                        }
                                    }
                                @endphp

                                @if ($currentStream)
                                    <div class="mvp-playlist-item" data-preview-seek="auto" data-type="hls"
                                        data-path="{{ $currentStream['url'] }}" {!! $dataVast !!}
                                        data-poster="{{ $currentStream['poster'] }}"
                                        data-thumb="{{ $currentStream['poster'] }}"
                                        data-title="{{ $currentStream['title'] }}"
                                        data-description="{{ $currentStream['title'] }}">
                                    </div>
                                @else
                                    <p>No stream is currently playing at this time.</p>
                                @endif


                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2 mb-2 gap-3">
                            <!-- Previous Button -->
                            @if ($data['previous_channel'] !== null)
                                <button class="channel-btn-1 ajax-channel-btn"
                                    data-guid="{{ $data['previous_channel']['code'] }}">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    <div>
                                        <div class="fw-bold">Previous</div>
                                        <small>{{ $data['previous_channel']['title'] }}</small>
                                    </div>
                                </button>
                            @else
                                <button class="channel-btn-1" disabled>
                                    <i class="fas fa-arrow-left me-2"></i>
                                    <div>
                                        <div class="fw-bold">Previous</div>
                                    </div>
                                </button>
                            @endif

                            <!-- Next Button -->
                            @if ($data['next_channel'] !== null)
                                <button class="channel-btn-1 ajax-channel-btn"
                                    data-guid="{{ $data['next_channel']['code'] }}">
                                    <div>
                                        <div class="fw-bold">Next</div>
                                        <small>{{ $data['next_channel']['title'] }}</small>
                                    </div>
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            @else
                                <button class="channel-btn-1" disabled>
                                    <div class="fw-bold">Next</div>
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var leftTime = {{ $leftTime }};
            initPlayer(leftTime);
        });

        function initPlayer(leftTime = 0) {
            var leftTime = {{ $leftTime }};
            var isshowlist = true;
            var pListPostion = 'vrb';
            if (detectMob()) {
                var pListPostion = 'hb';
            }

            var settings = {
                skin: 'sirius',
                playlistPosition: pListPostion,
                sourcePath: "",
                activeItem: 0,
                activePlaylist: ".playlist-video",
                playlistList: "#mvp-playlist-list",
                instanceName: "player1",
                hidePlaylistOnMinimize: true,
                volume: 0.75,
                useShare: '{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_is_show_share_icon }}',
                autoPlay: true,
                crossorigin: "link",
                playlistOpened: false,
                randomPlay: false,
                usePlaylistToggle: false,
                useEmbed: false,
                // useEmbed: '{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_is_show_share_icon }}',
                useTime: false,
                usePip: true,
                useCc: true,
                useAirPlay: true,
                usePlaybackRate: true,
                useNext: false,
                usePrevious: false,
                useRewind: false,
                useSkipBackward: false,
                useSkipForward: false,
                showPrevNextVideoThumb: false,
                rememberPlaybackPosition: 'all',
                useQuality: true,
                useImaLoader: true,
                useTheaterMode: true,
                focusVideoInTheater: true,
                hidePlaylistOnTheaterEnter: true,
                useSubtitle: true,
                useTranscript: false,
                useChapterToggle: false,
                useCasting: true,
                comingNextHeader: "Coming Next",
                comingNextCancelBtnText: "CANCEL",
                mediaEndAction: 'comingnext',
                comingnextTime: 10,
                disableVideoSkip: true,
                useAdSeekbar: true,
                useAdControls: true,
                useMobileListMenu: true,
                playbackRateArr: [{
                        value: 2,
                        menu_title: '2x'
                    },
                    {
                        value: 1.5,
                        menu_title: '1.5x'
                    },
                    {
                        value: 1.25,
                        menu_title: '1.25x'
                    },
                    {
                        value: 1,
                        menu_title: '1x (Normal)'
                    },
                    {
                        value: 0.5,
                        menu_title: '0.5x'
                    },
                    {
                        value: 0.25,
                        menu_title: '0.25x'
                    }
                ],
            };
            player = new mvp(document.getElementById('wrapper'), settings);
            // document.querySelector(".videocentalize").style.pointerEvents = "none";

            setTimeout(unmutedVoice, 2000);
            var isFirstTIme = true;
            player.addEventListener('mediaStart', function(data) {
                if (isFirstTIme == true) {
                    isFirstTIme = false;
                    player.seek({{ $leftTime }});
                }
                data.instance.getCurrentTime();
                data.instance.getDuration();

                makeVolumeButtontoggable(); // Fix mute toggle
            });
            player.addEventListener("mediaEnd", function(data) {
                // Automatically move to the next stream in the playlist
                player.nextMedia({
                    autoPlay: true
                });
            });
            player.addEventListener("mediaPlay", function(data) {

                // alert("mediaPlay");

            });
            player.addEventListener("adPlay", function(data) {

                //alert("adPlay");

            });
            player.addEventListener("adPause", function(data) {

                //alert("adPause");

            });
            player.addEventListener("adEnd", function(data) {

                // alert("ad End");

            });
        };

        function unmutedVoice() {
            player.toggleMute();
            player.playMedia();
        }

        function makeVolumeButtontoggable() {
            $('.mvp-volume-toggle').addClass('mvp-volume-toggable');
        }

        $(document).on('click', '.ajax-channel-btn', function() {
            const channelGuid = $(this).data('guid');
            $.ajax({
                url: `/next-previous/${channelGuid}`,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#render-page').replaceWith(response.newHtml);
                        initPlayer(0);
                    }
                },
                error: function(xhr) {
                    console('Unable to load channel. Please try again.');
                }
            });
        });
    </script>
@endpush
