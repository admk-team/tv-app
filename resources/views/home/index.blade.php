@switch(\App\Services\AppConfig::getMenuBySlug($slug)?->menu_type)
    @case('GE')
        <x-layouts.app :appInfo="$data->app->app_info">
            @include('components.genres')
        </x-layouts.app>
    @break

    @case('HO')
        @if (session()->has('USER_DETAILS'))
            <x-layouts.app :appInfo="$data->app->app_info">
                @include('components.page-banner')
                @include('components.category-slider')
                @include('components.download-box')
            </x-layouts.app>
        @else
            @if ($data->app->app_info->landing_theme == 'AJS')
                @include('components.ajax_still')
            @elseif ($data->app->app_info->landing_theme == 'HYP')
                @include('components.hypatia')
            @elseif ($data->app->app_info->landing_theme == 'AJV')
                @include('components.ajax_video')
            @elseif ($data->app->app_info->landing_theme == 'Ele')
                @include('components.elektra')
            @elseif ($data->app->app_info->landing_theme == 'Eli')
                @include('components.elias')
            @elseif ($data->app->app_info->landing_theme == 'NRE')
                <x-layouts.app :appInfo="$data->app->app_info">
                    @include('components.page-banner')
                    @include('components.category-slider')
                    @include('components.download-box')
                </x-layouts.app>
            @else
                <x-layouts.app :appInfo="$data->app->app_info">
                    @include('components.page-banner')
                    @include('components.category-slider')
                    @include('components.download-box')
                </x-layouts.app>
            @endif
        @endif
    @break

    @case('TG')
        <x-layouts.app :appInfo="$data->app->app_info">
            @include('components.tv-guide-section')
        </x-layouts.app>
    @break

    @default
        <x-layouts.app :appInfo="$data->app->app_info">
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
