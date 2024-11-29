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
    </script>
@endpush
@section('content')
    <div class="top_gaps">
        <div class="container-fluid containinax">
            <div class="row">
                <div class="col-md-12">
                    <div class="videocentalize">
                        <div id="wrapper"></div>
                        <div id="mvp-playlist-list">
                            <div class="mvp-global-playlist-data"></div>
                            <div class="playlist-video">
                                @foreach ($streams as $stream)
                                    <div class="mvp-playlist-item" data-type="hls" data-preview-seek="auto" data-type="m3u8"
                                        data-path="{{ $stream['url'] }}" data-title="{{ $stream['title'] }}"></div>
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

            player.addEventListener('mediaStart', function(data) {

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
