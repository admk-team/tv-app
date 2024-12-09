@section('head')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="{{ asset('assets/sliders_assets/css/animation.css') }}">
@endsection
<link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
<div id="content">
    <div id="slider">
        @if ($data->app->featured_items->is_show ?? '' == 'Y')
            @foreach ($data->app->featured_items->streams ?? [] as $index => $stream)
                <img src="{{ $stream->feature_poster ?? '' }}" alt="{{ $stream->stream_title }}"
                    data-url="{{ route('playerscreen', $stream->stream_guid) }}">
                <div class="travel-info" @if (!$loop->first) style="display: none;" @endif>
                    @if (isset($stream->title_logo) && $stream->title_logo)
                        <div class="title_logo mb-1">
                            <img class="image-fluid ignore" style="max-width: 100%" src="{{ $stream->title_logo }}"
                                alt="{{ $stream->stream_title }}">
                        </div>
                    @else
                        <h1 class="content-heading" title="{{ $stream->stream_title ?? '' }}">
                            {{ $stream->stream_title ?? '' }}
                        </h1>
                    @endif
                    <div class="timestamp">
                        @if ($stream->released_year)
                            <span>{{ $stream->released_year ?? '' }}</span>
                            <span><i class="bi bi-dot"></i></span>
                        @endif
                        <span>{{ \App\Helpers\GeneralHelper::showDurationInHourAndMins($stream->stream_duration) ?? '' }}</span>
                        <div class="badges">
                            @if (!empty($stream->content_qlt))
                                <span class="badge">{{ $stream->content_qlt }}</span>
                            @endif
                            @if (!empty($stream->content_rating))
                                <span class="badge">{{ $stream->content_rating }}</span>
                            @endif
                        </div>
                    </div>
                    <p class="description desktop-data">{{ $stream->stream_description ?? '' }}</p>
                    <div class="btns">
                        @if (isset($stream->notify_label) && $stream->notify_label == 'available now')
                                    <a class="app-primary-btn rounded"
                                        href="{{ route('playerscreen', $stream->stream_guid) }}">
                                        <i class="bi bi-play-fill banner-play-icon"></i> Available Now
                                    </a>
                                @elseif (isset($stream->notify_label) && $stream->notify_label == 'coming soon')
                                    <a class="app-primary-btn rounded">
                                        Coming Soon
                                    </a>
                                @else
                                    <a class="app-primary-btn rounded"
                                        href="{{ route('playerscreen', $stream->stream_guid) }}">
                                        <i class="bi bi-play-fill banner-play-icon"></i> Play
                                    </a>
                                @endif
                        <a class="app-secondary-btn rounded" href="{{ route('detailscreen', $stream->stream_guid) }}">
                            <i class="bi bi-eye banner-view-icon"></i> Details
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

</div>

@push('scripts')
    <script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/73159/classie.js'></script>
    <script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/73159/TweenMax.min.js'></script>
    <script src="{{ asset('assets/sliders_assets/js/animation.js') }}"></script>
@endpush
