@extends('layouts.app')
@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mvp.css') }}" />
    <script src="{{ asset('assets/js/new.js') }}"></script>
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

        .mvp-skin-sirius .mvp-previous-toggle,
        .mvp-skin-sirius .mvp-next-toggle {
            display: none;
        }
    </style>
@endsection
@section('content')
    @php
        $poster = $stream['app']['stream_details']['stream_poster'];
        $streamUrl = $stream['app']['stream_details']['stream_url'];
        $stream_title = $stream['app']['stream_details']['stream_title'];
        $stream_description = $stream['app']['stream_details']['stream_description'];
        $mType = 'video';
        if ($streamUrl) {
            $isShortYouTube = preg_match('/youtu\.be\/([^?&]+)/', $streamUrl, $shortYouTubeMatches);
            $isSingleVideo = preg_match('/[?&]v=([^&]+)/', $streamUrl, $videoMatches);
            $isVimeo = preg_match('/vimeo\.com\/(\d+)/', $streamUrl, $vimeoMatches);
            if ($isShortYouTube) {
                $streamUrl = $shortYouTubeMatches[1]; // Extract only the video ID
                $mType = 'youtube_single';
            } elseif ($isSingleVideo) {
                $streamUrl = $videoMatches[1]; // Extract only the video ID
                $mType = 'youtube_single';
            } elseif ($isVimeo) {
                $streamUrl = $vimeoMatches[1]; // Extract only the Vimeo ID
                $mType = 'vimeo_single';
            }
        }
        if (strpos($streamUrl, '.m3u8')) {
            $mType = 'hls';
        }
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
                                    <div class="mvp-playlist-item"
                                        data-type="{{ Str::endsWith($streamUrl, ['.mp3', '.wav']) ? 'audio' : $mType }}"
                                        data-noapi
                                        data-path="{{ $streamUrl }}" data-poster="{{ $poster }}"
                                        data-thumb="{{ $poster }}" data-title="{{ $stream_title }}"
                                        data-description="{{ $stream_description }}">
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
    <script src="{{ asset('assets/js/share_manager.js') }}"></script>
    <script src="{{ asset('assets/js/cache.js') }}"></script>
    <script src="{{ asset('assets/js/ima.js') }}"></script>
    <script src="{{ asset('assets/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/youtubeLoader.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/vimeoLoader.js') }}"></script>
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
            console.log(event);

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
                vimeoPlayerType: "chromeless",
                youtubePlayerType: "chromeless",
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
                useAdSeekbar: true,
                mediaEndAction: 'rewind',
                // mediaEndAction: 'poster'
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

            // Track whether playback was initiated by user
            let isUserInitiated = false;
            document.querySelector('.mvp-seekbar').addEventListener('click', () => {
                isUserInitiated = true;
                trackMediaEvent('seek', {
                    seekValue: player.getCurrentTime()
                });
                isUserInitiated = false;
            });
            document.querySelector('.mvp-btn-play').addEventListener('click', () => {
                isUserInitiated = true;
            });
            document.querySelector('.mvp-btn-pause').addEventListener('click', () => {
                isUserInitiated = true;
            });
            document.querySelector('.mvp-volume-wrapper').addEventListener('click', () => {
                isUserInitiated = true;
            });
            document.querySelector('.mvp-volume-seekbar').addEventListener('click', () => {
                isUserInitiated = true;
            });

            player.addEventListener('mediaPlay', (data) => {
                // Only track play events that are user initiated
                if (isUserInitiated) {
                    trackMediaEvent('mediaPlay', data);
                    isUserInitiated = false;
                }

                makeVolumeButtontoggable(); // Fix mute toggle
            });
            player.addEventListener('mediaPause', (data) => {
                if (isUserInitiated) {
                    trackMediaEvent('mediaPause', data);
                    isUserInitiated = false;
                }
            });
            player.addEventListener("fullscreenEnter", (data) => {
                isUserInitiated = true;
                trackMediaEvent('fullscreenEnter', data);
                isUserInitiated = false;
            });
            player.addEventListener("fullscreenExit", (data) => {
                isUserInitiated = true;
                trackMediaEvent('fullscreenExit', data);
                isUserInitiated = false;
            });
            player.addEventListener("volumeChange", (data) => {
                trackMediaEvent('volumeChange', data);
                isUserInitiated = false;
            });
            player.addEventListener('mediaEnd', (data) => {
                isUserInitiated = true;
                trackMediaEvent('mediaEnd', data);
                isUserInitiated = false;
            });

            const originalSeekForward = player.seekForward.bind(player);
            player.seekForward = (value = 10) => {
                isUserInitiated = true; // Explicitly set as user initiated
                originalSeekForward(value);
                trackMediaEvent('seekForward', {
                    seekValue: value
                });
                isUserInitiated = false;
            };
            const originalSeekBackward = player.seekBackward.bind(player);
            player.seekBackward = (value = 10) => {
                isUserInitiated = true; // Explicitly set as user initiated
                originalSeekBackward(value);
                trackMediaEvent('seekBackward', {
                    seekValue: value
                });
                isUserInitiated = false; // Explicitly set as user initiated
            };

            const trackMediaEvent = async (eventType, data) => {
                const localStorageKey = 'hasReloaded';
                try {
                    const payload = {
                        watch_party_code: '{{ $watch_party_code }}',
                        event_type: eventType,
                        instance_name: data?.instanceName || 'player1',
                        is_user_initiated: isUserInitiated,
                        media_data: {
                            current_time: data?.instance?.getCurrentTime() || 0,
                            duration: data?.instance?.getDuration() || 0,
                            counter: data?.counter || null,
                            seek_value: data.seekValue || null,
                            current_volume: data.volume || null,
                        },
                        media_info: data?.media || null
                    };

                    const response = await fetch('/media-events', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify(payload)
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const result = await response.json();
                    // console.log(`${eventType} event tracked successfully:`, result);
                } catch (error) {
                    // console.error(`Error tracking ${eventType} event:`, error);
                }
            };

            let eventEnded = false;
            const localStorageKey = 'hasReloaded';
            const checkEndTime = async () => {
                if (eventEnded) return; // If event has already ended, stop further requests

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
                        showEventEndedDiv();
                        localStorage.setItem(localStorageKey, 'true');
                    }
                } catch (error) {
                    // console.error('Error fetching player state:', error);
                }
            };

            function showEventEndedDiv() {
                const notStartedHtml = `
                            <div class="error-set">
                                <div class="text-white text-center" style="font-size: 10rem; font-weight: 600; line-height: 1em;">
                                    <span class="fs-1">⏳</span>
                                </div>
                                <div class="text-white text-center fs-2">
                                    This Watch Party Has Ended
                                </div>
                                <div class="text-white text-center mt-4">
                                    Thank you for attending!
                                </div>
                            </div>
                        `;

                document.querySelector('.append_div').innerHTML = notStartedHtml;
                localStorage.removeItem(localStorageKey); // Clear the reload flag
                document.getElementById('not_started').style.display = 'block';
                document.getElementById('event-started').style.display = 'none';
                setTimeout(() => {
                    // window.location.href = '/'; // Redirect to homepage
                    localStorage.removeItem(localStorageKey);
                    window.location.href = '/watch/ended-watch-party'; // Redirect to homepage
                }, 3000);
            }

            setInterval(checkEndTime, 30000);






            // Send results if user does not perform any action
            // const updatePlaybackState = async () => {
            //     try {
            //         const payload = {
            //             watch_party_code: '{{ $watch_party_code }}',
            //             event_type: eventType,
            //             instance_name: data?.instanceName || 'player1',
            //             is_user_initiated: isUserInitiated,
            //             media_data: {
            //                 current_time: data?.instance?.getCurrentTime() || 0,
            //                 duration: data?.instance?.getDuration() || 0,
            //                 counter: data?.counter || null,
            //                 seek_value: data.seekValue || null,
            //                 current_volume: data.volume || null,
            //             },
            //             media_info: data?.media || null
            //         };

            //         const response = await fetch('/media-events', {
            //             method: 'POST',
            //             headers: {
            //                 'Content-Type': 'application/json',
            //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
            //                     .getAttribute('content')
            //             },
            //             body: JSON.stringify(payload)
            //         });

            //         if (!response.ok) {
            //             throw new Error(`HTTP error! status: ${response.status}`);
            //         }

            //         const data = await response.json();
            //         if (data.event_ended) {
            //             eventEnded = true;
            //             showEventEndedDiv();
            //             localStorage.setItem(localStorageKey, 'true');
            //         }
            //     } catch (error) {
            //         console.error('Error fetching player state:', error);
            //     }
            // };
            // setInterval(updatePlaybackState, 30000);

        });

        function makeVolumeButtontoggable() {
            $('.mvp-volume-toggle').addClass('mvp-volume-toggable');
        }
    </script>
@endpush
