<div class="owl-wrapper">
    <div class="owl-prev-btn owl-controll-btn" data-type="0" onclick="handleSliderControlls(this)">
        <svg width="37px" height="37px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M17.4142 20.7071C17.8047 20.3166 17.8047 19.6834 17.4142 19.2929L10.1213 12L17.4142 4.70712C17.8047 4.3166 17.8047 3.68343 17.4142 3.29291L16.7071 2.5858C16.3166 2.19528 15.6834 2.19528 15.2929 2.5858L6.93934 10.9394C6.35355 11.5251 6.35355 12.4749 6.93934 13.0607L15.2929 21.4142C15.6834 21.8048 16.3166 21.8048 16.7071 21.4142L17.4142 20.7071Z"
                    fill="#ffffff"></path>
            </g>
        </svg>
    </div>
    <div class="owl-next-btn owl-controll-btn" data-type="1" onclick="handleSliderControlls(this)">
        <svg width="37px" height="37px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M7.20696 20.7071C6.81643 20.3166 6.81643 19.6834 7.20696 19.2929L14.4998 12L7.20696 4.70712C6.81643 4.3166 6.81643 3.68343 7.20696 3.29291L7.91406 2.5858C8.30459 2.19528 8.93775 2.19528 9.32827 2.5858L17.6818 10.9394C18.2676 11.5251 18.2676 12.4749 17.6818 13.0607L9.32828 21.4142C8.93775 21.8048 8.30459 21.8048 7.91406 21.4142L7.20696 20.7071Z"
                    fill="#ffffff"></path>
            </g>
        </svg>
    </div>
    <div class="owl-carousel page-owl-slider">
        @if ($data->app->featured_items->is_show ?? '' == 'Y')
            @foreach ($data->app->featured_items->streams ?? [] as $stream)
                <div>
                    <div class="cover-slider-item">
                        <div class="info {{ isset($stream->title_logo) && $stream->title_logo ? 'with-logo' : 'without-logo' }}">
                            @if (isset($stream->title_logo) && $stream->title_logo)
                                <div class="title_logo mb-1">
                                    <img class="image-fluid" src="{{ $stream->title_logo }}"
                                        alt="{{ $stream->stream_title }}">
                                </div>
                            @else
                                <h1 class="content-heading" title="{{ $stream->stream_title ?? '' }}">
                                    {{ $stream->stream_title ?? '' }}</h1>
                            @endif
                            <div class="timestamp">
                                @if ($stream->released_year)
                                    <span>{{ $stream->released_year ?? '' }}</span>
                                    <span>
                                        <i class="bi bi-dot"></i>
                                    </span>
                                @endif
                                <span>{{ \App\Helpers\GeneralHelper::showDurationInHourAndMins($stream->stream_duration) ?? '' }}</span>
                                <div class="badges">
                                    @if (isset($stream->content_qlt) && !empty($stream->content_qlt))
                                        <span class="badge">{{ $stream->content_qlt }}</span>
                                    @endif
                                    @if (isset($stream->content_rating) && !empty($stream->content_rating))
                                        <span class="badge">{{ $stream->content_rating }}</span>
                                    @endif
                                </div>
                            </div>
                            <p class="description desktop-data">
                                {{ $stream->stream_description ?? '' }}
                            </p>
                            <div class="btns">
                                <a class="app-primary-btn rounded"
                                    href="{{ route('playerscreen', $stream->stream_guid) }}">
                                    <i class="bi bi-play-fill banner-play-icon"></i>
                                    Play
                                </a>
                                <a class="app-secondary-btn rounded"
                                    href="{{ route('detailscreen', $stream->stream_guid) }}">
                                    <i class="bi bi-eye banner-view-icon"></i>
                                    Details
                                </a>
                            </div>
                        </div>
                        <div class="cover">
                            <img src="{{ $stream->feature_poster ?? '' }}" alt="">
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.page-owl-slider').owlCarousel({
                center: true,
                items: 1,
                loop: true,
                smartSpeed: 800,
                // autoplay: true,
                margin: 10,
                stagePadding: 100,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        stagePadding: 0,
                        nav: false,
                    },
                    600: {
                        stagePadding: 0,
                        nav: false,
                    },
                    1000: {
                        stagePadding: 100,
                        nav: true,
                        margin: 20,
                    }
                }
            });
        });

        function handleSliderControlls(e) {
            let type = $(e).data("type");
            let owlWrapper = $(e).parent();
            let prevBtn = $(owlWrapper).find(".owl-prev:eq(0)");
            let nextBtn = $(owlWrapper).find(".owl-next:eq(0)");

            if (type == 0) {
                $(prevBtn).click();
            } else {
                $(nextBtn).click();
            }
        }
    </script>
@endpush
