@if (
    \App\Services\AppConfig::get()->app->app_info->announcement &&
        \App\Services\AppConfig::get()->app->app_info->announcement->announcement_start_date)
    @php
        $currentDate = now(); // Assuming you're using Laravel, this gets the current date and time
        $startDate = \Carbon\Carbon::parse(
            \App\Services\AppConfig::get()->app->app_info->announcement->announcement_start_date,
        );
        $endDate = \App\Services\AppConfig::get()->app->app_info->announcement->announcement_end_date
            ? \Carbon\Carbon::parse(\App\Services\AppConfig::get()->app->app_info->announcement->announcement_end_date)
            : null;
    @endphp

    @if ($currentDate->greaterThanOrEqualTo($startDate) && (!$endDate || $currentDate->lessThanOrEqualTo($endDate)))
        <!-- Your specific HTML code here -->
        <div
            style="background: {{ \App\Services\AppConfig::get()->app->app_info->announcement->announcement_background_color }}; display: flex; align-content: center; justify-content: center; margin-top: 6px;">
            <span
                style="color: {{ \App\Services\AppConfig::get()->app->app_info->announcement->announcement_text_color }}; display: flex; width: 850px; align-content: center; justify-content: center; word-break: break-all;">
                {{ \App\Services\AppConfig::get()->app->app_info->announcement->announcement }}
            </span>
        </div>
    @endif
@endif
@if (isset(\App\Services\AppConfig::get()->app->app_info->slider_section) &&
        \App\Services\AppConfig::get()->app->app_info->slider_section == 'default')
    @include('components.sliders.owl_wrapper')
@elseif(isset(\App\Services\AppConfig::get()->app->app_info->slider_section) &&
        \App\Services\AppConfig::get()->app->app_info->slider_section == 'magic')
    @include('components.sliders.magic_slider')
@elseif(isset(\App\Services\AppConfig::get()->app->app_info->slider_section) &&
        \App\Services\AppConfig::get()->app->app_info->slider_section == 'swiper')
    @include('components.sliders.swiper')
@elseif(isset(\App\Services\AppConfig::get()->app->app_info->slider_section) &&
        \App\Services\AppConfig::get()->app->app_info->slider_section == 'fade')
    @include('components.sliders.fade_slide')
@elseif(isset(\App\Services\AppConfig::get()->app->app_info->slider_section) &&
        \App\Services\AppConfig::get()->app->app_info->slider_section == 'animated')
    @include('components.sliders.animation')
@elseif(isset(\App\Services\AppConfig::get()->app->app_info->slider_section) &&
        \App\Services\AppConfig::get()->app->app_info->slider_section == 'hero')
    @include('components.sliders.hero_slider')
@else
    @include('components.sliders.owl_wrapper')
@endif
{{--    --}}
{{--  @include('components.sliders.hero_slider')  --}}
{{-- Fade slider --}}
{{-- <div id="carouselExampleFade" class="carousel slide carousel-fade">
    <div class="carousel-inner">
        @if (\App\Services\AppConfig::get()->app->featured_items->is_show ?? '' == 'Y')
            @foreach (\App\Services\AppConfig::get()->app->featured_items->streams as $stream)
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
