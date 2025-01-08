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
@endpush
@section('content')
    @php
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
                    <div class="videocentalize">
                        <div id="wrapper"></div>
                        <div id="mvp-playlist-list">
                            <div class="mvp-global-playlist-data"></div>
                            <div class="playlist-video">
                                @php
                                    $leftTime = 0; // Playback offset within the current stream
                                    $currentStream = null; // The stream that is currently playing
                                    $curUnixTime = now()->timestamp; // Current timestamp
                                    $dataVast = '';

                                    foreach ($data['channel'] as $channel) {
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

                                                // Iterate over the streams to determine the current stream
                                                $streamStartTime = 0; // Start at the beginning of the stream cycle
                                                foreach ($playlist['streams'] as $stream) {
                                                    {
                                                        $adUrl = $playlist['vmap'];

                                                        $useragent = request()->server('HTTP_USER_AGENT');
                                                        $isMobileBrowser = 0;
                                                        if (
                                                            preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) ||
                                                            preg_match(
                                                                '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',
                                                                substr($useragent, 0, 4),
                                                            )
                                                        ) {
                                                            $isMobileBrowser = 1;
                                                        }
                                                        $isMobileBrowser = 0;
                                                        //$dataVast = 'data-vast="' . url('/get-ad?' . $adParam) . '"';
                                                        $cb = time();
                                                        $userAgent = urlencode(request()->server('HTTP_USER_AGENT'));
                                                        $userIP = \App\Helpers\GeneralHelper::getRealIpAddr();
                                                        $channelName = urlencode(\App\Services\AppConfig::get()->app->app_info->app_name);

                                                        $isLocalHost = false;
                                                        $host = parse_url(url()->current())['host'];
                                                        if (in_array($host, ['localhost', '127.0.0.1'])) {
                                                            $isLocalHost = true;
                                                        }

                                                        $appStoreUrl = urlencode(\App\Services\AppConfig::get()->app->colors_assets_for_branding->roku_app_store_url);
                                                        if (parse_url($adUrl, PHP_URL_QUERY)) {
                                                            $adMacros = $adUrl . "&width=1920&height=1080&cb=$cb&" . (!$isLocalHost ? "uip=$userIP&" : '') . "device_id=RIDA&vast_version=2&app_name=$channelName&device_make=ROKU&device_category=5&app_store_url=$appStoreUrl&ua=$userAgent";
                                                        } else {
                                                            $adMacros = $adUrl . "?width=1920&height=1080&cb=$cb&" . (!$isLocalHost ? "uip=$userIP&" : '') . "device_id=RIDA&vast_version=2&app_name=$channelName&device_make=ROKU&device_category=5&app_store_url=$appStoreUrl&ua=$userAgent";
                                                        }

                                                        $adMacros .= "&duration=" . ($stream['duration'] * 60) . "&app_code=" . env('APP_CODE') . '&user_code=' . session('USER_DETAILS.USER_CODE') . '&stream_code=' . $stream['code'];

                                                        $dataVast = "data-vast='$adMacros'";
                                                    }

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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
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
        });

        function unmutedVoice() {
            player.toggleMute();
            player.playMedia();
        }
    </script>
@endpush
