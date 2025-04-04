@switch(\App\Services\AppConfig::getMenuBySlug($slug)?->menu_type)
    @case('GE')
        <x-layouts.app :appInfo="\App\Services\AppConfig::get()->app->app_info">
            @include('components.genres')
        </x-layouts.app>
    @break

    @case('MB')
        <x-layouts.app :appInfo="\App\Services\AppConfig::get()->app->app_info">
            @include('components.mood-based')
        </x-layouts.app>
    @break

    @case('HO')
        @if (session()->has('USER_DETAILS') && session('USER_DETAILS') !== null)
            <x-layouts.app :appInfo="\App\Services\AppConfig::get()->app->app_info">
                @include('components.page-banner')
                @include('components.category-slider')
                @include('components.enjoy-tv-box')
                @include('components.faq_section')
            </x-layouts.app>
        @else
            @if (request()->browse)
                <x-layouts.app :appInfo="\App\Services\AppConfig::get()->app->app_info">
                    @include('components.page-banner')
                    @include('components.category-slider')
                    @include('components.enjoy-tv-box')
                    @include('components.faq_section')
                </x-layouts.app>
            @else
                @if (\App\Services\AppConfig::get()->app->app_info->landing_theme == 'AJS')
                    @include('components.ajax_still')
                @elseif (\App\Services\AppConfig::get()->app->app_info->landing_theme == 'HYP')
                    @include('components.hypatia')
                @elseif (\App\Services\AppConfig::get()->app->app_info->landing_theme == 'AJV')
                    @include('components.ajax_video')
                @elseif (\App\Services\AppConfig::get()->app->app_info->landing_theme == 'Ele')
                    @include('components.elektra')
                @elseif (\App\Services\AppConfig::get()->app->app_info->landing_theme == 'Eli')
                    @include('components.elias')
                @elseif (\App\Services\AppConfig::get()->app->app_info->landing_theme == 'Theo')
                    @include('components.theo')
                @elseif (\App\Services\AppConfig::get()->app->app_info->landing_theme == 'Iris')
                    @include('components.iris')
                @elseif (\App\Services\AppConfig::get()->app->app_info->landing_theme == 'Apollo')
                    @include('components.apollo')
                @elseif (\App\Services\AppConfig::get()->app->app_info->landing_theme == 'lyra')
                    @include('components.lyra')
                @elseif (\App\Services\AppConfig::get()->app->app_info->landing_theme == 'damian')
                    @include('components.damian')
                @elseif (\App\Services\AppConfig::get()->app->app_info->landing_theme == 'NRE')
                    <x-layouts.app :appInfo="\App\Services\AppConfig::get()->app->app_info">
                        @include('components.page-banner')
                        @include('components.category-slider')
                        @include('components.enjoy-tv-box')
                        @include('components.faq_section')
                    </x-layouts.app>
                @else
                    <x-layouts.app :appInfo="\App\Services\AppConfig::get()->app->app_info">
                        @include('components.page-banner')
                        @include('components.category-slider')
                        @include('components.enjoy-tv-box')
                        @include('components.faq_section')
                    </x-layouts.app>
                @endif
            @endif
        @endif
    @break

    @case('TG')
        <x-layouts.app :appInfo="\App\Services\AppConfig::get()->app->app_info">
            @include('components.tv-guide-section')
        </x-layouts.app>
    @break

    @default
        <x-layouts.app :appInfo="\App\Services\AppConfig::get()->app->app_info">
            @include('components.page-banner')
            @include('components.category-slider')
        </x-layouts.app>
@endswitch



@push('scripts')
    <script>
        $(document).ready(function() {
            $('.page-owl-slider').owlCarousel({
                center: true,
                items: 1,
                loop: true,
                smartSpeed: 800,
                // autoplay: true,
                margin: 10,
                stagePadding: 100,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        stagePadding: 0,
                        nav: false,
                    },
                    600: {
                        stagePadding: 0,
                        nav: false,
                    },
                    1000: {
                        stagePadding: 100,
                        nav: true,
                        margin: 20,
                    }
                }
            });
        });

        function handleSliderControlls(e) {
            let type = $(e).data("type");
            let owlWrapper = $(e).parent();
            let prevBtn = $(owlWrapper).find(".owl-prev:eq(0)");
            let nextBtn = $(owlWrapper).find(".owl-next:eq(0)");

            if (type == 0) {
                $(prevBtn).click();
            } else {
                $(nextBtn).click();
            }
        }
    </script>
@endpush
