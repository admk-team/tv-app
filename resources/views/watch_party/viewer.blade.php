@extends('layouts.app')
@section('head')
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mvp.css') }}" /> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mvp/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mvp/mvp.css') }}" />
    {{-- <script src="{{ asset('assets/js/new.js') }}"></script> --}}
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
    @php
        $poster = $stream['app']['stream_details']['stream_poster'];
        $stream_url = $stream['app']['stream_details']['stream_url'];
        $stream_title = $stream['app']['stream_details']['stream_title'];
        $stream_description = $stream['app']['stream_details']['stream_description'];
    @endphp
    <div id="not_started">
        <section class="watch-party"
            style="background: url(https://admk.24flix.tv/images/oops.gif) no-repeat; background-size: cover; background-position:center;height: 100vh;">
            <div class="container">
                <div class="row align-items-center justify-content-center pt-5 hts-100 append_div">
                    {{-- <div class="error-set">
                        <div class="text-white text-center" style="font-size: 10rem; font-weight: 600; line-height: 1em;">
                            <span class="fs-1">⏳</span>
                        </div>
                        <div class="text-white text-center fs-2">
                            This Watch Party Hasn't Started Yet
                        </div>
                        <div class="text-white text-center">
                            The event will begin at {{ $startDateTime }}.
                        </div>
                        <div class="text-white text-center mt-4">
                            Please check back when the event starts.
                        </div>
                        <div class="text-white text-center mt-4">
                            <div id="countdown"></div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </section>
    </div>
    <div id="event-started" style="display: none;">
        <div class="container">
            <div class="container-fluid containinax" id="containinax">
                <div class="row">
                    <div class="col-md-12 p-3">
                        <div class="videocentralize">
                            <div id="wrapper"></div>
                            <div id="mvp-playlist-list">
                                <div class="mvp-global-playlist-data"></div>
                                <div class="playlist-video">
                                    <div class="mvp-playlist-item" data-type="hls" data-path="{{ $stream_url }}"
                                        data-poster="{{ $poster }}" data-thumb="{{ $poster }}"
                                        data-title="{{ $stream_title }}" data-description="{{ $stream_description }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- <script src="{{ asset('assets/js/share_manager.js') }}"></script>
    <script src="{{ asset('assets/js/cache.js') }}"></script>
    <script src="{{ asset('assets/js/ima.js') }}"></script>
    <script src="{{ asset('assets/js/perfect-scrollbar.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/mvp/share_manager.js') }}"></script>
    <script src="{{ asset('assets/js/cache.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/ima.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/perfect-scrollbar.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var startDateTime = '{{ $startDateTime }}';
            var startDate = new Date(startDateTime);
            var watchPartyCode = '{{ $watch_party_code }}';
            var localStorageKey = `hasReloaded_${watchPartyCode}`;
            var hasReloaded = localStorage.getItem(localStorageKey) === 'true';
            var isEventStarted = false;

            console.log('startDateTime:', startDateTime);
            console.log('Start Date Object:', startDate);

            function formatDateTime(date) {
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    timeZoneName: 'short',
                };
                return date.toLocaleDateString('en-US', options);
            }

            function updateNotStartedContent() {
                const notStartedHtml = `
                        <div class="error-set">
                            <div class="text-white text-center" style="font-size: 10rem; font-weight: 600; line-height: 1em;">
                                <span class="fs-1">⏳</span>
                            </div>
                            <div class="text-white text-center fs-2">
                                This Watch Party Hasn't Started Yet
                            </div>
                            <div class="text-white text-center">
                                The event will begin at ${formatDateTime(startDate)}
                            </div>
                            <div class="text-white text-center mt-4">
                                Please check back when the event starts.
                            </div>
                            <div class="text-white text-center mt-4">
                                <div id="countdown" class="fs-2 fw-bold"></div>
                            </div>
                        </div>
                    `;
                document.querySelector('.append_div').innerHTML = notStartedHtml;
            }

            updateNotStartedContent();

            if (hasReloaded) {
                document.getElementById('not_started').style.display = 'none';
                document.getElementById('event-started').style.display = 'block';
                return; // Exit early
            }

            function updateCountdown() {
                var currentTime = new Date();
                var timeDifference = startDate - currentTime;

                if (timeDifference <= 0 && !isEventStarted) {
                    document.getElementById('not_started').style.display = 'none';
                    document.getElementById('event-started').style.display = 'block';

                    if (!hasReloaded) {
                        localStorage.setItem(localStorageKey, 'true'); // Use event-specific key
                        location.reload();
                    }

                    isEventStarted = true;
                } else if (timeDifference > 0) {
                    var seconds = Math.floor(timeDifference / 1000);
                    var minutes = Math.floor(seconds / 60);
                    var hours = Math.floor(minutes / 60);
                    minutes = minutes % 60;
                    seconds = seconds % 60;

                    document.getElementById('countdown').textContent =
                        hours + "h " + minutes + "m " + seconds + "s";
                }
            }

            updateCountdown();

            setInterval(updateCountdown, 1000);
        });

        // Clear reload flag when leaving page if event hasn't started
        window.addEventListener('beforeunload', function() {
            if (!isEventStarted) {
                localStorage.removeItem(localStorageKey); // Use event-specific key
            }
        });
    </script>
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
                autoPlay: false,
                crossorigin: "link",
                playlistOpened: false,
                randomPlay: false,
                useEmbed: false,
                useTime: false,
                usePip: true, //picture in picture
                useCc: true, //caption toggle
                useAirPlay: false,
                usePlaybackRate: true,
                useNext: false,
                usePrevious: false,
                useRewind: false,
                useSkipBackward: false,
                useSkipForward: false,
                showPrevNextVideoThumb: false,
                useQuality: true,
                useImaLoader: false,
                useTheaterMode: false,
                focusVideoInTheater: false,
                focusVideoInTheater: false,
                hidePlaylistOnTheaterEnter: true,
                useSubtitle: true,
                useTranscript: false,
                useChapterToggle: false,
                useCasting: true,
                useAdSeekbar: true,
                useShare: false,
                useInfo: false,
                disableSeekbar: true,
                disableVideoSkip: true,
                togglePlaybackOnMultipleInstances: true,
                autoPlay: false,
                elementsVisibilityArr: [{
                        width: 2400,
                        elements: []
                    } // Empty array hides all controls
                ]
            };
            if (!window.player) {
                window.player = new mvp(document.getElementById('wrapper'), settings);
            }
            document.querySelector(".videocentralize").style.pointerEvents = "none";

            // const pauseHandler = function(data) {
            //     player.playMedia();
            // };
            // player.addEventListener("mediaPause", pauseHandler);

            let currentState = {};
            const fetchPlayerState = async () => {
                try {
                    const response = await fetch('/watch-party/latest-player-state', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                    });
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        const data = await response.json();
                        console.log(data.event_type);

                        if (data) {
                            switch (data.event_type) {
                                // case 'mediaStart':
                                // console.log(player);
                                // player.playMedia();
                                // break;

                                case 'mediaPause':
                                    player.seek(Math.floor(data.current_time));
                                    player.pauseMedia();
                                    break;

                                case 'mediaPlay':
                                    player.seek(Math.floor(data.current_time));
                                    player.playMedia();
                                    break;

                                case 'seek':
                                    player.seek(Math.floor(data.seek_value));
                                    player.playMedia();
                                    break;

                                case 'seekForward':
                                    player.seekForward(Math.floor(data.seek_value) || 10);
                                    player.playMedia();
                                    break;

                                case 'seekBackward':
                                    player.seekBackward(Math.floor(data.seek_value) || 10);
                                    player.playMedia();
                                    break;

                                case 'volumeChange':
                                    player.setVolume(data.current_volume);
                                    player.playMedia();
                                    break;

                                case 'mediaEnd':
                                    player.seek(Math.floor(data.current_time));
                                    player.playMedia();
                                    break;

                                default:
                                    console.log(`Unhandled event: ${data.event_type}`);
                            }

                            currentState = data;
                        }
                    } else {
                        console.error('Response is not JSON:', await response.text());
                    }
                } catch (error) {
                    console.error('Error fetching player state:', error);
                }
            };
            setInterval(fetchPlayerState, 30000);


            let eventEnded = false;
            const checkEndTime = async () => {
                if (eventEnded) return;
                try {
                    const payload = {
                        watch_party_code: '{{ $watch_party_code }}',
                    };
                    const response = await fetch('/watch-party/check-expire-time', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify(payload)
                    });

                    const data = await response.json();
                    if (data.event_ended) {
                        eventEnded = true;
                        window.location.href = '/watch/ended-watch-party'; // Redirect to homepage
                    }
                } catch (error) {
                    console.error('Error fetching player state:', error);
                }
            };

            setInterval(checkEndTime, 5000);

            const interval = setInterval(checkEndTime, 5000);
            if (eventEnded) {
                clearInterval(interval);
            }


        });
    </script>
@endpush