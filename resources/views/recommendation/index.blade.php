@extends('layouts.app')

@section('content')
    <section class="sliders topSlider gridSection pt-4">
        <style type="">
            .col-xl-3 {
                float: left;
            }

            .heading {
                color: var(--themeActiveColor);
                font-weight: bold;
            }
            .recommended {
                color: rgb(238, 238, 238);
                font-size: 10px; /* Makes text smaller */
                max-height: 50px; /* Limit height */
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 2; /* Limit to 2 lines */
                -webkit-box-orient: vertical;
                white-space: normal;
            }
            
        </style>
        <div class="slider-container">
            <div class="listing_box allVideosBox">
                @if (!empty($recommendation))
                    <div class="col-md-12">
                        <div class="list_heading">
                            <h1>{{ $recommendation['title'] ?? 'Friends Recommendation' }}</h1>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="innerAlVidBox">

                            <div id="data-container">
                            </div>
                            <div class="form-group text-center mb-4">
                                <button class="auth app-secondary-btn rounded" id="load-more-btn">Load More</button>
                            </div>

                        </div>
                    </div>
                @else
                    <section class="container">
                        <div class="container py-5 mb-5">
                            <h1 class="heading text-center mb-4">Friends Recommendation</h1>
                            <div class="d-flex justify-content-center mt-4 mb-4">
                                <h4 class="heading text-center">No record available at the moment. Please check back later.
                                </h4>
                            </div>
                        </div>
                    </section>
                @endif
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            var data = {!! json_encode($recommendation) !!};
            console.log(data);
            var bypassDetailscreen = {!! json_encode(\App\Services\AppConfig::get()->app->app_info->bypass_detailscreen) !!};
            var currentIndex = 0;
            var batchSize = 20;

            // Determine the screen based on bypass_detailscreen condition using Blade


            // Function to load more data in batches
            function loadMoreData() {
                var streams = data.streams.slice(currentIndex, currentIndex + batchSize);

                streams.forEach(function(stream) {
                    var screenRoute;

                    if (bypassDetailscreen === 1 || stream.bypass_detailscreen === 1) {
                        screenRoute = "{{ route('playerscreen', ':id') }}";
                    } else if (stream.contentType === 'series') {
                        screenRoute = "{{ route('series', ':id') }}";
                    } else if (stream.stream_type == 'BC') {
                        screenRoute = "{{ route('content-bundle', ':id') }}";
                    } else {
                        screenRoute = "{{ route('detailscreen', ':id') }}";
                    }
                    // Generate URL by replacing the placeholder with the stream's GUID
                    var url = screenRoute.replace(':id', stream.stream_guid);

                    if (stream.stream_type === 'A') {
                        url = stream.stream_promo_url;
                        if (stream.is_external_ad === 'N') {
                            url = `${screenRoute}/${stream.stream_promo_url}`;
                        }
                    }

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
                                            ${stream.stream_episode_title && stream.stream_episode_title !== 'NULL' ?
                                            stream.stream_episode_title : ''}
                                        </div>
                                        <div class="content_title">${stream.stream_title}</div>
                                        <div class="content_description">${stream.stream_description}</div>
                                        <div class="recommended">Recommended by: ${stream.recommended_by}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                `);
                });

                currentIndex += batchSize;

                // Hide load-more button when streams length is completed
                if (currentIndex >= data.streams.length) {
                    $('#load-more-btn').hide();
                }

                // Show message if no video available
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

            // Initial load
            loadMoreData();
        });
    </script>
@endpush
