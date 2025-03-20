<!DOCTYPE html>
<html lang="en">

<head>
    @if (env('APP_CODE') == '4lIxYy5Ac430Pfy0O0YrEzjlDpyvuPl6')
        <!--Solace Adsence Start-->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6509344422546339"
            crossorigin="anonymous"></script>
        <!-- Adsence End-->
    @endif
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \App\Services\AppConfig::get()->app->app_info->app_name ?? '' }}</title>
    <link rel="icon" href="{{ \App\Services\AppConfig::get()->app->app_info->website_faviocn ?? '' }}">
    <meta property="og:title" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_title ?? '' }}" />
    <meta property="og:image" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_image ?? '' }}" />
    <meta property="og:description" content="{!! strip_tags(\App\Services\AppConfig::get()->app->app_info->seo_description ?? '') !!}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/iris/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />

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
    @if (isset(\App\Services\AppConfig::get()->app->landingpages))
        @foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
            @if ($page->page_type === 'Iris' && $page->section_type === 'banner' && $page->status === 1)
                @if ($page->image)
                    <style>
                        .wrapper {
                            background-image: linear-gradient(rgba(4, 9, 30, 0.4), rgba(4, 9, 30, 0.4)),
                                url({{ asset($page->image) }});
                        }
                    </style>
                @endif
            @endif
        @endforeach
    @endif

</head>

