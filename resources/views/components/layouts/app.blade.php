<!doctype html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('gtm_tags.head')
    @if (Route::is('detailscreen', 'playerscreen'))
        @yield('meta-tags')
    @else
        <meta property="og:title" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_title ?? '' }}" />
        <meta property="og:image" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_image ?? '' }}" />
        <meta property="og:description" content="{!! strip_tags(\App\Services\AppConfig::get()->app->app_info->seo_description ?? '') !!}" />
    @endif
    <title>
        {{ $appInfo->app_name ?? '' }}@stack('title')
    </title>

    {{-- Old Css --}}
    <link rel="shortcut icon" href="{{ $appInfo->website_faviocn ?? '' }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-old.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/userprofile.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tv-guide.css') }}">
    @stack('style')
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
    @if (isset($appInfo->faq_section) && $appInfo->faq_section == 1)
        <link rel="stylesheet" href="{{ asset('assets/css/faq_style.css') }}">
    @endif
    @yield('head')

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>

    @include('layouts.partials.header')

    <div class="content">
        {{ $slot }}
    </div>

    @include('components.footers.footer')

    {{-- page_view --}}
    <script>
        window.dataLayer = window.dataLayer || [];
        dataLayer.push({
            'event': 'custom_page_view',
            'page_path': '{{ request()->path() }}',
            'page_location': '{{ url()->current() }}',
            'user': '{{ session('USER_DETAILS')['FULL_USER_NAME'] ?? 'Guest' }}',
            'referrer': document.referrer,
        });
    </script>

    {{-- user_engagement  --}}
    <script>
        setTimeout(function() {
            dataLayer.push({
                'event': 'custom_user_engagement',
                'engagement_time': '50_seconds',
                'page_location': '{{ url()->current() }}',
            });
        }, 50000);
    </script>

    {{-- scroll_depth  --}}
    <script>
        document.addEventListener('scroll', function() {
            var scrollPercentage = Math.round((window.scrollY + window.innerHeight) / document.documentElement
                .scrollHeight * 100);

            if (scrollPercentage >= 25 && !window.scroll_25) {
                window.scroll_25 = true;
                dataLayer.push({
                    'event': 'custom_scroll',
                    'scroll_depth': '25%'
                });
            }
            if (scrollPercentage >= 50 && !window.scroll_50) {
                window.scroll_50 = true;
                dataLayer.push({
                    'event': 'custom_scroll',
                    'scroll_depth': '50%'
                });
            }
            if (scrollPercentage >= 75 && !window.scroll_75) {
                window.scroll_75 = true;
                dataLayer.push({
                    'event': 'custom_scroll',
                    'scroll_depth': '75%'
                });
            }
            if (scrollPercentage >= 100 && !window.scroll_100) {
                window.scroll_100 = true;
                dataLayer.push({
                    'event': 'custom_scroll',
                    'scroll_depth': '100%'
                });
            }
        });
    </script>

    {{-- session_duration --}}
    <script>
        var startTime = new Date().getTime();
        window.addEventListener('beforeunload', function() {
            var duration = Math.floor((new Date().getTime() - startTime) / 1000);
            dataLayer.push({
                'event': 'session_duration',
                'duration': duration,
                'user_status': '{{ session('USER_DETAILS') ? 'logged_in' : 'guest' }}'
            });
        });
    </script>

    {{-- social_share --}}
    <script>
        document.querySelectorAll('.social-share').forEach(function(shareButton) {
            shareButton.addEventListener('click', function() {
                dataLayer.push({
                    'event': 'social_share',
                    'share_platform': shareButton.getAttribute('data-platform'),
                    'content_shared': shareButton.getAttribute('data-content'),
                    'user_status': '{{ session('USER_DETAILS') ? 'logged_in' : 'guest' }}'
                });
            });
        });
    </script>

    {{-- Search --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('#searchKeyword');
            const searchForm = document.querySelector('#searchForm');

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

            const handleInputChange = debounce(function() {
                var searchQuery = searchInput.value;
                console.log('Input changed:', searchQuery);
                if (searchQuery.length > 3) {
                    dataLayer.push({
                        'event': 'custom_search_input',
                        'search_term': searchQuery,
                        'user': '{{ session('USER_DETAILS')['FULL_USER_NAME'] ?? 'Guest' }}',
                    });
                }
            }, 300); // Adjust the delay as necessary

            searchInput.addEventListener('input', handleInputChange);
        });
    </script>


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



        // $('.slider-container').each(function() {
        //     var $this = $(this);
        //     var itemsPerRow = $this.data('items-per-row') || 1; // Default to 1 if not set
        //     var sliderClass = $this.attr('class').split(' ').find(cls => cls.endsWith('_slider'));

        //     // Initialize slick slider
        //     $this.slick({
        //         dots: true,
        //         infinite: true,
        //         loop: true,
        //         autoplay: true,
        //         autoplaySpeed: 3000,
        //         slidesToShow: itemsPerRow,
        //         slidesToScroll: 1,
        //         responsive: [{
        //                 breakpoint: 1740,
        //                 settings: {
        //                     slidesToShow: Math.max(itemsPerRow - 1, 1),
        //                     slidesToScroll: 1,
        //                     dots: true,
        //                     arrows: true
        //                 }
        //             },
        //             {
        //                 breakpoint: 1200,
        //                 settings: {
        //                     slidesToShow: Math.max(itemsPerRow - 2, 1),
        //                     slidesToScroll: 1,
        //                     dots: true,
        //                     arrows: false
        //                 }
        //             },
        //             {
        //                 breakpoint: 600,
        //                 settings: {
        //                     slidesToShow: Math.max(itemsPerRow - 3, 1),
        //                     slidesToScroll: 1,
        //                     arrows: false
        //                 }
        //             },
        //             {
        //                 breakpoint: 480,
        //                 settings: {
        //                     slidesToShow: Math.max(itemsPerRow - 4, 1),
        //                     slidesToScroll: 1,
        //                     dots: false,
        //                     arrows: false
        //                 }
        //             }
        //         ]
        //     });
        // });

        $(document).ready(function() {
            $('.slider-container .slick-slider').each(function() {
                var $this = $(this);
                var itemsPerRow = $this.data('items-per-row') || 1; // Get the number of items per row
                var autoplay = $this.data('autoplay');

                $this.slick({
                    dots: true,
                    infinite: true,
                    loop: true,
                    autoplay: autoplay ||
                        false, // Use the autoplay data attribute or default to false
                    autoplaySpeed: 3000,
                    slidesToShow: itemsPerRow,
                    slidesToScroll: 1,
                    responsive: [{
                            breakpoint: 1740,
                            settings: (itemsPerRow == 2) ? {
                                slidesToShow: 2,
                                slidesToScroll: 1,
                                arrows: false
                            } : {
                                slidesToShow: Math.max(itemsPerRow - 1, 1),
                                slidesToScroll: 1,
                                dots: true,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 1200,
                            settings: (itemsPerRow == 2) ? {
                                slidesToShow: 2,
                                slidesToScroll: 1,
                                arrows: false
                            } : {
                                slidesToShow: Math.max(itemsPerRow - 1, 1),
                                slidesToScroll: 1,
                                dots: true,
                                arrows: false
                            }
                        },
                        {
                            // Condition: If itemsPerRow is 2, always keep it at 2
                            breakpoint: 770,
                            settings: (itemsPerRow == 2) ? {
                                slidesToShow: 2,
                                slidesToScroll: 1,
                                arrows: false
                            } : {
                                slidesToShow: Math.max(itemsPerRow - 1, 1),
                                slidesToScroll: 1,
                                dots: true,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1,
                                dots: false,
                                arrows: false
                            }
                        }
                    ]
                });
            });
        });





        // $('.potrait_slider').slick({
        //     slidesToShow: 2,
        //     loop: true,
        //     autoplay: {{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_potrait_slider_autoplay }},
        //     infinite: true,
        //     autoplaySpeed: 3000,
        //     slidesToScroll: 1,
        //     responsive: [{
        //             breakpoint: 960,
        //             settings: {
        //                 arrows: false,
        //                 slidesToShow: 6,
        //                 slidesToScroll: 1
        //             }
        //         },
        //         {
        //             breakpoint: 767,
        //             settings: {
        //                 arrows: false,
        //                 slidesToShow: 5,
        //                 slidesToScroll: 1
        //             }
        //         },
        //         {
        //             breakpoint: 480,
        //             settings: {
        //                 arrows: false,
        //                 slidesToShow: 4,
        //                 slidesToScroll: 1
        //             }
        //         },
        //         {
        //             breakpoint: 330,
        //             settings: {
        //                 arrows: false,
        //                 slidesToShow: 3,
        //                 slidesToScroll: 1
        //             }
        //         }
        //     ]
        // });

        // /** script for landscape_slider */
        // $('.landscape_slider').slick({
        //     dots: false,
        //     infinite: true,
        //     loop: true,
        //     autoplay: {{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_landscape_slider_autoplay }},
        //     autoplaySpeed: 3000,
        //     slidesToShow: 5,
        //     slidesToScroll: 1,
        //     responsive: [{
        //             breakpoint: 1740,
        //             settings: {
        //                 slidesToShow: 4,
        //                 slidesToScroll: 1,
        //                 dots: true,
        //                 arrows: true
        //             }
        //         },
        //         {
        //             breakpoint: 1200,
        //             settings: {
        //                 slidesToShow: 3,
        //                 slidesToScroll: 1,
        //                 dots: true,
        //                 arrows: false
        //             }
        //         },
        //         {
        //             breakpoint: 600,
        //             settings: {
        //                 slidesToShow: 2,
        //                 slidesToScroll: 1,
        //                 arrows: false
        //             }
        //         },
        //         {
        //             breakpoint: 480,
        //             settings: {
        //                 slidesToShow: 2,
        //                 slidesToScroll: 1,
        //                 dots: false,
        //                 arrows: false,
        //             }
        //         }
        //     ]
        // });

        // /** script for billboard Ads */
        // $('.billboard_ads').slick({
        //     dots: true,
        //     infinite: true,
        //     loop: true,
        //     autoplay: {{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_billboard_ads_autoplay }},
        //     autoplaySpeed: 3000,
        //     slidesToShow: 1
        // });

        // /** script for leaderboard Ads */
        // $('.leaderboard_ads').slick({
        //     dots: true,
        //     infinite: true,
        //     loop: true,
        //     autoplay: {{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_leaderboard_ad_autoplay }},
        //     autoplaySpeed: 3000,
        //     slidesToShow: 1
        // });

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
