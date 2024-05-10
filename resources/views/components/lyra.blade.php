@extends('components.layouts.landingpage_layout')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link href="{{ asset('assets/landing_theme_assets/lyra/css/style.css') }}" rel="stylesheet">
    <!-- Link Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <!-- Link jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @if (isset($data->app->landingpages))
        @foreach ($data->app->landingpages as $page)
            @if ($page->page_type === 'lyra' && $page->section_type === 'banner' && $page->status === 1)
                @if ($page->image)
                    <style>
                        .our_storycard {
                            background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.6)),
                                url({{ asset($page->image) }});
                        }
                    </style>
                @endif
            @endif
        @endforeach
    @endif
@endsection

@section('content')

    <!-- START: Hero Section -->
    <div class="our_storycard">

        <!-- START: Top Header -->
        <header class="content-wrapper d-flex justify-content-between align-items-center px-2 px-md-3 py-2 mb-3">
            <a href="/home">
                <img src="{{ $data->app->app_info->website_logo ?? '' }}" class="logo" width="100px" />
            </a>
            <nav class="d-flex gap-2 gap-md-3 align-items-center">
                <a href="/home?browse=true" class="browse-btn">Browse Content</a>
                <form class="search-form">
                    <div class="input-group">
                        <a href="/searchscreen" class="search-icon">
                            <svg width="42" height="42" viewBox="0 0 42 42" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="21" cy="21" r="20.6" stroke="white" stroke-width="0.8" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M20.4993 12C19.1439 12.0001 17.8081 12.3244 16.6035 12.9457C15.3989 13.567 14.3604 14.4674 13.5745 15.5718C12.7887 16.6761 12.2783 17.9523 12.086 19.294C11.8937 20.6357 12.025 22.004 12.4691 23.2846C12.9131 24.5652 13.6569 25.7211 14.6385 26.6557C15.6201 27.5904 16.811 28.2768 18.1118 28.6576C19.4126 29.0384 20.7856 29.1026 22.1163 28.8449C23.447 28.5872 24.6967 28.015 25.7613 27.176L29.4133 30.828C29.6019 31.0102 29.8545 31.111 30.1167 31.1087C30.3789 31.1064 30.6297 31.0012 30.8151 30.8158C31.0005 30.6304 31.1057 30.3796 31.108 30.1174C31.1102 29.8552 31.0094 29.6026 30.8273 29.414L27.1753 25.762C28.1633 24.5086 28.7784 23.0024 28.9504 21.4157C29.1223 19.8291 28.8441 18.226 28.1475 16.7901C27.4509 15.3542 26.3642 14.1434 25.0116 13.2962C23.659 12.4491 22.0952 11.9999 20.4993 12ZM13.9993 20.5C13.9993 18.7761 14.6841 17.1228 15.9031 15.9038C17.1221 14.6848 18.7754 14 20.4993 14C22.2232 14 23.8765 14.6848 25.0955 15.9038C26.3145 17.1228 26.9993 18.7761 26.9993 20.5C26.9993 22.2239 26.3145 23.8772 25.0955 25.0962C23.8765 26.3152 22.2232 27 20.4993 27C18.7754 27 17.1221 26.3152 15.9031 25.0962C14.6841 23.8772 13.9993 22.2239 13.9993 20.5Z"
                                    fill="white" />
                            </svg>
                        </a>
                    </div>
                </form>
                <a class="btn-primary-new-outline" href="/login">Login </a>
                @if (\App\Services\AppConfig::get()->app->app_info->is_signup_btn_show === 'Y')
                    <a class="btn-primary-new" href="/signup">Sign Up</a>
                @endif

            </nav>
        </header>
        @if (isset($data->app->landingpages))
            @foreach ($data->app->landingpages as $page)
                @if ($page->page_type === 'lyra' && $page->section_type === 'banner' && $page->status === 1)
                    <div class="position-relative overflow-hidden p-3 p-md-5 text-center">
                        <img src="{{ asset('assets/landing_theme_assets/lyra/images/circle.png') }}" class="circle_image" />
                        <div
                            class="col-md-8 p-lg-8 mx-auto my-8 position-absolute top-50 start-50 translate-middle d-flex flex-column justify-content-center align-items-center circle_text">
                            <h1 class="display-4 unlimmited_headers text-center">
                                {{ $page->title ?? '' }}
                            </h1>

                            <h1 class="cards_headtitles">
                                @if (isset($page->subtitle))
                                    @php
                                        $titleWords = explode(' ', $page->subtitle);
                                        $firstWord = $titleWords[0] ?? '';
                                        $secondWord = $titleWords[1] ?? '';

                                        $remainingWords = implode(' ', array_slice($titleWords, 2)); // Concatenate remaining words
                                    @endphp
                                    <span>{{ $firstWord }}</span> {{ $secondWord }} <h4>{{ $remainingWords }}</h4>
                                @else
                                @endif
                            </h1>

                            <p class="leadinsttiltes">
                                @if (isset($page->description))
                                    {{ \Illuminate\Support\Str::words($page->description, 35, '...') }}
                                @endif
                            </p>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
        @if (isset($data->app->landingpages))
            @foreach ($data->app->landingpages as $page)
                @if ($page->page_type === 'lyra' && $page->section_type === 'membership' && $page->status === 1)
                    <div class="row d-flex align-items-center justify-content-center m-auto text-white py-3">
                        <div class="col-md-6">
                            <div class=" row d-flex align-items-center justify-content-center gap-3 flex-column mb-7">
                                <div class="col-md-12">
                                    <h4 class="text-center text-white membership_dec">
                                        @if (isset($page->description))
                                            @php
                                                $titleWords = explode(' ', $page->description);
                                                $firstWord = $titleWords[0] ?? '';
                                                $secondWord = $titleWords[1] ?? '';
                                                $thirdWord = $titleWords[2] ?? '';
                                                $remainingWords = implode(' ', array_slice($titleWords, 3)); // Concatenate remaining words
                                            @endphp
                                            <span>{{ $firstWord }} {{ $secondWord }} {{ $thirdWord }}</span>
                                            {{ $remainingWords }}
                                        @else
                                        @endif
                                    </h4>
                                </div>
                                <div class="col-md-12">
                                    <div class="membership d-flex justify-content-between">
                                        <input type="text" name="email" id="email" placeholder="Enter Email">
                                        <a href=""
                                            id="submit"class="text-decoration-none text-white border-2  custom__button">Get
                                            Started</a>
                                    </div>
                                    <span
                                        class="d-flex align-items-center justify-content-center text-danger email-error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
        @if (isset($data->app->landingpages))
            @foreach ($data->app->landingpages as $page)
                @if ($page->page_type === 'lyra' && $page->section_type === 'section' && $page->status === 1 && $page->order === 1)
                    @if (!empty($page->appstore_link) || !empty($page->playstore_link))
                        <div class="apps__links mt-5">
                            <h5 style="display: inline-block"> {{ $page->title ?? '' }}</h5>
                            <div class="d-flex  align-items-center gap-3">
                                @if (!empty($page->appstore_link))
                                    <div>
                                        <a href="{{ $page->appstore_link ?? '' }}"><img
                                                src="{{ asset('assets/landing_theme_assets/iris/images/play.png') }}"
                                                style="max-width: 240px;" alt="" srcset=""></a>
                                    </div>
                                @endif
                                @if (!empty($page->playstore_link))
                                    <div>
                                        <a href="{{ $page->playstore_link ?? '' }}"><img
                                                src="{{ asset('assets/landing_theme_assets/iris/images/apple.png') }}"
                                                style="max-width: 240px;" alt="" srcset=""></a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        @endif
    </div>
    <!-- END: Hero Section -->
    <!-- START: App stores Section -->
    @if (isset($data->app->landingpages))
        @foreach ($data->app->landingpages as $page)
            @if ($page->page_type === 'lyra' && $page->section_type === 'section' && $page->status === 1 && $page->order === 2)
                <div class="sec-video d-flex flex-column justify-content-center align-items-center text-center mb-5 mt-5">
                    <div class="col-8 mx-auto">
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
                    <div class="col-12 mx-auto gap-1 mt-2 py-5 owl-carousel stream-icons">
                        @foreach (explode(',', $page->icon) as $iconUrl)
                            @if ($iconUrl)
                                <img src="{{ $iconUrl }}" class="me-3" max-width="100%">
                            @endif
                        @endforeach

                    </div>
                </div>
            @endif
        @endforeach
    @endif
    <!-- End: App stores Section -->
    <!-- START: Section Devices Section -->
    @if (isset($data->app->landingpages))
        @foreach ($data->app->landingpages as $page)
            @if ($page->page_type === 'lyra' && $page->section_type === 'section' && $page->status === 1 && $page->order === 3)
                <div
                    class="sec-device tab-content active-device d-flex flex-column justify-content-center align-items-center text-center d-none mt-5">
                    <div class="col-8 mx-auto">
                        @if (isset($page->title))
                            @php
                                $titleWords = explode(' ', $page->title);
                                $firstWord = $titleWords[0] ?? '';
                                $secondWord = $titleWords[1] ?? '';
                                $thirdWord = $titleWords[2] ?? '';
                                $remainingWords = implode(' ', array_slice($titleWords, 3)); // Concatenate remaining words
                            @endphp
                            <h1>{{ $firstWord }} {{ $secondWord }} {{ $thirdWord }}
                                <span>{{ $remainingWords }}</span>
                            </h1>
                        @else
                        @endif
                        <p>{{ $page->description ?? '' }}</p>
                    </div>
                </div>
            @endif
            @if ($page->page_type === 'lyra' && $page->section_type === 'section' && $page->status === 1 && $page->order === 4)
                <div
                    class="sec-device tab-content d-flex flex-column justify-content-center align-items-center text-center d-none mt-5">
                    <div class="col-8 mx-auto">
                        @if (isset($page->title))
                            @php
                                $titleWords = explode(' ', $page->title);
                                $firstWord = $titleWords[0] ?? '';
                                $secondWord = $titleWords[1] ?? '';
                                $thirdWord = $titleWords[2] ?? '';
                                $remainingWords = implode(' ', array_slice($titleWords, 3)); // Concatenate remaining words
                            @endphp
                            <h1>{{ $firstWord }} {{ $secondWord }} {{ $thirdWord }}
                                <span>{{ $remainingWords }}</span>
                            </h1>
                        @else
                        @endif
                        <p>{{ $page->description ?? '' }}</p>
                    </div>
                </div>
            @endif
            @if ($page->page_type === 'lyra' && $page->section_type === 'section' && $page->status === 1 && $page->order === 5)
                <div
                    class="sec-device tab-content d-flex flex-column justify-content-center align-items-center text-center d-none mt-5">
                    <div class="col-8 mx-auto">
                        @if (isset($page->title))
                            @php
                                $titleWords = explode(' ', $page->title);
                                $firstWord = $titleWords[0] ?? '';
                                $secondWord = $titleWords[1] ?? '';
                                $thirdWord = $titleWords[2] ?? '';
                                $remainingWords = implode(' ', array_slice($titleWords, 3)); // Concatenate remaining words
                            @endphp
                            <h1>{{ $firstWord }} {{ $secondWord }} {{ $thirdWord }}
                                <span>{{ $remainingWords }}</span>
                            </h1>
                        @else
                        @endif
                        <p>{{ $page->description ?? '' }}</p>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
    @if (isset($data->app->landingpages))
        @foreach ($data->app->landingpages as $page)
            @if ($page->page_type === 'lyra' && $page->section_type === 'section' && $page->status === 1 && $page->order === 3)
                <div class="tab-btns d-flex justify-content-center align-items-center text-center gap-5">
                    <div class="active" data-target="tv-details"><span>TV</span></div>
                    <div data-target="tablet-details"><span>Tablet & Mobile</span></div>
                    <div data-target="desktop-details"><span>Desktop & Laptop</span></div>
                </div>
            @endif
        @endforeach
    @endif
    @if (isset($data->app->landingpages))
        @foreach ($data->app->landingpages as $page)
            @if ($page->page_type === 'lyra' && $page->section_type === 'section' && $page->status === 1 && $page->order === 3)
                <div class="container mt-3 active-device d-none tab-image"
                    style="background-color: rgba(255, 255, 255, 0.048)">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <img src="{{ $page->image }}" class="img-fluid" alt="TV Image">
                        </div>
                    </div>
                </div>
            @endif
            @if ($page->page_type === 'lyra' && $page->section_type === 'section' && $page->status === 1 && $page->order === 4)
                <div class="container mt-3 d-none tab-image" style="background-color: rgba(255, 255, 255, 0.048)">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <img src="{{ $page->image }}" class="img-fluid" alt="Tablet & Mobile Image">
                        </div>
                    </div>
                </div>
            @endif
            @if ($page->page_type === 'lyra' && $page->section_type === 'section' && $page->status === 1 && $page->order === 5)
                <div class="container mt-3 d-none tab-image" style="background-color: rgba(255, 255, 255, 0.048)">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <img src="{{ $page->image }}" class="img-fluid" alt="Desktop & Laptop Image">
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
    <!-- END: Section Devices Section -->
    <!-- START: watch now Section -->
    @if (isset($data->app->landingpages))
        @foreach ($data->app->landingpages as $page)
            @if ($page->page_type === 'lyra' && $page->section_type === 'section' && $page->status === 1 && $page->order === 6)
                <section class="tv__links">
                    <div class="tv__icons m-auto w-25 ">
                        <div class=" d-flex gap-5 align-items-center justify-content-center py-4 ">
                            <p class="p-0 m-0 watch__now">Watch Here</p>
                            <div class="col-md-4 d-flex  align-items-center gap-2 app__icons">
                                <div><a class="text-center"><img
                                            src="https://onlinechannel.io/storage/images/landing_page/icons/WatchHere_2024-04-23_04-58-57_66277851d69c4.png"
                                            alt="" srcset=""></a></div>
                                <div><a class="text-center"><img
                                            src="https://onlinechannel.io/storage/images/landing_page/icons/WatchHere_2024-04-23_04-58-57_66277851d6c0d.png"
                                            alt="" srcset=""></a></div>
                                <div><a class="text-center"><img
                                            src="https://onlinechannel.io/storage/images/landing_page/icons/WatchHere_2024-04-23_04-58-57_66277851d6d5e.png"
                                            alt="" srcset=""></a></div>
                            </div>
                        </div>
                        <div class=" d-flex gap-5 align-items-center justify-content-center py-4 ">
                            <a href="/download-apps"
                                class="text-decoration-none text-white border-2 rounded-pill custom__button">Download</a>

                        </div>
                    </div>
                </section>
            @endif
        @endforeach
    @endif
    <!-- END: watch now Section -->
    <!-- START: FAQ Section -->
    <!-- Start FAQ-->
    @if (isset($data->app->landingpages) &&
            array_reduce(
                $data->app->landingpages,
                fn($carry, $item) => $carry || ($item->section_type === 'faq' && $item->page_type === 'lyra'),
                false))
        <div class="d-flex align-items-center text-center justify-content-center mb-3">
            <div class="leftinpars sec-device">
                <h1>Frequently Asked <span>Questions</span></h1>
            </div>
        </div>
        <div class="row justify-content-center mb-5 mt-3" style="max-width: 100%;">
            @foreach ($data->app->landingpages as $page)
                @if ($page->page_type === 'lyra' && $page->section_type === 'faq' && $page->status === 1)
                    <div class="col-sm-12 col-md-8 col-lg-8 text-center">
                        <div class="accrodingin">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne{{ $loop->index }}">
                                        <button class="accordion-button faq_question collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapseOne{{ $loop->index }}" aria-expanded="false"
                                            aria-controls="flush-collapseOne{{ $loop->index }}">
                                            {{ $page->title ?? '' }} <svg id="thin-x" viewBox="0 0 26 26"
                                                class="svg-icon svg-icon-thin-x svg-closed" focusable="true">
                                                <path
                                                    d="M10.5 9.3L1.8 0.5 0.5 1.8 9.3 10.5 0.5 19.3 1.8 20.5 10.5 11.8 19.3 20.5 20.5 19.3 11.8 10.5 20.5 1.8 19.3 0.5 10.5 9.3Z">
                                                </path>
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne{{ $loop->index }}" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample"
                                        style="background: black">
                                        <div class="accordion-body acrodinbibody">{{ $page->description ?? '' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
    <!-- END: FAQ Section -->
    <footer>
        <div class="row mt-5">
            <div class="col-md-3 mb-3">
                <a href="/home">
                    <img class="img-fluid mb-4" src="{{ $data->app->app_info->website_logo ?? '' }}" alt=""
                        srcset="" width="150px">
                </a>
                <p class="p-0 m-0 text-white">Powered By</p>
                <p class="p-0 m-0 text-white">{{ $data->app->app_info->app_name ?? '' }}</p>
            </div>
            <div class="col-md-3 ">
                <h5 class="mb-4"><span>GET</span> TO KNOW US</h5>
                <ul class="d-flex align-items-start flex-column list-unstyled">
                    @foreach (\App\Services\AppConfig::get()->app->data->pages as $page)
                        @if ($page->displayOn === 'F' || $page->displayOn === 'B')
                            <li><a href="/page/{{ $page->page_slug }}"
                                    class="text-decoration-none text-white lh-lg">{{ $page->page_title }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3">
                <h5 class="mb-4"><span>TOP</span> CATEGORIES</h5>
                <ul class="d-flex align-items-start flex-column list-unstyled ">
                    @foreach (\App\Services\AppConfig::get()->app->footer_categories as $category)
                        <li><a href="{{ route('category', $category->cat_guid) }}"
                                class="text-decoration-none text-white lh-lg">{{ $category->cat_title }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3">
                <h5 class="mb-4"><span>LET US</span> HELP YOU</h5>
                <ul class="d-flex align-items-start flex-column list-unstyled ">
                    <li><a href="/login" class="text-decoration-none text-white lh-lg">Login</a></li>
                    <li><a href="/signup" class="text-decoration-none text-white lh-lg">Register</a></li>
                    <li><a href="/download-apps" class="text-decoration-none text-white lh-lg">Download Apps</a></li>
                </ul>
            </div>

        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="footer_rights">
                        <span class="copyright">© {{ \App\Services\AppConfig::get()->app->app_info->app_name }}</span>
                        {{ date('Y') }}-{{ date('Y', strtotime('+1 years')) }} ALL RIGHTS RESERVED.
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endsection
@section('scripts')
    @include('components.includes.script1')
    <script>
        function dropdownHandle(e) {
            $(`.profiledropin:eq(${$(e).data('index')})`).slideToggle();
        }

        (function() {
            const tabBtns = document.querySelectorAll('.tab-btns > div');
            const tabContents = document.querySelectorAll('.tab-content');
            const tabImages = document.querySelectorAll('.tab-image');
            console.log(tabBtns, tabContents, tabImages);
            tabBtns.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    if (!tabContents[index] && !tabImages[index]) {
                        return;
                    }
                    document.querySelector('.tab-btns .active').classList.remove('active');
                    document.querySelector('.tab-content.active-device').classList.remove(
                        'active-device');
                    document.querySelector('.tab-image.active-device').classList.remove(
                        'active-device');
                    btn.classList.add('active');
                    tabContents[index]?.classList.add('active-device');
                    tabImages[index]?.classList.add('active-device');
                });
            });
        })();
    </script>
    <!-- Link Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            var owl = $('.owl-carousel').owlCarousel({
                loop: false,
                items: 1,
                margin: 10,
                nav: false, // Hide navigation buttons
                dots: false, // Hide pagination dots
                autoplay: true, // Enable autoplay
                autoplayTimeout: 2000, // Initial autoplay interval in milliseconds
                autoplayHoverPause: true, // Pause autoplay on hover
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 7
                    }
                }
            });
        });
    </script>
@endsection
