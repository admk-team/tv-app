@if ($data->app->app_info->announcement && $data->app->app_info->announcement->announcement_start_date)
    @php
        $currentDate = now(); // Assuming you're using Laravel, this gets the current date and time
        $startDate = \Carbon\Carbon::parse($data->app->app_info->announcement->announcement_start_date);
        $endDate = $data->app->app_info->announcement->announcement_end_date
            ? \Carbon\Carbon::parse($data->app->app_info->announcement->announcement_end_date)
            : null;
    @endphp

    @if ($currentDate->greaterThanOrEqualTo($startDate) && (!$endDate || $currentDate->lessThanOrEqualTo($endDate)))
        <!-- Your specific HTML code here -->
        <div
            style="background: {{ $data->app->app_info->announcement->announcement_background_color }}; display: flex; align-content: center; justify-content: center; margin-top: 6px;">
            <span
                style="color: {{ $data->app->app_info->announcement->announcement_text_color }}; display: flex; width: 850px; align-content: center; justify-content: center; word-break: break-all;">
                {{ $data->app->app_info->announcement->announcement }}
            </span>
        </div>
    @endif
@endif
@if (isset($data->app->app_info->slider_section) && $data->app->app_info->slider_section == 'default')
    @include('components.sliders.owl_wrapper')
@elseif(isset($data->app->app_info->slider_section) && $data->app->app_info->slider_section == 'magic')
    @include('components.sliders.magic_slider')
@elseif(isset($data->app->app_info->slider_section) && $data->app->app_info->slider_section == 'swiper')
    @include('components.sliders.swiper')
@elseif(isset($data->app->app_info->slider_section) && $data->app->app_info->slider_section == 'fade')
    @include('components.sliders.fade_slide')
@else
    @include('components.sliders.owl_wrapper')
@endif
{{--    --}}

{{-- Fade slider --}}
{{-- <div id="carouselExampleFade" class="carousel slide carousel-fade">
    <div class="carousel-inner">
        @if ($data->app->featured_items->is_show ?? '' == 'Y')
            @foreach ($data->app->featured_items->streams as $stream)
                <div class="carousel-item active">
                    <div>
                        <div class="cover-slider-item">
                            <div class="info">
                                <h2>{{ $stream->stream_title ?? '' }}</h2>
                                <div class="timestamp">
                                    <span>{{ $stream->released_year ?? '' }}</span>
                                    <span>
                                        <i class="bi bi-dot"></i>
                                    </span>
                                    <span>{{ $stream->formatted_duration ?? '' }}</span>
                                    <div class="badges">
                                        <span class="badge">{{ $stream->content_qlt ?? '' }}</span>
                                        <span class="badge">{{ $stream->content_rating ?? '' }}</span>
                                    </div>
                                </div>
                                <p class="description">
                                    {{ $stream->stream_description ?? '' }}
                                </p>
                                <div class="btns">
                                    <a class="app-primary-btn"
                                        href="{{ route('playerscreen', $stream->stream_guid) }}">
                                        <i class="bi bi-play-fill banner-play-icon"></i>
                                        Play Now
                                    </a>
                                    <a class="app-secondary-btn"
                                        href="{{ route('detailscreen', $stream->stream_guid) }}">
                                        <i class="bi bi-eye banner-view-icon"></i>
                                        See Details
                                    </a>
                                </div>
                            </div>
                            <div class="cover">
                                <img src="{{ $stream->feature_poster ?? '' }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @endif
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div> --}}
