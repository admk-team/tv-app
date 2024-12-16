@section('head')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    {{--  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">  --}}
    <link rel="stylesheet" href="{{ asset('assets/sliders_assets/css/swiper.css') }}">
@endsection

<div class="parent-container">
    <div class="swiper-container">

        <div class="swiper-wrapper">
            @if ($data->app->featured_items->is_show ?? '' == 'Y')
                @foreach ($data->app->featured_items->streams ?? [] as $stream)
                    <div class="swiper-slide">
                        <img class="thumbnail__image" src="{{ $stream->feature_poster ?? '' }}" alt="">
                        <div
                            class="travel-info {{ isset($stream->title_logo) && $stream->title_logo ? 'with-logo' : 'without-logo' }}">
                            @if (isset($stream->title_logo) && $stream->title_logo)
                                <div class="title_logo mb-1">
                                    <img class="image-fluid" style="max-width: 100%" src="{{ $stream->title_logo }}"
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
                            <p class="description desktop-data">{{ $stream->stream_description ?? '' }}</p>
                            <div class="btns">
                                @if (isset($stream->notify_label) && $stream->notify_label == 'coming soon')
                                    @if (session()->has('USER_DETAILS') && session('USER_DETAILS') !== null)
                                        <form id="remind-form-desktop" method="POST"
                                            action="{{ route('remind.me') }}">
                                            @csrf
                                            <input type="hidden" name="stream_code" id="stream-code"
                                                value="{{ $stream->stream_guid }}">
                                            @if (isset($stream->reminder_set) && $stream->reminder_set == true)
                                                <button class="app-primary-btn rounded p-2">
                                                    <i class="fas fa-check-circle"></i> Reminder set
                                                </button>
                                            @else
                                                <button class="app-primary-btn rounded p-2">
                                                    <i class="fas fa-bell"></i> Remind me
                                                </button>
                                            @endif
                                        </form>
                                    @else
                                        <a class="app-primary-btn rounded">
                                            <i class="fa fa-play"></i>
                                            Coming Soon
                                        </a>
                                    @endif
                                @else
                                    <a class="app-primary-btn rounded"
                                        href="{{ route('playerscreen', $stream->stream_guid) }}">
                                        <i class="bi bi-play-fill banner-play-icon"></i> Play
                                    </a>
                                @endif
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
            autoplay: true,
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
