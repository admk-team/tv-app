<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \App\Services\AppConfig::get()->app->app_info->app_name ?? '' }}</title>
    <meta property="og:title" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_title ?? '' }}" />
    <meta property="og:image" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_image ?? '' }}" />
    <meta property="og:description" content="{!! strip_tags(\App\Services\AppConfig::get()->app->app_info->seo_description ?? '') !!}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link href="{{ asset('assets/landing_theme_assets/apollo/css/style.css') }}" rel="stylesheet">
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

        /* body {
            background-image: linear-gradient(rgba(4, 9, 30, 0.4), rgba(4, 9, 30, 0.4)),
                url("{{ asset('assets/landing_theme_assets/apollo/images/banner.png') }}");
        } */
        .bg-image {
            /* background-image: linear-gradient(rgba(4, 9, 30, 0.2), rgba(4, 9, 30, 0.2)),
        url("{{ asset('assets/landing_theme_assets/apollo/images/banner.png') }}"); */
            width: 100%;
            background-position: center;
            background-size: cover;
            position: relative;
            padding: 1rem;
        }
    </style>
    @if (isset(\App\Services\AppConfig::get()->app->landingpages))
        @foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
            @if ($page->page_type === 'Apollo' && $page->section_type === 'banner' && $page->status === 1)
                @if ($page->image)
                    <style>
                        .bg-image {
                            background-image: linear-gradient(rgba(4, 9, 30, 0.2), rgba(4, 9, 30, 0.2)), url({{ asset($page->image) }});
                        }
                    </style>
                @endif
            @endif
        @endforeach
    @endif
</head>

<body>
    {{-- start Bg-Image div  --}}

    <div class="bg-image">
        <!-- START: Top Header -->
        <header class="content-wrapper d-flex justify-content-between align-items-center px-2 px-md-3 py-2 mb-3">
            <a href="/home">
                <img src="{{ \App\Services\AppConfig::get()->app->app_info->website_logo ?? '' }}" class="logo" />
            </a>
            <nav class="d-flex gap-2 gap-md-3 align-items-center">
                <a href="/home?browse=true" class="browse-btn">Browse Content</a>
                <a href="/login" class="btn-primary-new-outline">Login</a>
                @if (\App\Services\AppConfig::get()->app->app_info->is_signup_btn_show === 'Y')
                    <a class="btn-primary-new" href="/signup">Sign Up</a>
                @endif
            </nav>
        </header>
        <!-- END: Top Header -->
        @if (isset(\App\Services\AppConfig::get()->app->landingpages))
            @foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
                @if ($page->page_type === 'Apollo' && $page->section_type === 'banner' && $page->status === 1)
                    <!-- START: Hero Section -->
                    <section
                        class="sec-hero content-wrapper d-flex flex-column justify-content-center align-items-center px-2 px-md-3 mb-5">
                        <div class="tab-btns d-flex justify-content-between w-100">
                            @if (isset($data->app->categories))
                                @php $count = 0; @endphp
                                @foreach ($data->app->categories ?? [] as $category)
                                    @if (!empty($category->streams) && !empty($category->cat_title))
                                        @if ($count == 0)
                                            <div class="active">{{ $category->cat_title ?? '' }}</div>
                                        @else
                                            <div>{{ $category->cat_title ?? '' }}</div>
                                        @endif
                                        @php $count++; @endphp
                                        @if ($count >= 5)
                                        @break
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="tabs position-relative">
                        @if (isset($data->app->categories))
                            @php $count = 0; @endphp
                            @foreach ($data->app->categories ?? [] as $category)
                                @if (!empty($category->streams) && !empty($category->cat_title))
                                    @if ($count < 5)
                                        <div
                                            class="tab-content px-sm-4 px-md-5 @if ($count == 0) active @endif">
                                            <div class="poster-slides">
                                                @foreach ($category->streams as $index => $stream)
                                                    @if ($index < 5)
                                                        <img src="{{ $stream->stream_poster }}">
                                                    @else
                                                    @break
                                                @endif
                                            @endforeach
                                            <div class="overlay"></div>
                                        </div>
                                    </div>
                                    @php $count++; @endphp
                                @else
                                @break

                            @endif
                        @endif
                    @endforeach
                @endif
    @endif
@endforeach
@endif
@if (isset(\App\Services\AppConfig::get()->app->landingpages))
@foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
    @if ($page->page_type === 'Apollo' && $page->section_type === 'banner' && $page->status === 1)
        <div class="text-content px-sm-4 px-md-5 d-flex flex-column justify-content-end">
            <div class="wrapper">
                <h3>{{ $page->title ?? '' }}</h3>
                <h1>{{ $page->subtitle ?? '' }}</h1>
                <p>{{ $page->description ?? '' }}</p>
                <div class="mt-2 mt-sm-4 mt-md-5 mb-2">
                    @if (\App\Services\AppConfig::get()->app->app_info->is_signup_btn_show === 'Y')
                        <a class="btn-primary-new border get-started-btn" href="/signup">Get Started</a>
                    @endif
                </div>
            </div>
        </div>
