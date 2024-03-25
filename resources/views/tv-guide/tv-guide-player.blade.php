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
        $arrRes; //coming from controller
        $channelGuid; //coming from controller
        $ARR_FEED_DATA = \App\Helpers\GeneralHelper::parseMainFeedArrData__TVGuide(0, $arrRes);
        $channels = $ARR_FEED_DATA['arrChannelsData'];
        $epgArr = [];
        foreach ($channels as $key => $channel) {
            if ($channel->id == $channelGuid) {
                $epgArr = $channel->epg;
                break;
            }
        }
        // @dd($epgArr);
        if (isset($_COOKIE['timezoneStr']) && !empty($_COOKIE['timezoneStr'])) {
            date_default_timezone_set($_COOKIE['timezoneStr']);
        } else {
            date_default_timezone_set('America/New_York');
        }
        $curUnixTime = date('U');
        $adUrl = \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_site_ad_url;

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

        $adMacros =
            $adUrl .
            "&width=1920&height=1080&cb=$cb" .
            (!$isLocalHost ? "&uip=$userIP" : '') .
            "&device_id=RIDA&vast_version=2&app_name=$channelName&device_make=ROKU&device_category=5&app_store_url=$appStoreUrl&ua=$userAgent";
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
                                    $cnt = 0;
                                    $leftTime = 0;
                                @endphp
                                @foreach ($epgArr as $epgData)
                                    = @if ($curUnixTime <= strtotime($epgData->end_date_time_utc))
                                        @php
                                            if ($cnt == 0) {
                                                $leftTime = $curUnixTime - strtotime($epgData->start_date_time_utc);
                                            }

                                            $poster = $epgData->poster;
                                            $videoUrl = $epgData->url;
                                            $quality = 'video';
                                            if (strpos($videoUrl, '.m3u8')) {
                                                $quality = 'hls';
                                            }
                                            $cnt++;

                                            $dataVast = 'data-vast="' . url('/get-ad') . '"';
                                            $dataVast = "data-vast='$adMacros'";
                                            if ($adUrl == '') {
                                                $dataVast = '';
                                            }
                                        @endphp
                                        <div class="mvp-playlist-item" data-preview-seek="auto"
                                            data-type="{{ $quality }}" data-path="{{ $videoUrl }}"
                                            {!! $dataVast !!} data-poster="{{ $poster }}"
                                            data-thumb="{{ $poster }}" data-title="{{ $epgData->title }}"
                                            data-description="{{ $epgData->description }}"></div>
                                    @endif
                                @endforeach
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
                useImaLoader: false,
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
