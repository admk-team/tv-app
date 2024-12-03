@section('head')
    <link rel="stylesheet" href="{{ asset('assets/sliders_assets/css/hero_slider.css') }}">
@endsection

<div id="carouselExampleCaptions" class="carousel mb-3" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-indicators">
        @if ($data->app->featured_items->is_show ?? '' == 'Y')
            @foreach ($data->app->featured_items->streams ?? [] as $index => $stream)
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $index }}"
                    @if ($loop->first) class="active" @endif
                    aria-current="{{ $loop->first ? 'true' : 'false' }}"
                    aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        @endif

    </div>
    <div class="carousel-inner">
        @if ($data->app->featured_items->is_show ?? '' == 'Y')
            @foreach ($data->app->featured_items->streams ?? [] as $index => $stream)
                <div class="carousel-item   @if ($loop->first) active @endif">
                    <div class="slider_image">
                        <img src="{{ $stream->feature_poster ?? '' }}" class="d-block" alt="...">
                    </div>
                    <div class="carousel-caption d-block">

                        <div class="travel-info">
                            @if (isset($stream->title_logo) && $stream->title_logo)
                                <div class="title_logo mb-1">
                                    <img style="max-width: 100%" src="{{ $stream->title_logo }}"
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
                                @if ($stream->notify_label == 'no_label')
                                    <a class="app-primary-btn rounded"
                                        href="{{ route('playerscreen', $stream->stream_guid) }}">
                                        <i class="bi bi-play-fill banner-play-icon"></i> Play
                                    </a>
                                @elseif ($stream->notify_label == 'upcoming')
                                    <a class="app-primary-btn rounded">
                                        Upcoming
                                    </a>
                                @else
                                    <a class="app-primary-btn rounded"
                                        href="{{ route('playerscreen', $stream->stream_guid) }}">
                                        <i class="bi bi-play-fill banner-play-icon"></i> Available Now
                                    </a>
                                @endif
                                <a class="app-secondary-btn rounded"
                                    href="{{ route('detailscreen', $stream->stream_guid) }}">
                                    <i class="bi bi-eye banner-view-icon"></i> Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

</div>
@push('scripts')
@endpush