</div>
@endif
@if ($page->page_type === 'Apollo' && $page->section_type === 'download')
@if (!empty($page->appstore_link) || !empty($page->playstore_link))
<div
    class="apps__links d-flex align-items-center justify-content-center gap-3 mt-5 flex-column flex-md-row">
    <h5>Download Now</h5>
    <div class="d-flex w-100 align-items-center">
        @if (!empty($page->playstore_link))
            <div>
                <a href="{{ $page->playstore_link }}"><img
                        src="{{ asset('assets/landing_theme_assets/iris/images/play.png') }}"
                        style="max-width: 240px;" alt="" srcset=""></a>
            </div>
        @endif
        @if (!empty($page->appstore_link))
            <div>
                <a href="{{ $page->appstore_link }}"><img
                        src="{{ asset('assets/landing_theme_assets/iris/images/apple.png') }}"
                        style="max-width: 240px;" alt="" srcset=""></a>
            </div>
        @endif
    </div>
</div>
@endif
@endif
@endforeach
</section>
</div>
<!-- END: Hero Section -->
@foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
@if ($page->page_type === 'Apollo' && $page->section_type === 'anywhere')
<!-- START: Video Section -->
<div class="sec-video mb-5  px-sm-4 px-md-5">
    <div class="content-wrapper">
        @if (isset($page->title))
            @php
                $titleWords = explode(' ', $page->title);
                $firstWord = $titleWords[0] ?? '';
                $remainingWords = implode(' ', array_slice($titleWords, 1)); // Concatenate remaining words
            @endphp
            <h1><span>{{ $firstWord }}</span> {{ $remainingWords }}</h1>
        @else
        @endif
        <p>{{ $page->description ?? '' }}</p>
    </div>

    {{-- End Bg-Image div  --}}
    @if (isset($page->video_url))
        <div class="video">
            <video width="400" autoplay playsinline muted loop>
                <source src="{{ $page->video_url ?? '' }}" type="video/mp4">
            </video>
        </div>
    @endif
</div>
<!-- END: Video Section -->
@endif
@endforeach
@foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
@if ($page->page_type === 'Apollo' && $page->section_type === 'tv_section')
<!-- START: Device Section -->
<div class="sec-device content-wrapper px-2 px-md-3">
    <div class="tab-btns d-flex gap-3 gap-sm-3 gap-md-4 gap-lg-5">
        <div class="active"><span>TV</span></div>
        <div><span>Tablet & Mobile</span></div>
        <div><span>Desktop & Laptop</span></div>
    </div>
    <div class="tabs">
        <div class="tab-content active">
            <div class="row">
                <div class="col-md-8 order-last order-md-first">
                    @if (isset($page->title))
                        @php
                            $titleWords = explode(' ', $page->title);
                            $firstWord = $titleWords[0] ?? '';
                            $secondWord = $titleWords[1] ?? '';
                            $thirdWord = $titleWords[2] ?? '';
                            $remainingWords = implode(' ', array_slice($titleWords, 3)); // Concatenate remaining words
                        @endphp
                        <span>
                            <h1>{{ $firstWord }} {{ $secondWord }} {{ $thirdWord }}
                                <span>{{ $remainingWords }}</span>
                            </h1>
                        @else
                    @endif

                    <p>{{ $page->description ?? '' }}</p>
@endif
@endforeach
@foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
@if ($page->page_type === 'Apollo' && $page->section_type === 'watch_now')
<div class="platforms d-flex align-items-center gap-3 gap-md-4 flex-column flex-md-row">
    <div class="text"> {{ $page->title ?? '' }}</div>
    <div class="icons">
        @foreach (explode(',', $page->icon) as $iconUrl)
            <img src="{{ $iconUrl }}" width="66px">
        @endforeach
    </div>
</div>
<a href="/download-apps" class="btn-primary-new device-download-btn">Download Now</a>
@endif
@endforeach
@foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
@if ($page->page_type === 'Apollo' && $page->section_type === 'tv_section')
</div>
<div class="col-md-4 mb-3 mb-md-0">
    <img class="device-img" src="{{ $page->image }}">
