<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $data->app->app_info->app_name ?? '' }}</title>
    <link rel="icon" href="{{ $data->app->app_info->website_faviocn ?? '' }}">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="index,follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href=" {{ asset('assets/landing_theme_assets/mean/css/style.css') }}">

    <!-- font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap"
        rel="stylesheet">

</head>

<body>
    <!-- Navigation Start  -->
    <nav class="navbar navbar-expand-lg fixed-top border-bottom-0">
        <div class="container-fluid">
            <a class="navbar-brand img-fluid" href="/home"><img alt="logo"
                    src="{{ $data->app->app_info->website_logo ?? '' }}" width="100px" class="img-fluid" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-white"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <a class="btn btn-primary px-4" href="/signin">Sign In </a>
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
                                        <source
                                            src=" {{ $page->video_url ?? 'https://player.vimeo.com/progressive_redirect/playback/830374923/rendition/720p/file.mp4?loc=external&signature=314a23119f729b0f79a31da6232ead8a19419dc7a7adb8289183ce83d4763593' }}"
                                            type="video/mp4">
                                    </video>
                                    <div class="carousel-caption">

                                        <h4> {{ $page->title ?? 'Your online cinema for unlimited access to Premium Inspirational Films' }}
                                        </h4>
                                        <p style="display:none;">
                                            {{ $page->description ?? 'Stay Healthy and Fit with a variety of fitness classes' }}
                                            Stay Healthy and Fit with a variety of fitness classes
                                        </p>
                                        <a class="btn btn-primary px-4" href="/signup">Sign Up</a>
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
        @if ($page->page_type === 'AJV' && $page->section_type === 'section' && $page->status === 1 && $page->order === 1)
            <section class="bg-black our-story-card">
                <div class="container py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="fw-bold text-white">{{ $page->title ?? 'Enjoy on your TV.' }}</h3>
                            <h4 class="text-white">
                                {{ $page->description ?? 'Watch on smart TVs, PlayStation, Xbox, Chromecast, Apple TV, Blu-ray players and more.' }}
                            </h4>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative">
                                <img src="  {{ asset('assets/landing_theme_assets/mean/images/tv.png') }}"
                                    class="img-fluid">
                                <img src=" {{ $page->image }}" class="img-fluid tv-image">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        @if ($page->page_type === 'AJV' && $page->section_type === 'section' && $page->status === 1 && $page->order === 2)
            <section class="bg-black our-story-card">
                <div class="container py-5">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center">
                            <div class="position-relative">
                                <img src=" {{ $page->image }}" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3 class="fw-bold text-white">{{ $page->title ?? 'Continue Watching & Favorites' }}</h3>
                            <h4 class="text-white">
                                {{ $page->description ??
                                    '    Continue watching exactly where you stopped and save your favorite fitness classes to watch later.' }}
                            </h4>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        @if ($page->page_type === 'AJV' && $page->section_type === 'section' && $page->status === 1 && $page->order === 3)
            <section class="bg-black our-story-card">
                <div class="container py-5">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="fw-bold text-white">{{ $page->title ?? 'Enjoy On Your TV And Mobile' }}Enjoy On
                                Your TV And Mobile</h3>
                            <h4 class="text-white">
                                {{ $page->description ??
                                    '   Access to thousands of fitness classes and videos right on your phone, table, TV or PC' }}

                            </h4>

                            <ul class="list-unstyled d-flex flex-wrap fs-5 text-secondary mt-3">
                                <li>Watch Now: </li>

                                <li><img src="  {{ asset('assets/landing_theme_assets/mean/images/roku_icon.png') }}"
                                        width="50"> </li>
                                <li><img src="   {{ asset('assets/landing_theme_assets/mean/images/firetv_icon.png') }}"
                                        width="50"></li>
                                <li><img src="  {{ asset('assets/landing_theme_assets/mean/images/appletv.png') }}"
                                        width="50"></li>
                                <li><img src=" {{ asset('assets/landing_theme_assets/mean/images/tizenapp.png') }}"
                                        width="50"></li>
                            </ul>
                            <button class="btn btn-primary">Download Now</button>
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
    <section class="bg-black our-story-card" style="display:none;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1 class="text-center mb-5">Frequently Asked Questions</h1>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button fs-5 fw-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    What is hadassah TV?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in felis
                                    dignissim, imperdiet nulla vitae, condimentum nulla. Ut scelerisque a nisl sit amet
                                    facilisis. Etiam blandit iaculis tellus, vitae condimentum leo congue a. Vivamus in
                                    vehicula massa. Pellentesque libero libero, commodo lacinia volutpat non, tincidunt
                                    at lectus. Maecenas ipsum turpis, viverra vitae lacus eu, fringilla ultricies erat.
                                    Aenean hendrerit maximus sodales.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed fs-5 fw-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                    aria-controls="collapseTwo">
                                    Where can i watch?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Quisque sapien augue, ornare id leo a, tristique elementum justo. Praesent non nulla
                                    sagittis, sollicitudin justo id, varius erat. Nunc sed pharetra nisl. Cras et
                                    suscipit felis, in lacinia sapien. Integer venenatis sagittis massa, eu eleifend
                                    nibh venenatis in. Pellentesque a aliquet urna. Curabitur tortor metus, ultrices sed
                                    mi at, sagittis imperdiet turpis. Suspendisse nec luctus nunc. Fusce in arcu quis
                                    lacus mollis ultrices.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed fs-5 fw-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                                    aria-controls="collapseThree">
                                    How do i cancel?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Praesent nec ipsum scelerisque dui condimentum pellentesque eu at lectus. Vivamus
                                    purus purus, bibendum in vestibulum ac, pharetra sit amet sapien. Nunc luctus, orci
                                    vel luctus cursus, nibh nisl ullamcorper ipsum, eu malesuada arcu augue id nisi. In
                                    auctor mi ac ante tincidunt tincidunt.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- Footer -->

    <!-- Section: Social media -->
    <section class="bg-black our-story-card py-1" style="display:none">
        <div class="container">
            <div class="row justify-content-center p-4">
                <div class="col-12 col-md-8 col-xl-8 text-center">
                    <h5 class="text-white mb-3">
                        Ready to watch? Enter your email to create or restart your membership.
                    </h5>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control p-3" placeholder="Recipient's username"
                            aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-primary p-3" type="button" id="button-addon2">Get Started</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right -->
    </section>
    <!-- Footer -->

    <!-- Section: Links  -->
    <section class="bg-black text-grey p-0">
        <div class="container text-center text-md-start pt-1">
            <!-- Grid row -->
            <div class="row mt-3">
                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4 text-white">
                        Get to Know Us
                    </h6>
                    @foreach (\App\Services\AppConfig::get()->app->data->pages as $page)
                        @if ($page->displayOn == 'F')
                            <p>
                                <a class="text-reset"
                                    href="/page/{{ $page->page_slug }}">{{ $page->page_title }}</a>
                            </p>
                        @endif
                    @endforeach

                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4 text-white">
                        Top Categories
                    </h6>
                    @foreach (\App\Services\AppConfig::get()->app->footer_categories as $category)
                        <p>
                            <a class="text-reset"
                                href="{{ route('category', $category->cat_guid) }}">{{ $category->cat_title }}</a>
                        </p>
                    @endforeach
                </div>
                <!-- Grid column -->
                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4 text-white">
                        Let Us Help You
                    </h6>
                    <p>
                        <a href="/signin" class="text-reset">Login</a>
                    </p>
                    <p>
                        <a href="/signup" class="text-reset">Register</a>
                    </p>
                    <p>
                        <a href="javascript:void(0)" class="text-reset">Download Apps</a>
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

                <a href="Youtube.com/@24flix" target="_blank" class="me-4 text-reset">
                    <i class="fab fa-youtube"></i>
                </a>

                <a href="Facebook.com/24flix" target="_blank" class="me-4 text-reset">
                    <i class="fab fa-facebook-f"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Copyright -->
    </footer>
    <!-- Footer -->



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

</body>

</html>
