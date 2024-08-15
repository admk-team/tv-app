@extends('components.layouts.landingpage_layout')

@section('head')
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!-- font -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
    integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap"
    rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/mean/css/style.css') }}">
@endsection

@section('content')
    <!-- Navigation Start  -->
    <nav class="navbar navbar-expand-lg fixed-top border-bottom-0">
        <div class="container-fluid">
            <a class="navbar-brand img-fluid" href="/home"><img alt="logo"
                    src="{{ $data->app->app_info->website_logo ?? '' }}" width="100px" class="img-fluid" /></a>
            <a href="/home?browse=true" class="text-decoration-none text-white-costum border-2 rounded-pill">Browse Content</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-white-costum"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                   @if (session()->has('USER_DETAILS') && session('USER_DETAILS') !== null)
                        <div class="dropdown dropdin">
                            <div class="nav_btnlink" id="dropdownMenuLink1" onclick="dropdownHandle(this)" data-index=0>
                                <div class="userimg">{{ session('USER_DETAILS')['USER_NAME'][0] }}</div>
                            </div>
                            <ul class="dropdown_menus profiledropin avtartMenu" style="display: none;">
                                <li style="display: none;"><a href="update-profile.php"><span
                                            class="userno">user-26</span></a></li>
                                <li><a class="text-decoration-none" href="{{ route('profile.index') }}">Profiles</a>
                                </li>
                                <li><a class="text-decoration-none"
                                        href="{{ route('profile.manage', session('USER_DETAILS')['USER_ID']) }}">Manage
                                        Profiles</a></li>
                                {{-- <li><a class="text-decoration-none" href="{{ route('transaction-history') }}">Transaction
                            History</a></li> --}}
                                <li><a class="text-decoration-none" href="{{ route('password.edit') }}">Change
                                        Password</a>
                                </li>
                                @if (\App\Services\AppConfig::get()->app->app_info->watch_history === 1)
                                    <li><a class="text-decoration-none" href="{{ route('watch.history') }}">Watch
                                            History</a>
                                    </li>
                                @endif
                                <li><a class="text-decoration-none" href="{{ route('logout') }}">Logout</a></li>
                            </ul>
                        </div>
                    @else
                        <a class="text-white-costum btn btn-primary px-4 me-2" href="/login">Sign In </a>
                        @if (\App\Services\AppConfig::get()->app->app_info->is_signup_btn_show === 'Y')
                            <a class="text-white-costum btn btn-primary px-4" href="/signup">Sign Up</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Navigation End  -->

    <!-- Main Slider Section -->
    <section>
        @if (isset($data->app->landingpages))
            @foreach ($data->app->landingpages as $page)
                @if ($page->page_type === 'AJV' && $page->section_type === 'banner' && $page->status === 1)
                    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="bg-crimsonblack">
                                    <video autoplay playsinline muted loop>
                                        <!-- <source src="homepage-video.webm" type="video/webm"> -->
                                        <source src=" {{ $page->video_url ?? '' }}" type="video/mp4">
                                    </video>
                                    <div class="carousel-caption">
                                        @if (isset($page->title))
                                            <h1 class="fw-bold">{{ $page->title ?? '' }}</h1>
                                        @endif
                                        <p style="display:none;">
                                            {{ $page->description ?? '' }}

                                        </p>
                                        @if (\App\Services\AppConfig::get()->app->app_info->is_signup_btn_show === 'Y')
                                            <a class="text-white-costum btn btn-primary px-4" href="/signup">Sign Up</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button> -->
                    </div>
                @endif
            @endforeach
    </section>
    <!-- Main Slider Section End -->
    @foreach ($data->app->landingpages as $page)
        @if ($page->page_type === 'AJV' && $page->section_type === 'tv_section')
            <section class="bg-black our-story-card">
                <div class="container py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="fw-bold text-white-costum">{{ $page->title ?? '' }}</h2>
                            <h5 class="text-white-costum">
                                {{ $page->description ?? '' }}
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative">
                                {{--  <img src="  {{ asset('assets/landing_theme_assets/mean/images/tv.png') }}"
                                    class="img-fluid">  --}}
                                <img src=" {{ $page->image }}" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        @if ($page->page_type === 'AJV' && $page->section_type === 'tablet_section')
            <section class="bg-black our-story-card">
                <div class="container py-5">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center">
                            <div class="position-relative">
                                <img src=" {{ $page->image }}" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h2 class="fw-bold text-white-costum">{{ $page->title ?? '' }}</h2>
                            <h5 class="text-white-costum">
                                {{ $page->description ?? '' }}
                            </h5>
                        </div>
                    </div>
                </div>
            </section>
            @endif
            @endforeach
            @foreach ($data->app->landingpages as $page)
            @if ($page->page_type === 'AJV' && $page->section_type === 'desktop_section')
                <section class="bg-black our-story-card">
                    <div class="container py-5">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h2 class="fw-bold text-white-costum">{{ $page->title ?? '' }}</h2>
                                <h5 class="text-white-costum">
                                    {{ $page->description ?? '' }}
                                </h5>
                                @endif
                                @endforeach
                                @foreach ($data->app->landingpages as $page)
                                @if ($page->page_type === 'AJV' && $page->section_type === 'watch_now')
                                    <ul class="list-unstyled d-flex flex-wrap fs-5 text-secondary mt-3">
                                        <li>{{ $page->title ?? '' }}</li>
                                        @foreach (explode(',', $page->icon) as $iconUrl)
                                            <li><img src="{{ $iconUrl }}" width="50"> </li>
                                        @endforeach
                                    </ul>
                                    <a href="/download-apps"><button class="btn btn-primary">Download Now</button></a>
                                    @endif
                                    @endforeach
                                    @foreach ($data->app->landingpages as $page)
                                @if ($page->page_type === 'AJV' && $page->section_type === 'desktop_section')
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative">
                                    <img src="{{ $page->image }}" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endforeach
        @endif
    <!-- Section: FAQ -->
    @if (isset($data->app->landingpages) &&
            array_reduce(
                $data->app->landingpages,
                fn($carry, $item) => $carry || ($item->section_type === 'faq' && $item->page_type === 'AJV'),
                false))
        <section class="bg-black our-story-card">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h1 class="text-center mb-5">Frequently Asked Questions</h1>
                        <div class="accordion" id="accordionExample">
                            @foreach ($data->app->landingpages as $page)
                                @if ($page->page_type === 'AJV' && $page->section_type === 'faq' && $page->status === 1)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button fs-5 fw-bold" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne{{ $loop->index }}" aria-expanded="true"
                                                aria-controls="collapseOne{{ $loop->index }}">
                                                {{ $page->title ?? '' }}
                                            </button>
                                        </h2>
                                        <div id="collapseOne{{ $loop->index }}" class="accordion-collapse collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                {{ $page->description ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </section>
    @endif

    @if (isset($data->app->landingpages))
        @foreach ($data->app->landingpages as $page)
            @if ($page->page_type === 'AJV' && $page->section_type === 'membership' && $page->status === 1)
                <!-- Section: Social media -->
                <section class="bg-black our-story-card py-1">
                    <div class="container">
                        <div class="row justify-content-center p-4">
                            <div class="col-12 col-md-8 col-xl-8 text-center">
                                <h5 class="text-white-costum mb-3">
                                    {{ $page->description ?? '' }}
                                </h5>
                                <form id="form">
                                    <div class="input-group mb-3">
                                        <input type="email" name="email" id="email" class="form-control p-3"
                                            placeholder="Email Address" aria-label="Recipient's username"
                                            aria-describedby="button-addon2">
                                        <button class="btn btn-primary p-3" type="button" id="submit">Get
                                            Started</button>
                                    </div>
                                    <span class="text-danger email-error"></span> <!-- Error message span -->
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endforeach
    @endif
    <!-- Footer -->

    <!-- Section: Links  -->
    <section class="bg-black text-grey p-0">
        <div class="container text-center text-md-start pt-1">
            <!-- Grid row -->
            <div class="row mt-3">
                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4 text-white-costum">
                        Get to Know Us
                    </h6>
                    @foreach (\App\Services\AppConfig::get()->app->data->pages as $page)
                        @if ($page->displayOn === 'F' || $page->displayOn === 'B')
                           <p class="text-white-costum">
                                <a class="text-reset" href="/page/{{ $page->page_slug }}">{{ $page->page_title }}</a>
                            </p>
                        @endif
                    @endforeach

                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4 text-white-costum">
                        Top Categories
                    </h6>
                    @foreach (\App\Services\AppConfig::get()->app->footer_categories as $category)
                       <p class="text-white-costum">
                            <a class="text-reset"
                                href="{{ route('category', $category->cat_guid) }}">{{ $category->cat_title }}</a>
                        </p>
                    @endforeach
                </div>
                <!-- Grid column -->
                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4 text-white-costum">
                        Let Us Help You
                    </h6>
                   <p class="text-white-costum">
                        <a href="/login" class="text-reset">Login</a>
                    </p>
                    @if (\App\Services\AppConfig::get()->app->app_info->is_signup_btn_show === 'Y')
                       <p class="text-white-costum">
                            <a href="/signup" class="text-reset">Register</a>
                        </p>
                    @endif
                   <p class="text-white-costum">
                        <a href="/download-apps" class="text-reset">Download Apps</a>
                    </p>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links  -->
    <!-- Copyright -->
    <div class="container-fluid footer_bottom">
        <div class="row justify-content-sm-center justify-content-md-between p-2">
            <div class="col-md-6 text-white fs-14px">
                © {{ $data->app->app_info->app_name ?? '' }}
                {{ date('Y') }}-{{ date('Y', strtotime('+1 years')) }} ALL RIGHTS RESERVED. </div>
            <div class="col-md-6 text-end text-white">
                @foreach (\App\Services\AppConfig::get()->app->social_media->links as $link)
                    <a href="{{ $link->url }}" target="_blank" class="me-3 text-reset">
                        <img src="{{ $link->icon }} " style="width: 30px;">
                    </a>
                @endforeach
                {{--  <a href="Youtube.com/@24flix" target="_blank" class="me-4 text-reset">
                    <i class="fab fa-youtube"></i>
                </a>

                <a href="Facebook.com/24flix" target="_blank" class="me-4 text-reset">
                    <i class="fab fa-facebook-f"></i>  --}}
                </a>
            </div>
        </div>
    </div>
    <!-- Copyright -->
    </footer>
    <!-- Footer -->
@endsection
@section('scripts')
    @include('components.includes.script1')
    <script>
        function dropdownHandle(e) {
            $(`.profiledropin:eq(${$(e).data('index')})`).slideToggle();
        }
    </script>
@endsection
