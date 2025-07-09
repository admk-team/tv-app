<!doctype html>
<html lang="en">
 <meta name="csrf-token" content="{{ csrf_token() }}" />
@if (env('APP_CODE') == '382f94988e01455c7262c1480ae530a6')
    <!-- OliveBranch -->
    @include('layouts.app-head.olive_app_head')
@elseif (env('APP_CODE') == '588b8647ff77800ed4134024fb1e2ca5')
    <!-- QuanioBranch -->
    @include('layouts.app-head.quanio_app_head')
@elseif (env('APP_CODE') == '4lIxYy5Ac430Pfy0O0YrEzjlDpyvuPl6')
    <!-- Solace -->
    @include('layouts.app-head.solace_app_head')
@else
    <!-- other app -->
    @include('layouts.app-head.common_app_head')
@endif
@if (isset(\App\Services\AppConfig::get()->app->app_info->is_gtm_enabled) &&
        \App\Services\AppConfig::get()->app->app_info->is_gtm_enabled == 1)
    @include('gtm_tags.body')
@endif
@include('layouts.partials.header')



<div class="content">
    @yield('content')
</div>

@include('components.footers.footer')


{{-- Search --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select elements
        const searchInput = document.querySelector('#searchKeyword');
        const searchForm = document.querySelector('#searchForm');

        // Ensure the elements exist
        if (!searchInput) {
            // console.warn('Search input element (#searchKeyword) not found.');
            return; // Exit if the search input is missing
        }

        if (!searchForm) {
            // console.warn('Search form element (#searchForm) not found.');
            // Optional: Handle cases where the search form is missing
        }

        // Debounce function
        const debounce = (func, delay) => {
            let timeoutId;
            return (...args) => {
                if (timeoutId) {
                    clearTimeout(timeoutId);
                }
                timeoutId = setTimeout(() => {
                    func.apply(null, args);
                }, delay);
            };
        };

        // Handle input change with debounce
        const handleInputChange = debounce(function() {
            const searchQuery = searchInput.value;
            if (searchQuery.length > 3) {
                if (typeof dataLayer !== 'undefined') {
                    dataLayer.push({
                        event: 'custom_search_input',
                        search_term: searchQuery,
                        user: '{{ session('USER_DETAILS')['FULL_USER_NAME'] ?? 'Guest' }}',
                    });
                } else {
                    // console.warn('dataLayer is not defined.');
                }
            }
        }, 300); // Adjust the delay as necessary

        // Add event listener
        searchInput.addEventListener('input', handleInputChange);
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
<script src="{{ asset('assets/js/jquery3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/owlcarousal/js/owl.carousel.min.js') }}"></script>

<script src="{{ asset('assets/js/cust-frm-validation.js') }}"></script>
{{-- <script src="{{ asset('assets/js/jquery.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script> --}}
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.jscroll.min.js') }}"></script>
<script async src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/year_select.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

{{-- Search --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select elements
        const searchInput = document.querySelector('#searchKeyword');
        const searchForm = document.querySelector('#searchForm');

        // Ensure the elements exist
        if (!searchInput) {
            // console.warn('Search input element (#searchKeyword) not found.');
            return; // Exit if the search input is missing
        }

        if (!searchForm) {
            // console.warn('Search form element (#searchForm) not found.');
            // Optional: Handle cases where the search form is missing
        }

        // Debounce function
        const debounce = (func, delay) => {
            let timeoutId;
            return (...args) => {
                if (timeoutId) {
                    clearTimeout(timeoutId);
                }
                timeoutId = setTimeout(() => {
                    func.apply(null, args);
                }, delay);
            };
        };

        // Handle input change with debounce
        const handleInputChange = debounce(function() {
            const searchQuery = searchInput.value;
            if (searchQuery.length > 3) {
                if (typeof dataLayer !== 'undefined') {
                    dataLayer.push({
                        event: 'custom_search_input',
                        search_term: searchQuery,
                        user: '{{ session('USER_DETAILS')['FULL_USER_NAME'] ?? 'Guest' }}',
                    });
                } else {
                    // console.warn('dataLayer is not defined.');
                }
            }
        }, 300); // Adjust the delay as necessary

        // Add event listener
        searchInput.addEventListener('input', handleInputChange);
    });
</script>
{{-- Custom JS --}}
<script type="text/javascript" src="{{ asset('assets/slick/slick.min.js') }}"></script>
<script>
    $(document).ready(function() {
        let root = document.querySelector(":root");

        root.style.setProperty("--bg-color",
            '{{ \App\Services\AppConfig::get()->app->website_colors->bgcolor }}');
        root.style.setProperty("--header-bg-color",
            '{{ \App\Services\AppConfig::get()->app->website_colors->headerBgColor }}');
        root.style.setProperty("--active-color",
            '{{ \App\Services\AppConfig::get()->app->website_colors->themeActiveColor }}');
        root.style.setProperty("--nav-color",
            '{{ \App\Services\AppConfig::get()->app->website_colors->navbarMenucolor }}');
        root.style.setProperty("--primary-text-color",
            '{{ \App\Services\AppConfig::get()->app->website_colors->themePrimaryTxtColor }}');
        root.style.setProperty("--secondary-text-color",
            '{{ \App\Services\AppConfig::get()->app->website_colors->themeSecondaryTxtColor }}');
        root.style.setProperty("--footer-bg-color",
            '{{ \App\Services\AppConfig::get()->app->website_colors->footerbtmBgcolor }}');
        root.style.setProperty("--nav-search-color",
            '{{ \App\Services\AppConfig::get()->app->website_colors->navbarSearchColor }}');
        root.style.setProperty("--card-desc-color",
            '{{ \App\Services\AppConfig::get()->app->website_colors->cardDesColor }}');
        root.style.setProperty("--slider-card-bg-color",
            '{{ \App\Services\AppConfig::get()->app->website_colors->slidercardBgColor }}');
        root.style.setProperty("--slider-card-title-color",
            '{{ \App\Services\AppConfig::get()->app->website_colors->slidercardTitlecolor }}');
        root.style.setProperty("--slider-card-cat-color",
            '{{ \App\Services\AppConfig::get()->app->website_colors->slidercardCatColor }}');
    });
</script>

<script>
    let portraitSliderAutoplay =
        '{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_potrait_slider_autoplay }}';
    let landscapeSliderAutoplay =
        '{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_landscape_slider_autoplay }}';
    let billboardSliderAutoplay =
        '{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_billboard_ads_autoplay }}';
    let leaderboardSliderAutoplay =
        '{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_leaderboard_ad_autoplay }}';

    $('.potrait_slider').slick({
        slidesToShow: 7,
        loop: true,
        autoplay: {{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_potrait_slider_autoplay }},
        infinite: true,
        autoplaySpeed: 3000,
        slidesToScroll: 1,
        swipeToSlide: true,
        responsive: [{
                breakpoint: 960,
                settings: {
                    arrows: true,
                    slidesToShow: 6,
                    slidesToScroll: 1,
                    swipeToSlide: true,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    arrows: false,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    swipeToSlide: true,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    swipeToSlide: true,
                }
            },
            {
                breakpoint: 330,
                settings: {
                    arrows: false,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    swipeToSlide: true,
                }
            }
        ]
    });


    /** script for landscape_slider */

    $('.landscape_slider').slick({
        dots: false,
        infinite: true,
        loop: true,
        autoplay: {{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_landscape_slider_autoplay }},
        autoplaySpeed: 3000,
        slidesToShow: 5,
        slidesToScroll: 1,
        swipeToSlide: true,
        responsive: [{
                breakpoint: 1740,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    swipeToSlide: true,
                    dots: true,
                    arrows: true
                }
            },
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    swipeToSlide: true,
                    dots: true,
                    arrows: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    swipeToSlide: true,
                    arrows: false
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    swipeToSlide: true,
                    dots: false,
                    arrows: false,
                }
            }
        ]
    });

    /** script for billboard Ads */

    $('.billboard_ads').slick({
        dots: true,
        infinite: true,
        loop: true,
        autoplay: {{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_billboard_ads_autoplay }},
        autoplaySpeed: 3000,
        slidesToShow: 1
    });


    /** script for leaderboard Ads */

    $('.leaderboard_ads').slick({
        dots: true,
        infinite: true,
        loop: true,
        autoplay: {{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_leaderboard_ad_autoplay }},
        autoplaySpeed: 3000,
        slidesToShow: 1
    });

    $(document).ready(function() {
        $(".clss").click(function() {
            $(".scsMsg").hide();
        });
        $(".scsMsg").delay(4000).fadeOut();
    });
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
<script>
    /** Script for year */
    $('.yearselect').yearselect();

    $(document).ready(function() {
        $('.navbar-default li').on('click', function() {
            $('.navbar-default li').removeClass('active');
            $(this).addClass('active');
        })
    });
</script>

{{-- <script>
        /** script for landscape_slider */
        $('.landscape_slider').slick({
            dots: false,
            infinite: true,
            loop: true,
            autoplay: {{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_landscape_slider_autoplay }},
            autoplaySpeed: 3000,
            slidesToShow: 5,
            slidesToScroll: 1,
            responsive: [{
                    breakpoint: 1740,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        dots: true,
                        arrows: true
                    }
                },
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        dots: true,
                        arrows: false
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        arrows: false
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        dots: false,
                        arrows: false,
                    }
                }
            ]
        });
    </script> --}}

@stack('scripts')
</body>

</html>