</div>
</div>
</div>
@endif
@if ($page->page_type === 'Apollo' && $page->section_type === 'tablet_section')
<div class="tab-content">
    <div class="row">
        <div class="col-md-8 order-last order-md-first">
            @if (isset($page->title))
                @php
                    $titleWords = explode(' ', $page->title);
                    $firstWord = $titleWords[0] ?? '';
                    $secondWord = $titleWords[1] ?? '';
                    $thirdWord = $titleWords[2] ?? '';
                    $remainingWords = implode(' ', array_slice($titleWords, 3)); // Concatenate remaining words
                @endphp
                <span>
                    <h1>{{ $firstWord }} {{ $secondWord }} {{ $thirdWord }}
                        <span>{{ $remainingWords }}</span>
                    </h1>
                @else
            @endif

            <p>{{ $page->description ?? '' }}</p>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <img class="device-img" src="{{ $page->image }}">
        </div>
    </div>
</div>
@endif
@if ($page->page_type === 'Apollo' && $page->section_type === 'desktop_section')
<div class="tab-content">
    <div class="row">
        <div class="col-md-8 order-last order-md-first">
            @if (isset($page->title))
                @php
                    $titleWords = explode(' ', $page->title);
                    $firstWord = $titleWords[0] ?? '';
                    $secondWord = $titleWords[1] ?? '';
                    $thirdWord = $titleWords[2] ?? '';
                    $remainingWords = implode(' ', array_slice($titleWords, 3)); // Concatenate remaining words
                @endphp
                <span>
                    <h1>{{ $firstWord }} {{ $secondWord }} {{ $thirdWord }}
                        <span>{{ $remainingWords }}</span>
                    </h1>
                @else
            @endif

            <p>{{ $page->description ?? '' }}</p>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <img class="device-img" src="{{ $page->image }}">
        </div>
    </div>
</div>
@endif
@endforeach
</div>
</div>
<!-- END: Device Section -->
@foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
@if ($page->page_type === 'Apollo' && $page->section_type === 'membership' && $page->status === 1)
<!-- START: CTA Section -->
<div class="sec-cta content-wrapper px-5 px-md-3 py-5 py-md-3 px-sm-1 px-md-1">
    <div class="row ">
        <div class="col-md-5 text">
            @if (isset($page->description))
                @php
                    $titleWords = explode(' ', $page->description);
                    $firstWord = $titleWords[0] ?? '';
                    $secondWord = $titleWords[1] ?? '';
                    $thirdWord = $titleWords[2] ?? '';
                    $remainingWords = implode(' ', array_slice($titleWords, 3)); // Concatenate remaining words
                @endphp
                <span>
                    <h1>{{ $firstWord }} {{ $secondWord }} <span>{{ $thirdWord }} </span></h1>
                    <p>{{ $remainingWords }}</p>
                @else
            @endif
        </div>
        <div class="col-md-7 form d-flex align-items-center">
            <form class="flex-grow-1 max-w-100" id="form">
                <div class="field d-flex align-items-center">
                    <input type="text" name="email" id="email" placeholder="Enter your Email">
                    <button id="submit" class="btn-primary-new get-started-btn">Get Started</button>
                </div>
                <span
                    class="d-flex align-items-center justify-content-center text-danger email-error"></span>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach
@endif
<!-- END: CTA Section -->
<!-- start: footer Section -->
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
<!-- end: footer Section -->
@include('components.includes.script1')
<script>
    (function() {
        const tabBtns = document.querySelectorAll('.sec-hero .tab-btns > div');
        const tabContents = document.querySelectorAll('.sec-hero .tab-content');
        tabBtns.forEach((btn, index) => {
            btn.addEventListener('click', () => {
                if (!tabContents[index]) {
                    return;
                }
                document.querySelector('.sec-hero .tab-btns .active').classList.remove('active');
                document.querySelector('.sec-hero .tab-content.active').classList.remove('active');
                btn.classList.add('active');
                tabContents[index].classList.add('active');
            });
        });

        document.querySelectorAll('.poster-slides').forEach((slide) => {
            const firstImg = slide.querySelector('img:first-child');
            firstImg.classList.add('active');
            setInterval(() => {
                const activeImg = slide.querySelector('img.active');
                if (activeImg.nextElementSibling && !activeImg.nextElementSibling.classList
                    .contains('overlay')) {
                    activeImg.classList.remove('active');
                    activeImg.nextElementSibling.classList.add('active');
                } else {
                    activeImg.classList.remove('active');
                    firstImg.classList.add('active');
                }
            }, 3500);
        })
    })();

    (function() {
        const tabBtns = document.querySelectorAll('.sec-device .tab-btns > div > span');
        const tabContents = document.querySelectorAll('.sec-device .tab-content');
        tabBtns.forEach((btn, index) => {
            btn.addEventListener('click', () => {
                if (!tabContents[index]) {
                    return;
                }
                document.querySelector('.sec-device .tab-btns .active').classList.remove('active');
                document.querySelector('.sec-device .tab-content.active').classList.remove(
                    'active');
                btn.parentNode.classList.add('active');
                tabContents[index].classList.add('active');
            });
        });
    })();
</script>
</body>

</html>
