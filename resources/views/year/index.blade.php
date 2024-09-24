@extends('layouts.app')

@section('content')
    <section class="sliders topSlider gridSection pt-4">
        <style type="">
            .col-xl-3 {
                float: left;
            }
        </style>
        <div class="slider-container">
            <div class="listing_box allVideosBox">
                <div class="col-md-12">
                    <div class="list_heading">
                        <h1>{{ $year }}</h1>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="innerAlVidBox">
                        <div id="data-container">
                            {{-- Data will be loaded here --}}
                        </div>
                        {{-- @foreach ($streams as $stream)
                            <div class="resposnive_Box">
                                <a href="{{ route('detailscreen', $stream['stream_guid']) }}">
                                    <div class="thumbnail_img">
                                        <div class="trending_icon_box" style="display: none;"><img
                                                src="{{ asset('assets/images/trending_icon.png') }}" alt="Trending">
                                        </div>
                                        <img src="{{ $stream['stream_poster'] }}"
                                            alt="{{ $stream['stream_title'] }}">
                                        <div class="detail_box_hide">
                                            <div class="detailbox_time">{{ $stream['stream_duration_timeformat'] }}</div>
                                            <div class="deta_box">
                                                <div class="season_title">{{ $stream['stream_episode_title'] && $stream['stream_episode_title'] !== 'NULL'? $stream['stream_episode_title']: '' }}</div>
                                                <div class="content_title">{{ $stream['stream_title'] }}</div>
                                                <div class="content_description">{{ $stream['stream_description'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach --}}
                        <div class="form-group text-center mb-4">
                            <button class="auth app-secondary-btn rounded" id="load-more-btn">Load More</button>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-12" style="float: left;">
                    <div class="ajax-load text-center spinLoad text-white" style="display: none;">No more videos found!
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        var data = {!! json_encode($streams) !!};  // Convert streams data to JSON
        var bypassDetailscreen = {!! json_encode(\App\Services\AppConfig::get()->app->app_info->bypass_detailscreen) !!};  // Get bypass detailscreen setting

        var currentIndex = 0;
        var batchSize = 20;

        // Function to load more data in batches
        function loadMoreData() {
            var streams = data.slice(currentIndex, currentIndex + batchSize);

            streams.forEach(function(stream) {
                // Determine the screen based on bypass_detailscreen condition
                var screenRoute = bypassDetailscreen == 1 || stream.bypass_detailscreen == 1 
                    ? "{{ route('playerscreen', ':id') }}" 
                    : "{{ route('detailscreen', ':id') }}";

                // Replace placeholder ':id' with the actual stream_guid
                var url = screenRoute.replace(':id', stream.stream_guid);

                // If stream_type is 'A', handle promo URL logic
                if (stream.stream_type === 'A') {
                    url = stream.stream_promo_url;
                    if (stream.is_external_ad === 'N') {
                        url = `${screenRoute}/${stream.stream_promo_url}`;
                    }
                }

                // Append stream information to the container
                $('#data-container').append(`
                    <div class="resposnive_Box">
                        <a href="${url}">
                            <div class="thumbnail_img">
                                <div class="trending_icon_box" style="display: none;">
                                    <img src="{{ asset('assets/images/trending_icon.png') }}" alt="Trending">
                                </div>
                                <img src="${stream.stream_poster}" alt="${stream.stream_title}">
                                <div class="detail_box_hide">
                                    <div class="detailbox_time">${stream.stream_duration_timeformat}</div>
                                    <div class="deta_box">
                                        <div class="season_title">
                                            ${stream.stream_episode_title && stream.stream_episode_title !== 'NULL' ? stream.stream_episode_title : ''}
                                        </div>
                                        <div class="content_title">${stream.stream_title}</div>
                                        <div class="content_description">${stream.stream_description}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                `);
            });

            currentIndex += batchSize;

            // Hide the load-more button when all streams are loaded
            if (currentIndex >= data.length) {
                $('#load-more-btn').hide();
            }

            // Show message if no videos are available
            if (streams.length === 0) {
                $('#load-more-btn').hide();
                $('#data-container').append(`
                    <div>
                        <h1 class="text-center text-white">No videos found</h1>
                    </div>
                `);
            }
        }

        // Load more data when the button is clicked
        $('#load-more-btn').on('click', function() {
            loadMoreData();
        });

        // Initial data load
        loadMoreData();
    });
</script>

@endpush
