@extends('layouts.app')

@section('head')
    {{-- Custom Css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/details-screen-styling.css') }}">
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
    <style>
        .video-container {
            height: auto;
            display: grid;
            align-content: center;
        }

        .video-js-responsive-container.vjs-hd {
            padding-top: 56.25%;
        }

        .video-js-responsive-container.vjs-sd {
            padding-top: 75%;
        }

        .video-js-responsive-container {
            width: 100%;
            position: relative;
        }

        .video-js-responsive-container .video-js {
            height: 100% !important;
            width: 100% !important;
            position: absolute;
            top: 0;
            left: 0;
        }

        .vjs-default-skin .vjs-big-play-button {
            top: 50%;
            left: 50%;
            margin: -1em auto auto -41px;
        }
    </style>
@endsection

@section('content')
<div>
    <div class="container">
        <div class="p-4 mt-3">
            <div class="row justify-content-center">
                <div class="col-md-8 mx-auto">
                    <!-- Video.js Player -->
                    <div class="video-container">
                        <div class="video-js-responsive-container vjs-hd">
                            <video id="videoPlayer" class="video-js vjs-default-skin" controls preload="auto">
                                @if(isset($playbackUrl))
                                    <source src="{{ $playbackUrl }}" type="application/x-mpegURL">
                                @endif
                            </video>
                        </div>
                        @if(isset($thumbnail))
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var player = videojs('videoPlayer');
                                    player.poster("{{ $thumbnail }}");
                                });
                            </script>
                        @endif
                        @if(isset($title))
                            <h3 class="content-heading mt-2">{{ $title }}</h3>
                        @endif
                        @if(isset($description))
                            <p class="about_fulltxt mt-2">{{ $description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