<body>

    <div class="wrapper">
        <nav class="py-3">
            <ul class="d-flex align-items-center justify-content-between navbar__items px-2">
                <li class="logo__item list-unstyled d-flex gap-2 gap-md-3 align-items-center" role="button">
                    <a href="/home">
                        <img src="{{ \App\Services\AppConfig::get()->app->app_info->website_logo ?? '' }}"
                            alt="Logo">
                    </a>
                    <a href="/home?browse=true" class="browse text-decoration-none text-white border-2">Browse
                        Content</a>
                </li>
                <div class="d-flex gap-3">
                    <li class="list-unstyled"><a href="/login"
                            class="text-decoration-none text-white custom-button">Login</a></li>
                    <li class="list-unstyled"><a href="/signup"
                            class="text-decoration-none text-white custom-button active">SignUp</a>
                    </li>
                </div>
            </ul>
        </nav>

        <section class="content-wrapper text-white">
            <!-- Home Section  -->
            <div class="home__section">
                @if (isset(\App\Services\AppConfig::get()->app->landingpages))
                    @foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
                        @if ($page->page_type === 'Iris' && $page->section_type === 'banner' && $page->status === 1)
                            <h5 class="poppins-semibold mb-2">{{ $page->title ?? '' }}</h5>
                            <h1 class="poppins-bold mb-2">
                                @if (isset($page->subtitle))
                                    @php
                                        $titleWords = explode(' ', $page->subtitle);
                                        $firstWord = $titleWords[0] ?? '';
                                        $secondWord = $titleWords[1] ?? '';
                                        $thirdWord = $titleWords[2] ?? '';
                                        $fourthWord = $titleWords[3] ?? '';
                                        $remainingWords = implode(' ', array_slice($titleWords, 4)); // Concatenate remaining words
                                    @endphp
                                    {{ $firstWord }} {{ $secondWord }} <span>{{ $thirdWord }}
                                        {{ $fourthWord }}</span> {{ $remainingWords }}
                                @else
                                @endif
                            </h1>
                            <p class="poppins-regular mb-5">{{ $page->description ?? '' }}</p>
                            <a href="/signup" class="text-decoration-none text-white custom-button">Get Started</a>

                            <div class="menu">
                                <ul
                                    class="d-flex align-items-center justify-content-center gap-2 flex-wrap gap-3 gap-md-2 ps-0">
                                    @if (isset($data->app->categories))
                                        @php $count = 0; @endphp
                                        @foreach ($data->app->categories ?? [] as $category)
                                            @if (!empty($category->streams) && !empty($category->cat_title))
                                                @if ($count < 5)
                                                    <!-- Check if count is less than 10 -->
                                                    <li id="{{ $category->cat_guid ?? '' }}"
                                                        class="list-unstyled category-slide-btns"><a
                                                            href="javascript:void(0)"
                                                            class="text-decoration-none text-white custom-button {{ $count === 0 ? 'active' : '' }}">{{ $category->cat_title ?? '' }}</a>
                                                    </li>
                                                    @php $count++; @endphp
                                                @else
                                                    @break
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="menu__images py-4">
                                @if (isset($data->app->categories))
                                    @php $count = 0; @endphp
                                    @foreach ($data->app->categories ?? [] as $category)
                                        @if (!empty($category->streams) && !empty($category->cat_title))
                                            @if ($count < 5)
                                                <div class="mySlides"
                                                    style="{{ $count !== 0 ? 'display: none;' : '' }}">
                                                    @foreach ($category->streams as $index => $stream)
                                                        @if ($index < 5)
                                                            <img src="{{ $stream->stream_poster }}"
                                                                style="width:100%;">
                                                        @else
                                                            @break
                                                        @endif
                                                    @endforeach
                                                </div>
                                                @php $count++; @endphp
                                            @else
                                                @break

                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        @endif
                        @if ($page->page_type === 'Iris' && $page->section_type === 'download')
                            @if (!empty($page->appstore_link) || !empty($page->playstore_link))
                                <div
                                    class="download__apps d-flex align-items-center justify-content-around py-4 flex-wrap flex-md-nowrap">
                                    <div>
                                        @php
                                            if ($page->title) {
                                                $words = explode(' ', $page->title);
                                                $lastWord = end($words);
                                                array_pop($words);
                                                $words = implode(' ', $words);
                                            }
                                        @endphp
                                        <h4 class="text-nowrap">{{ $words ?? '' }} <span>{{ $lastWord ?? '' }}</span>
                                        </h4>
                                    </div>
                                    <div class="apps__links d-flex align-items-center justify-content-center gap-3">
                                        @if (!empty($page->playstore_link))
                                            <div>
                                                <a href="{{ $page->playstore_link ?? '' }}"><img
                                                        src="{{ asset('assets/landing_theme_assets/iris/images/play.png') }}"
                                                        alt="" srcset=""></a>
                                            </div>
                                        @endif
                                        @if (!empty($page->appstore_link))
                                            <div>
                                                <a href="{{ $page->appstore_link ?? '' }}"><img
                                                        src="{{ asset('assets/landing_theme_assets/iris/images/apple.png') }}"
                                                        alt="" srcset=""></a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                @endif
            </div>
    </div>
    </section>

    <section class="content-wrapper  foooter-text">
        <!-- Devices Section  -->
        <div class="devices__section">
            @if (isset(\App\Services\AppConfig::get()->app->landingpages))
                @foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
                    @if ($page->page_type === 'Iris' && $page->section_type === 'anywhere')
                        <h1 class="poppins-bold">
                            @if (isset($page->title))
                                @php
                                    $titleWords = explode(' ', $page->title);
                                    $firstWord = $titleWords[0] ?? '';
                                    $secondWord = $titleWords[1] ?? '';
                                    $thirdWord = $titleWords[2] ?? '';
                                    $fourthWord = $titleWords[3] ?? '';
                                    $fifthhWord = $titleWords[4] ?? '';
                                    $sixthWord = $titleWords[5] ?? '';
                                    $remainingWords = implode(' ', array_slice($titleWords, 6)); // Concatenate remaining words
                                @endphp
                                {{ $firstWord }} {{ $secondWord }} {{ $thirdWord }}
                                {{ $fourthWord }} <span>{{ $fifthhWord }} {{ $sixthWord }} </span>
                                {{ $remainingWords }}
                            @else
                            @endif
                        </h1>
                        <div class="icons d-flex align-items-center justify-content-between">
                            <div class="w-100 active tv_icon">
                                <i class="fa-solid fa-tv"></i>
                                <span>TV</span>
                            </div>
                            <div class="w-100 tb_icon">
                                <i class="fa-solid fa-tablet-screen-button"></i>
                                <span>Tablet</span>
                            </div>
                            <div class="w-100 desktop_icon">
                                <i class="fa-solid fa-desktop"></i>
                                <span>Desktop</span>
                            </div>
                        </div>
                    @endif

                    @if ($page->page_type === 'Iris' && $page->section_type === 'tv_section')
                        <div class="tv_images">
                            <h2 class="poppins-semibold">
                                @if (isset($page->title))
                                    @php
                                        $titleWords = explode(' ', $page->title);
                                        $firstWord = $titleWords[0] ?? '';
                                        $secondWord = $titleWords[1] ?? '';
                                        $thirdWord = $titleWords[2] ?? '';
                                        $fourthWord = $titleWords[3] ?? '';
                                        $remainingWords = implode(' ', array_slice($titleWords, 4)); // Concatenate remaining words
                                    @endphp
                                    {{ $firstWord }} {{ $secondWord }} {{ $thirdWord }}<span>
                                        {{ $fourthWord }}</span> {{ $remainingWords }}
                                @else
                                @endif
                            </h2>
                            <p class="poppins-regular mb-5">{{ $page->description ?? '' }}</p>
                            <div class="device__images py-4">
                                <img src="{{ $page->image }}" alt="" srcset="">
                            </div>
                        </div>
                    @endif

                    @if ($page->page_type === 'Iris' && $page->section_type === 'tablet_section')
                        <div class="tv_images d-none">
                            <h2 class="poppins-semibold">
                                @if (isset($page->title))
                                    @php
                                        $titleWords = explode(' ', $page->title);
                                        $firstWord = $titleWords[0] ?? '';
                                        $secondWord = $titleWords[1] ?? '';
                                        $thirdWord = $titleWords[2] ?? '';
                                        $fourthWord = $titleWords[3] ?? '';
                                        $remainingWords = implode(' ', array_slice($titleWords, 4)); // Concatenate remaining words
                                    @endphp
                                    {{ $firstWord }} {{ $secondWord }} {{ $thirdWord }}<span>
                                        {{ $fourthWord }}</span> {{ $remainingWords }}
                                @else
                                @endif
                            </h2>
                            <p class="poppins-regular mb-5">{{ $page->description ?? '' }}</p>
                            <div class="device__images py-4">
                                <img src="{{ $page->image }}" alt="" srcset="">
                            </div>
                        </div>
                    @endif

                    @if ($page->page_type === 'Iris' && $page->section_type === 'desktop_section')
                        <div class="tv_images d-none">
                            <h2 class="poppins-semibold">
                                @if (isset($page->title))
                                    @php
                                        $titleWords = explode(' ', $page->title);
                                        $firstWord = $titleWords[0] ?? '';
                                        $secondWord = $titleWords[1] ?? '';
                                        $thirdWord = $titleWords[2] ?? '';
                                        $fourthWord = $titleWords[3] ?? '';
                                        $remainingWords = implode(' ', array_slice($titleWords, 4)); // Concatenate remaining words
                                    @endphp
                                    {{ $firstWord }} {{ $secondWord }} {{ $thirdWord }} <span>
                                        {{ $fourthWord }}</span> {{ $remainingWords }}
                                @else
                                @endif
                            </h2>
                            <p class="poppins-regular mb-5">{{ $page->description ?? '' }}</p>
                            <div class="device__images py-4">
                                <img src="{{ $page->image }}" alt="" srcset="">
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
        @if (isset(\App\Services\AppConfig::get()->app->landingpages))
            @foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
                @if ($page->page_type === 'Iris' && $page->section_type === 'watch_now')
                    <!-- Watch Now Section  -->
                    <div class="d-flex align-items-center justify-content-around channels my-4 flex-column flex-md-row">
                        <div class=" foooter-text">
                            <h4>{{ $page->title ?? '' }}</h4>
                        </div>
                        <div class="d-flex align-items-center justify-content-center tv__channels">
                            @foreach (explode(',', $page->icon) as $iconUrl)
                                <div><img src="{{ $iconUrl }}" alt="" srcset=""></div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Download Button  -->
                    <div class="download__button">
                        <a href="/download-apps" class="text-decoration-none text-white custom-button active">Download
                            Now</a>
                    </div>
                @endif
            @endforeach
        @endif
    </section>
    <footer>
        <div class="row mt-5">
            <div class="col-md-3 mb-3">
                <a href="/home">
                    <img class="img-fluid mb-4"
                        src="{{ \App\Services\AppConfig::get()->app->app_info->website_logo ?? '' }}" alt=""
                        srcset="" width="150px">
                </a>
                <p class="p-0 m-0  foooter-text">
                    {{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_txt ?? '' }}</p>
                <a class="text-decoration-none"
                    href="{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_web_url ?? '' }}">
                    <p class="p-0 m-0  foooter-text">
                        {{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_web_name ?? '' }}
                    </p>
                </a>
            </div>
            <div class="col-md-3 ">
                <h5 class="mb-4 foooter-text"><span>GET</span> TO KNOW US</h5>
                <ul class="d-flex align-items-start flex-column list-unstyled">
                    @foreach (\App\Services\AppConfig::get()->app->data->pages as $page)
                        @if ($page->displayOn === 'F' || $page->displayOn === 'B')
                            <li><a href="/page/{{ $page->page_slug }}"
                                    class="text-decoration-none  foooter-text lh-lg">{{ $page->page_title }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3">
                <h5 class="mb-4 foooter-text"><span>TOP</span> CATEGORIES</h5>
                <ul class="d-flex align-items-start flex-column list-unstyled ">
                    @foreach (\App\Services\AppConfig::get()->app->footer_categories as $category)
                        <li><a href="{{ route('category', $category->cat_guid) }}"
                                class="text-decoration-none  foooter-text lh-lg">{{ $category->cat_title }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3">
                <h5 class="mb-4 foooter-text"><span>LET US</span> HELP YOU</h5>
                <ul class="d-flex align-items-start flex-column list-unstyled ">
                    <li><a href="/login" class="text-decoration-none  foooter-text lh-lg">Login</a></li>
                    <li><a href="/signup" class="text-decoration-none  foooter-text lh-lg">Register</a></li>
                    <li><a href="/download-apps" class="text-decoration-none  foooter-text lh-lg">Download Apps</a>
                    </li>
                </ul>
            </div>

        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="footer_rights foooter-text">
                        <span class="copyright">© {{ \App\Services\AppConfig::get()->app->app_info->app_name }}</span>
                        {{ date('Y') }}-{{ date('Y', strtotime('+1 years')) }} ALL RIGHTS RESERVED.
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Menu Items
        let menuItems = document.querySelectorAll('.menu a');
        let Icons = document.querySelectorAll('.icons div');
        let tvImages = document.querySelectorAll('.tv_images');

        menuItems.forEach(item => {
            item.addEventListener('click', (e) => {
                menuItems.forEach(menuItem => {
                    if (menuItem !== item) {
                        menuItem.classList.remove('active');
                    }
                });
                item.classList.add('active');
            })
        });



        // Devices toggle
        Icons.forEach((icon, index) => {
            icon.addEventListener('click', () => {
                Icons.forEach(item => {
                    if (icon != item) {
                        item.classList.remove('active');
                    }
                });
                icon.classList.add('active');

                tvImages.forEach((image, i) => {
                    if (index == i) {
                        image.classList.add('d-block');
                        image.classList.remove('d-none');
                    } else {
                        image.classList.add('d-none');
                        image.classList.remove('d-block');
                    }
                });
            });
        });


        (function() {
            const slideBtns = document.querySelectorAll('.category-slide-btns');
            const slides = document.querySelectorAll('.mySlides');
            slideBtns.forEach((btn, btnIndex) => {
                btn.addEventListener('click', () => {
                    slides.forEach((slide, slideIndex) => {
                        if (slideIndex === btnIndex) {
                            slide.style.display = "block";
                        } else {
                            slide.style.display = "none";
                        }
                    });
                });
            });

            slides.forEach((slide) => {
                const firstImg = slide.querySelector('img:first-child');
                firstImg.classList.add('active');
                setInterval(() => {
                    const activeImg = slide.querySelector('img.active');
                    if (activeImg.nextElementSibling) {
                        activeImg.classList.remove('active');
                        activeImg.nextElementSibling.classList.add('active');
                    } else {
                        activeImg.classList.remove('active');
                        firstImg.classList.add('active');
                    }
                }, 3500);
            })
        })();
    </script>

</body>

</html>
