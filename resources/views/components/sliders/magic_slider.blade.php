@section('head')
    <link rel="stylesheet" href="{{ asset('assets/sliders_assets/css/magic.css') }}">
@endsection

<div class="carousel mb-3">
    <!-- list item -->
    <div class="list">

        @if ($data->app->featured_items->is_show ?? '' == 'Y')
            @foreach ($data->app->featured_items->streams ?? [] as $stream)
                <div class="item">
                    <img src="{{ $stream->feature_poster ?? '' }}">
                    <div
                        class="travel-info {{ isset($stream->title_logo, $stream->show_title_logo) && $stream->title_logo && $stream->show_title_logo === 1 ? 'with-logo' : 'without-logo' }}">
                        @if (isset($stream->title_logo, $stream->show_title_logo) && $stream->title_logo && $stream->show_title_logo == 1)
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
    </div>

    <div class="thumbnail">
        @if ($data->app->featured_items->is_show ?? '' == 'Y')
            @foreach ($data->app->featured_items->streams ?? [] as $stream)
                <div class="item">
                    <img src="{{ $stream->feature_poster ?? '' }}">
                    <div class="content">
                        <div class="title">
                            {{ $stream->stream_title ?? '' }}
                        </div>
                        {{--  <div class="description">
                    Description
                </div>  --}}
                    </div>
                </div>
            @endforeach
        @endif

    </div>
    <!-- next prev -->

    <div class="arrows">
        <button id="prev">
            < </button>
                <button id="next"> > </button>
    </div>

    <!-- time running -->
    <div class="time"></div>
</div>
@push('scripts')
    <script>
        //step 1: get DOM
        let nextDom = document.getElementById('next');
        let prevDom = document.getElementById('prev');

        let carouselDom = document.querySelector('.carousel');
        let SliderDom = carouselDom.querySelector('.carousel .list');
        let thumbnailBorderDom = document.querySelector('.carousel .thumbnail');
        let thumbnailItemsDom = thumbnailBorderDom.querySelectorAll('.item');
        let timeDom = document.querySelector('.carousel .time');

        thumbnailBorderDom.appendChild(thumbnailItemsDom[0]);
        let timeRunning = 3000;
        let timeAutoNext = 7000;

        nextDom.onclick = function() {
            showSlider('next');
        }

        prevDom.onclick = function() {
            showSlider('prev');
        }
        let runTimeOut;
        let runNextAuto = setTimeout(() => {
            next.click();
        }, timeAutoNext)

        function showSlider(type) {
            let SliderItemsDom = SliderDom.querySelectorAll('.carousel .list .item');
            let thumbnailItemsDom = document.querySelectorAll('.carousel .thumbnail .item');

            if (type === 'next') {
                SliderDom.appendChild(SliderItemsDom[0]);
                thumbnailBorderDom.appendChild(thumbnailItemsDom[0]);
                carouselDom.classList.add('next');
            } else {
                SliderDom.prepend(SliderItemsDom[SliderItemsDom.length - 1]);
                thumbnailBorderDom.prepend(thumbnailItemsDom[thumbnailItemsDom.length - 1]);
                carouselDom.classList.add('prev');
            }
            clearTimeout(runTimeOut);
            runTimeOut = setTimeout(() => {
                carouselDom.classList.remove('next');
                carouselDom.classList.remove('prev');
            }, timeRunning);

            clearTimeout(runNextAuto);
            runNextAuto = setTimeout(() => {
                next.click();
            }, timeAutoNext)
        }
    </script>
@endpush
