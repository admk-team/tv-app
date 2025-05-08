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
@php
    $sliderSection = \App\Services\AppConfig::get()->app->app_info->slider_section ?? 'default';
@endphp

@switch($sliderSection)
    @case('magic')
        @include('components.sliders.magic_slider')
        @break
    @case('swiper')
        @include('components.sliders.swiper')
        @break
    @case('fade')
        @include('components.sliders.fade_slide')
        @break
    @case('animated')
        @include('components.sliders.animation')
        @break
    @case('hero')
        @include('components.sliders.hero_slider')
        @break
    @case('default')
    @default
        @include('components.sliders.owl_wrapper')
@endswitch

