@if (isset(\App\Services\AppConfig::get()->app->app_info->enjoy_tv_section) &&
        \App\Services\AppConfig::get()->app->app_info->enjoy_tv_section_status == 1)
    @switch(\App\Services\AppConfig::get()->app->app_info->enjoy_tv_section)
        @case('default')
            @include('components.enjoy-tv-sections.default')
        @break

        @case('text_right_image_left')
            @include('components.enjoy-tv-sections.text_right_image_left')
        @break

        @case('slanted_divider')
            @include('components.enjoy-tv-sections.slanted_divider')
        @break

        @case('centered_content')
            @include('components.enjoy-tv-sections.centered_content')
        @break

        @case('background_image_top_text')
            @include('components.enjoy-tv-sections.text_above_image')
        @break

        @case('overlapping_layout')
            @include('components.enjoy-tv-sections.overlapping_layout')
        @break

        @default
            @include('components.enjoy-tv-sections.default')
    @endswitch
@else
    {{-- @include('components.enjoy-tv-sections.default') --}}
@endif
