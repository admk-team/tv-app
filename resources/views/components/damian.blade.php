@extends('components.layouts.landingpage_layout')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/landing_theme_assets/damian/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    {{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js"></script>  --}}
@endsection

@section('content')
    <div class="wrapper">

        <!-- Navbar  -->
        <nav class="py-3 navbar navbar-expand-lg navbar-dark bg-transparent">
            <div class="container">
                <a class="navbar-brand logo__item list-unstyled" href="/home"><img
                        src="{{ $data->app->app_info->website_logo ?? '' }}" alt="Logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon" style="color: white;"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a href="/home?browse=true"
                                class="nav-link text-decoration-none text-light">Browse
                                Content</a></li>
                        <li class="nav-item me-2"><a href="/searchscreen" class="nav-link text-decoration-none text-light">
                                <svg width="30" height="30" viewBox="0 0 42 42" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="21" cy="21" r="20.6" stroke="white" stroke-width="0.8" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M20.4993 12C19.1439 12.0001 17.8081 12.3244 16.6035 12.9457C15.3989 13.567 14.3604 14.4674 13.5745 15.5718C12.7887 16.6761 12.2783 17.9523 12.086 19.294C11.8937 20.6357 12.025 22.004 12.4691 23.2846C12.9131 24.5652 13.6569 25.7211 14.6385 26.6557C15.6201 27.5904 16.811 28.2768 18.1118 28.6576C19.4126 29.0384 20.7856 29.1026 22.1163 28.8449C23.447 28.5872 24.6967 28.015 25.7613 27.176L29.4133 30.828C29.6019 31.0102 29.8545 31.111 30.1167 31.1087C30.3789 31.1064 30.6297 31.0012 30.8151 30.8158C31.0005 30.6304 31.1057 30.3796 31.108 30.1174C31.1102 29.8552 31.0094 29.6026 30.8273 29.414L27.1753 25.762C28.1633 24.5086 28.7784 23.0024 28.9504 21.4157C29.1223 19.8291 28.8441 18.226 28.1475 16.7901C27.4509 15.3542 26.3642 14.1434 25.0116 13.2962C23.659 12.4491 22.0952 11.9999 20.4993 12ZM13.9993 20.5C13.9993 18.7761 14.6841 17.1228 15.9031 15.9038C17.1221 14.6848 18.7754 14 20.4993 14C22.2232 14 23.8765 14.6848 25.0955 15.9038C26.3145 17.1228 26.9993 18.7761 26.9993 20.5C26.9993 22.2239 26.3145 23.8772 25.0955 25.0962C23.8765 26.3152 22.2232 27 20.4993 27C18.7754 27 17.1221 26.3152 15.9031 25.0962C14.6841 23.8772 13.9993 22.2239 13.9993 20.5Z"
                                        fill="white" />
                                </svg></a></li>
                        <li class="nav-item me-2 mb-2"><a href="/login"
                                class="nav-link text-decoration-none custom-btn">Login</a></li>
                        @if (\App\Services\AppConfig::get()->app->app_info->is_signup_btn_show === 'Y')
                            <li class="nav-item me-2"><a href="/signup"
                                    class="nav-link text-decoration-none custom-btn active">SignUp</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @if (isset($data->app->landingpages))
            @foreach ($data->app->landingpages as $page)
                @if ($page->page_type === 'damian' && $page->section_type === 'banner' && $page->status === 1)
                    <!-- Hero Text  -->
                    <div class="container">
                        <section class="hero__section py-5 ">
                            <div class="col-md-5">
                                <h5> {{ $page->title ?? '' }}</h5>
                                <h1> {{ $page->subtitle ?? '' }}</h1>
                            </div>
                            <div class="line"></div>
                            <div class="col-md-5">
                                <p class="mb-4">
                                    @if (isset($page->description))
                                        {{ \Illuminate\Support\Str::words($page->description, 35, '...') }}
                                    @endif
                                </p>
                                <a href="/signup" class="custom-btn">Get Started</a>
                            </div>
                        </section>
                    </div>
                    <!-- Video  -->
                    @if (isset($page->video_url))
                        <section class="container">
                            <div class="hero__video my-4">
                                <video autoplay playsinline muted loop>
                                    <source src="{{ $page->video_url ?? '' }}" type="video/mp4">
                                </video>
                            </div>
                        </section>
                    @endif
                    <!-- Brand Logos  -->
                    <div class="brand__logos container">
                        <div class="d-flex align-items-center justify-content-between gap-5 py-2">
                                @foreach (explode(',', $page->icon) as $iconUrl)
                                    @if ($iconUrl)
                                    <div class="logo-item">
                                        <img src="{{ $iconUrl }}" width="100px" alt="" srcset="">
                                    </div>
                                    @endif
                                @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
    <!-- Stream  -->
    <div class="stream">
        <div class="container">
            @if (isset($data->app->landingpages))
                @foreach ($data->app->landingpages as $page)
                    @if ($page->page_type === 'damian' && $page->section_type === 'section' && $page->status === 1 && $page->order === 1)
                        @if (!empty($page->appstore_link) || !empty($page->playstore_link))
                            <div class="download__now ">
                                <h3 class="m-0">
                                    @if (isset($page->title))
                                        @php
                                            $titleWords = explode(' ', $page->title);
                                            $firstWord = $titleWords[0] ?? '';
                                            $remainingWords = implode(' ', array_slice($titleWords, 1)); // Concatenate remaining words
                                        @endphp
                                        {{ $firstWord }}<span class="span-color"> {{ $remainingWords }}</span>
                                    @else
                                    @endif
                                </h3>
                                <div class="playstore__images d-flex align-items-center justify-content-center">
                                    @if (!empty($page->appstore_link))
                                        <div><a href="{{ $page->appstore_link ?? '' }}"><img
                                                    src="{{ asset('assets/landing_theme_assets/damian/images/gogleplay.png') }}"
                                                    alt=""></a>
                                        </div>
                                    @endif
                                    @if (!empty($page->playstore_link))
                                        <div> <a href="{{ $page->playstore_link ?? '' }}"><img
                                                    src="{{ asset('assets/landing_theme_assets/damian/images/apple-store.png') }}"
                                                    alt="">
                                            </a></div>
                                    @endif


                                </div>
                            </div>
                        @endif
                    @endif
                    @if ($page->page_type === 'damian' && $page->section_type === 'section' && $page->status === 1 && $page->order === 2)
                        <div class="device-data">
                            <h1 class="text-center">
                                @if (isset($page->title))
                                    @php
                                        $titleWords = explode(' ', $page->title);
                                        $firstWord = $titleWords[0] ?? '';
                                        $secondWord = $titleWords[1] ?? '';
                                        $thirdWord = $titleWords[2] ?? '';
                                        $remainingWords = implode(' ', array_slice($titleWords, 3)); // Concatenate remaining words
                                    @endphp
                                    <h1 class="text-center">{{ $firstWord }} {{ $secondWord }} {{ $thirdWord }}
                                        <span class="span-color">{{ $remainingWords }}</span>
                                    </h1>
                                @else
                                @endif
                                <p class="text-center">{{ $page->description ?? '' }}</p>
                        </div>
                    @endif
                    @if ($page->page_type === 'damian' && $page->section_type === 'section' && $page->status === 1 && $page->order === 3)
                        <div class="device-data d-none">
                            <h1 class="text-center">
                                @if (isset($page->title))
                                    @php
                                        $titleWords = explode(' ', $page->title);
                                        $firstWord = $titleWords[0] ?? '';
                                        $secondWord = $titleWords[1] ?? '';
                                        $thirdWord = $titleWords[2] ?? '';
                                        $remainingWords = implode(' ', array_slice($titleWords, 3)); // Concatenate remaining words
                                    @endphp
                                    <h1 class="text-center">{{ $firstWord }} {{ $secondWord }} {{ $thirdWord }}
                                        <span class="span-color">{{ $remainingWords }}</span>
                                    </h1>
                                @else
                                @endif
                                <p class="text-center">{{ $page->description ?? '' }}</p>
                        </div>
                    @endif
                    @if ($page->page_type === 'damian' && $page->section_type === 'section' && $page->status === 1 && $page->order === 4)
                        <div class="device-data d-none">
                            <h1 class="text-center">
                                @if (isset($page->title))
                                    @php
                                        $titleWords = explode(' ', $page->title);
                                        $firstWord = $titleWords[0] ?? '';
                                        $secondWord = $titleWords[1] ?? '';
                                        $thirdWord = $titleWords[2] ?? '';
                                        $remainingWords = implode(' ', array_slice($titleWords, 3)); // Concatenate remaining words
                                    @endphp
                                    <h1 class="text-center">{{ $firstWord }} {{ $secondWord }} {{ $thirdWord }}
                                        <span class="span-color">{{ $remainingWords }}</span>
                                    </h1>
                                @else
                                @endif
                                <p class="text-center">{{ $page->description ?? '' }}</p>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <div class="stream__screens container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="col-md-3">
                    <div class="progress-container">
                        <div id="progress"></div>
                        <div class="circle active">
                            <p class="m-0 text-center">TV</p>
                        </div>
                        <div class="circle">
                            <p class="m-0 text-center">Tablet & Mobile</p>
                        </div>
                        <div class="circle">
                            <p class="m-0 text-center">Desktop & Laptop</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="stream__images">
                        @if (isset($data->app->landingpages))
                            @foreach ($data->app->landingpages as $page)
                                @if ($page->page_type === 'damian' && $page->section_type === 'section' && $page->status === 1 && $page->order === 2)
                                    <div class="tv_images">
                                        <img src="{{ $page->image ?? '' }}" alt="">
                                    </div>
                                @endif
                                @if ($page->page_type === 'damian' && $page->section_type === 'section' && $page->status === 1 && $page->order === 3)
                                    <div class="tv_images d-none">
                                        <img src="{{ $page->image ?? '' }}" alt="">
                                    </div>
                                @endif
                                @if ($page->page_type === 'damian' && $page->section_type === 'section' && $page->status === 1 && $page->order === 4)
                                    <div class="tv_images d-none">
                                        <img src="{{ $page->image ?? '' }}" alt="">
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQs  -->
    @if (isset($data->app->landingpages) &&
            array_reduce(
                $data->app->landingpages,
                fn($carry, $item) => $carry || ($item->section_type === 'faq' && $item->page_type === 'damian'),
                false))
        <section class="faqs">
            <h1 class="text-center pt-2">Frequently Asked <span class="span-color">Questions</span></h1>
            {{--  <p class="text-center m-auto w-75 my-2">You can find 24 Flix on all of the major App Stores including</p>  --}}

            <div class="faqs__accordion container p-0">
                @foreach ($data->app->landingpages as $page)
                    @if ($page->page_type === 'damian' && $page->section_type === 'faq' && $page->status === 1)
                        <button class="accordion">
                            <p>{{ $page->title ?? '' }}</p> <span class="plus-icon">&#43;</span>
                        </button>
                        <div class="panel">
                            <p>{{ $page->description ?? '' }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
    @endif
    <!-- memebership  -->
    @if (isset($data->app->landingpages))
        @foreach ($data->app->landingpages as $page)
            @if ($page->page_type === 'lyra' && $page->section_type === 'membership' && $page->status === 1)
                <section class="membership">
                    <div class="container">
                        <div class=" row">
                            <div class="col-md-6">
                                @if (isset($page->description))
                                    @php
                                        $titleWords = explode(' ', $page->description);
                                        $firstWord = $titleWords[0] ?? '';
                                        $secondWord = $titleWords[1] ?? '';
                                        $thirdWord = $titleWords[2] ?? '';
                                        $remainingWords = implode(' ', array_slice($titleWords, 3)); // Concatenate remaining words
                                    @endphp
                                    <h1>{{ $firstWord }} {{ $secondWord }} <span
                                            class="span-color">{{ $thirdWord }}</span></h1>
                                    <p>{{ $remainingWords }}</p>
                                @else
                                @endif
                            </div>
                            <div class="col-md-6">
                                <form action="#" class="get__started">
                                    <div class="d-flex">
                                        <input class="flex-grow-1" type="text" placeholder="Enter your Email"
                                            name="email" id="email">
                                        <button id="submit" type="submit">Get Started</button>
                                    </div>
                                </form>
                                <span
                                    class="d-flex align-items-center justify-content-center text-danger email-error"></span>
                            </div>
                        </div>
                    </div>

                </section>
            @endif
        @endforeach
    @endif
    <!-- Footer  -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="text-center">
                        <a href="/home"><img src="{{ $data->app->app_info->website_logo ?? '' }}" width="140px"
                                alt="Logo"></a>
                    </div>
                    <p class="text-danger p-0 mt-3 mb-0 text-center">Powered By</p>
                    <p class="text-center">{{ $data->app->app_info->app_name ?? '' }}</p>
                </div>
                <div class="col-md-3">
                    <h5 class="mb-4">GET TO KNOW US</h5>
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
                    <h5 class="mb-4">TOP CATEGORIES</h5>
                    <ul class="d-flex align-items-start flex-column list-unstyled">
                        @foreach (\App\Services\AppConfig::get()->app->footer_categories as $category)
                            <li><a href="{{ route('category', $category->cat_guid) }}"
                                    class="text-decoration-none text-white lh-lg">{{ $category->cat_title }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="mb-4">LET US HELP YOU</h5>
                    <ul class="d-flex align-items-start flex-column list-unstyled">
                        <li><a href="/login" class="text-decoration-none text-white lh-lg">Login</a></li>
                        <li><a href="/signup" class="text-decoration-none text-white lh-lg">Register</a></li>
                        <li><a href="/download-apps" class="text-decoration-none text-white lh-lg">Download Apps</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
@endsection
@section('scripts')
    @include('components.includes.script1')
    <script>
        //Slider
        let circleItems = document.querySelectorAll('.circle');
        let device_data = document.querySelectorAll('.device-data ');
        let tvImages = document.querySelectorAll('.tv_images');
        circleItems.forEach((item, index) => {
            item.addEventListener('click', (e) => {
                circleItems.forEach(menuItem => {
                    if (menuItem !== item) {
                        menuItem.classList.remove('active');
                    }
                });
                item.classList.add('active');
                tvImages.forEach((image, i) => {
                    if (index == i) {
                        image.classList.add('d-block');
                        image.classList.remove('d-none');
                    } else {
                        image.classList.add('d-none');
                        image.classList.remove('d-block');
                    }
                });
                device_data.forEach((data, i) => {
                    if (index == i) {
                        data.classList.add('d-block');
                        data.classList.remove('d-none');
                    } else {
                        data.classList.add('d-none');
                        data.classList.remove('d-block');
                    }
                });
            });
        });


        // Accordion 
        var acc = document.getElementsByClassName("accordion");
        var i;
        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }
    </script>
@endsection
