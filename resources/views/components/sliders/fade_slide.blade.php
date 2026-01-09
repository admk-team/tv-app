@section('head')
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="{{ asset('assets/sliders_assets/css/fade.css') }}">
@endsection

<div class="w3-content">
    @if ($data->app->featured_items->is_show ?? '' == 'Y')
        @foreach ($data->app->featured_items->streams ?? [] as $index => $stream)
            <div class="mySlides w3-animate-fading" style="width:100%;display:none; position: relative;">
                <img class="mySlides-img" src="{{ $stream->feature_poster ?? '' }}" alt="loading">
                <div class="travel-info">
                    @if (isset($stream->title_logo, $stream->show_title_logo) && $stream->title_logo && $stream->show_title_logo == 1)
                        <div class="title_logo mb-1">
                            <img class="image-fluid" src="{{ $stream->title_logo }}" alt="{{ $stream->stream_title }}">
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
                        @if ($stream->stream_duration)
                            <span>{{ \App\Helpers\GeneralHelper::showDurationInHourAndMins($stream->stream_duration) ?? '' }}</span>
                        @endif
                        @if (isset($stream->totalseason) && $stream->totalseason != null)
                            <span>{{ $stream->totalseason ?? '' }}</span>
                        @endif
                        <div class="badges">
                            @if (isset($stream->content_qlt) && !empty($stream->content_qlt))
                                <span class="badge">{{ $stream->content_qlt }}</span>
                            @endif
                            @if (isset($stream->content_rating) && !empty($stream->content_rating))
                                <span class="badge">{{ $stream->content_rating }}</span>
                            @endif
                            @if (isset($stream->views) && $stream->views > 0)
                                <span class="content_screen" style="margin-left: 8px;">
                                    <i class="bi bi-eye" style="margin-right: 4px;"></i>
                                    {{ number_format($stream->views) }} {{ $stream->views == 1 ? 'view' : 'views' }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <p class="description desktop-data">{{ $stream->stream_description ?? '' }}</p>
                    <div class="btns">
                        @if (isset($stream->notify_label) && $stream->notify_label == 'coming soon')
                            @if (session()->has('USER_DETAILS') && session('USER_DETAILS') !== null)
                                <form id="remind-form-desktop" method="POST" action="{{ route('remind.me') }}">
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
                                href="{{ route('playerscreen', $stream->contentType === 'series' ? $stream->episode_code : $stream->stream_guid) }}">
                                <i class="bi bi-play-fill banner-play-icon"></i> Play
                            </a>
                        @endif
                        @php
                            $screen =
                                isset($stream->contentType) && $stream->contentType === 'series'
                                    ? 'series'
                                    : 'detailscreen';
                        @endphp
                        <a class="app-secondary-btn rounded" href="{{ route($screen, $stream->stream_guid) }}">
                            <i class="bi bi-eye banner-view-icon"></i>
                            Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <div class="w3-row-padding w3-section d-flex align-items-center justify-content-center">
        @if ($data->app->featured_items->is_show ?? '' == 'Y')
            @foreach ($data->app->featured_items->streams ?? [] as $index => $stream)
                <div class="w3-col s3">
                    <img class="demo w3-opacity w3-hover-opacity-off" src="{{ $stream->feature_poster ?? '' }}"
                        style="width:100%;cursor:pointer; margin-top: 14px;" onclick="currentDiv({{ $index + 1 }})"
                        alt="loading">
                </div>
            @endforeach
        @endif
    </div>
</div>

@push('scripts')
    <script>
        var slideIndex = 0;
        var myIndex = 0;
        var carouselTimeout;

        carousel();
        showDivs(slideIndex);

        function currentDiv(n) {
            clearTimeout(carouselTimeout);
            showDivs(slideIndex = n);
            carouselTimeout = setTimeout(carousel, 9000); // Restart the carousel after user interaction
        }

        function showDivs(n) {
            var i;
            var x = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("demo");
            if (n > x.length) {
                slideIndex = 1;
            }
            if (n < 1) {
                slideIndex = x.length;
            }
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
            }
            x[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " w3-opacity-off";
        }

        function carousel() {
            var i;
            var x = document.getElementsByClassName("mySlides");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            myIndex++;
            if (myIndex > x.length) {
                myIndex = 1;
            }
            x[myIndex - 1].style.display = "block";
            var dots = document.getElementsByClassName("demo");
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
            }
            dots[myIndex - 1].className += " w3-opacity-off";
            slideIndex = myIndex;
            carouselTimeout = setTimeout(carousel, 9000);
        }
    </script>
@endpush
