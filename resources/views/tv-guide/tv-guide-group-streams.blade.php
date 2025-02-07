
@extends('layouts.app')
@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mvp.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mvp/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mvp/mvp.css') }}" />
    <script src="{{ asset('assets/js/new.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/new.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        .videocentalize {
            position: relative;
        }

        .videocentalize {
            max-width: 1000px;
            width: 100%;
            text-align: center;
            margin: 0px auto;
        }
    </style>
@endsection
@section('content')
  <div class="container-fluid containinax">
            <div class="row">
                <div class="col-md-12">
                    <div class="videocentalize">
                        <div id="wrapper"></div>
                        <div id="mvp-playlist-list">
                            <div class="mvp-global-playlist-data"></div>
                            <div class="playlist-video">
                                    @foreach ($decryptedStreams as $stream)
                                        <div class="mvp-playlist-item" data-type="hls" data-path="{{ $stream['url'] }}"
                                            data-poster="{{ $stream['poster'] }}" data-thumb="{{ $stream['poster'] }}"
                                            data-title="{{ $stream['title'] }}" data-description="{{ $stream['title'] }}">
                                        </div>
                                    @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
@push('scripts')
    <script src="{{ asset('assets/js/share_manager.js') }}"></script>
    <script src="{{ asset('assets/js/cache.js') }}"></script>
    <script src="{{ asset('assets/js/ima.js') }}"></script>
    <script src="{{ asset('assets/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/share_manager.js') }}"></script>
    <script src="{{ asset('assets/js/cache.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/ima.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/perfect-scrollbar.min.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
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
            var isshowlist = true
            var pListPostion = 'vrb';
            if (detectMob()) {
                var pListPostion = 'hb';
            }
            var settings = {

                skin: 'sirius', //aviva, polux, sirius
                playlistPosition: pListPostion, //vrb, vb, hb, no-playlist, outer, wall
                sourcePath: "",
                useMobileChapterMenu: true,
                activeItem: 0, //active video to start with
                activePlaylist: ".playlist-video",
                playlistList: "#mvp-playlist-list",
                instanceName: "player1",
                hidePlaylistOnMinimize: true,
                volume: 0.75,
                // useShare: true,
                autoPlay: true,
                crossorigin: "link",
                playlistOpened: false,
                randomPlay: false,
                usePlaylistToggle: isshowlist,
                useEmbed: true,
                useTime: true,
                usePip: true, //picture in picture
                useCc: true, //caption toggle
                useAirPlay: true,
                usePlaybackRate: true,
                useNext: true,
                usePrevious: true,
                useRewind: true,
                useSkipBackward: true,
                useSkipForward: true,
                showPrevNextVideoThumb: true,
                rememberPlaybackPosition: 'all', //remember last video position (false, 1, all)
                useQuality: true,
                useImaLoader: true,
                useTheaterMode: true,
                focusVideoInTheater: true,
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
                disableVideoSkip: false,
                useAdSeekbar: true,
                useAdControls: true,
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
            if (!window.player) {
                window.player = new mvp(document.getElementById('wrapper'), settings);
            }


            player.addEventListener('mediaStart', function(data) {
                data.instance.getCurrentTime();
                data.instance.getDuration();
                makeVolumeButtontoggable(); // Fix mute toggle
            });

            player.addEventListener("mediaPause", function(data) {});
            player.addEventListener("mediaEnd", function(data) {});
        });

        function makeVolumeButtontoggable() {
            $('.mvp-volume-toggle').addClass('mvp-volume-toggable');
        }
    </script>
@endpush
