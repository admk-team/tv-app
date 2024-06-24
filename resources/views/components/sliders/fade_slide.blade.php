@section('head')
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="{{ asset('assets/sliders_assets/css/fade.css') }}">
@endsection

<div class="w3-content">
    @if ($data->app->featured_items->is_show ?? '' == 'Y')
        @foreach ($data->app->featured_items->streams ?? [] as $index => $stream)
            <div class="mySlides w3-animate-fading" style="width:100%;display:none; position: relative;">
                <img src="{{ $stream->feature_poster ?? '' }}" alt="loading">
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
                        <a class="app-primary-btn rounded" href="{{ route('playerscreen', $stream->stream_guid) }}">
                            <i class="bi bi-play-fill banner-play-icon"></i> Play
                        </a>
                        <a class="app-secondary-btn rounded" href="{{ route('detailscreen', $stream->stream_guid) }}">
                            <i class="bi bi-eye banner-view-icon"></i> Details
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
