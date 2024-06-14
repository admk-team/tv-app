@section('head')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="{{ asset('assets/sliders_assets/css/swiper.css') }}">
@endsection

<div class="parent-container">
    <div class="swiper-container">

        <div class="swiper-wrapper">
            @if ($data->app->featured_items->is_show ?? '' == 'Y')
                @foreach ($data->app->featured_items->streams ?? [] as $stream)
                    <div class="swiper-slide w3-animate-fading">
                        <img class="thumbnail__image" src="{{ $stream->feature_poster ?? '' }}" alt="">
                        <div class="travel-info">
                            <h1 class="content-heading" title="{{ $stream->stream_title ?? '' }}">
                                {{ $stream->stream_title ?? '' }}
                            </h1>
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
                            <p class="description">{{ $stream->stream_description ?? '' }}</p>
                            <div class="btns">
                                <a class="app-primary-btn rounded"
                                    href="{{ route('playerscreen', $stream->stream_guid) }}">
                                    <i class="bi bi-play-fill banner-play-icon"></i> Play
                                </a>
                                <a class="app-secondary-btn rounded"
                                    href="{{ route('detailscreen', $stream->stream_guid) }}">
                                    <i class="bi bi-eye banner-view-icon"></i> Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        </div>
    <div class="swiper-pagination"></div>
</div>
@push('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper-container', {
            slidesPerView: 2,
            spaceBetween: 10,
            autoplay:true,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    centeredSlides: true,
                    spaceBetween: 10,
                    navigation: false,
                },
                600: {
                    slidesPerView: 1,
                    centeredSlides: true,
                    spaceBetween: 10,
                    navigation: false,
                },
                1200: {
                    slidesPerView: 2,
                    centeredSlides: true,
                    spaceBetween: 10,
                    navigation: false,
                }
            }
        });
    </script>
@endpush
