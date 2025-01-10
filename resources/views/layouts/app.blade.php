<!doctype html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />


    @include('gtm_tags.head')
    @if (Route::is('detailscreen'))
        @yield('meta-tags')
    @else
        <meta property="og:title" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_title ?? '' }}" />
        <meta property="og:image" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_image ?? '' }}" />
        <meta property="og:description" content="{!! strip_tags(\App\Services\AppConfig::get()->app->app_info->seo_description ?? '') !!}" />
    @endif
    <title>
        {{ \App\Services\AppConfig::get()->app->app_info->app_name ?? '' }}
    </title>
    @stack('style')
    {{-- Old Css --}}

    <link rel="shortcut icon" href="{{ \App\Services\AppConfig::get()->app->app_info->website_faviocn ?? '' }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-old.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/userprofile.css') }}">
    @if (isset(\App\Services\AppConfig::get()->app->app_info->faq_section) &&
            \App\Services\AppConfig::get()->app->app_info->faq_section == 1)
        <link rel="stylesheet" href="{{ asset('assets/css/faq_style.css') }}">
    @endif
    <style>
        :root {
            --bgcolor: {{ \App\Services\AppConfig::get()->app->website_colors->bgcolor }};
            --themeActiveColor: {{ \App\Services\AppConfig::get()->app->website_colors->themeActiveColor }};
            --headerBgColor: {{ \App\Services\AppConfig::get()->app->website_colors->headerBgColor }};
            --themePrimaryTxtColor: {{ \App\Services\AppConfig::get()->app->website_colors->themePrimaryTxtColor }};
            --themeSecondaryTxtColor: {{ \App\Services\AppConfig::get()->app->website_colors->themeSecondaryTxtColor }};
            --navbarMenucolor: {{ \App\Services\AppConfig::get()->app->website_colors->navbarMenucolor }};
            --navbarSearchColor: {{ \App\Services\AppConfig::get()->app->website_colors->navbarSearchColor }};
            --footerbtmBgcolor: {{ \App\Services\AppConfig::get()->app->website_colors->footerbtmBgcolor }};
            --slidercardBgColor: {{ \App\Services\AppConfig::get()->app->website_colors->slidercardBgColor }};
            --slidercardTitlecolor: {{ \App\Services\AppConfig::get()->app->website_colors->slidercardTitlecolor }};
            --slidercardCatColor: {{ \App\Services\AppConfig::get()->app->website_colors->slidercardCatColor }};
            --cardDesColor: {{ \App\Services\AppConfig::get()->app->website_colors->cardDesColor }};
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/owlcarousal/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/owlcarousal/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/slick/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/regular.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@100;200;300;400;500;600;700;800&display=swap');
    </style>
    {{-- Custom Css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    @yield('head')
</head>

<body>
    @include('gtm_tags.body')

    @include('layouts.partials.header')



    <div class="content">
        @yield('content')
    </div>

    @include('components.footers.footer')





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="{{ asset('assets/owlcarousal/js/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('assets/js/cust-frm-validation.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/jquery.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.jscroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
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
                    console.log('Input changed:', searchQuery);
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
