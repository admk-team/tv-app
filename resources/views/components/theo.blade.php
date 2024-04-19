<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data->app->app_info->app_name ?? '' }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href=" {{ asset('assets/landing_theme_assets/theo/css/style.css') }}">
</head>
<style>
  .header {
     background-image: linear-gradient(rgba(4, 9, 30, 0.4), rgba(4, 9, 30, 0.4)),
      url({{ asset('assets/landing_theme_assets/theo/images/image24.png') }}); 
      }
      .membership__section::before {
       
        background-image: linear-gradient(
          rgba(255, 255, 255, 0.1),
          rgba(255, 255, 255, 0.1)
        ),
        url({{ asset('assets/landing_theme_assets/theo/images/gradient.png') }});
      }
      .membership__section::after {
        background-image: linear-gradient(
          rgba(255, 255, 255, 0.1),
          rgba(255, 255, 255, 0.1)
        ),
        url({{ asset('assets/landing_theme_assets/theo/images/gradient.png') }});
      }
</style>

<body>

    <div class="wrapper__landing__page">
        <section class="header">
            <nav class="nav-links container">
                <ul class="list-unstyled d-flex align-items-center justify-content-between pt-4">
                    <li><a href="/home" class="text-decoration-none"><img
                                src="{{ $data->app->app_info->website_logo ?? '' }}" alt="Logo" width="100px"></a>
                    </li>
                    <li><a href="/login"
                            class="text-decoration-none text-white border-2 rounded-pill custom__button">Sign In</a>
                    </li>
                </ul>
            </nav>

            <div class="row d-flex align-items-center justify-content-center m-auto text-white">
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-center flex-column m-auto inner__section">
                        <p class="fs-2 p-0 m-0">Welcome to 24 Flix</p>
                        <h4 class="text-center">Unleash Your <span class="">Inner Movie</span> Buff</h4>
                        <p class="fs-5 text-center">Escape into a realm of movies, TV series, documentaries, and beyond.
                            From
                            heart-pounding
                            thrillers to heartwarming
                            dramas, find it all on 24 Flix.</p>
                        <a href="/signup"
                            class="text-decoration-none border-2 text-white rounded-pill custom__button my-4">Start
                            Streaming</a>
                    </div>

                    <div class="movie__type mt-3">
                        <div class="movie__links d-flex align-items-center justify-content-between">
                            <div>
                                <ul class="list-unstyled d-flex gap-3 slider-links">
                                    <li id="action" class="nav-link text-decoration-none text-white" role="button">
                                        Action</li>
                                    <li id="drama" class="nav-link text-decoration-none text-white" role="button">
                                        Drama</li>
                                    <li id="romance" class="nav-link text-decoration-none text-white" role="button">
                                        Romance</li>
                                    <!-- <li><a href="#" id="comedy" class="nav-link text-decoration-none text-white">Comedy</a></li>
                  <li><a href="#" id="thriller" class="nav-link text-decoration-none text-white">Thriller</a></li> -->
                                </ul>
                            </div>
                            <div class="arrow__icons">
                                <a class="prev text-decoration-none text-white" role="button"
                                    onclick="plusSlides(-1)">❮</a>
                                <a class="next text-decoration-none text-white" role="button"
                                    onclick="plusSlides(1)">❯</a>
                            </div>
                        </div>
                        <div class="slideshow-container my-4">
                            <div class="mySlides">
                                <img src="{{ asset('assets/landing_theme_assets/theo/images/action.png') }}"
                                    style="width:100%; display: none;">
                                <img src="{{ asset('assets/landing_theme_assets/theo/images/action1.png') }}"
                                    style="width:100%; display: none;">
                            </div>
                            <div class="mySlides">
                                <img src="  {{ asset('assets/landing_theme_assets/theo/images/drama.png') }}"
                                    style="width:100%; display: none;">
                                <img src=" {{ asset('assets/landing_theme_assets/theo/images/drama1.png') }}"
                                    style="width:100%; display: none;">
                            </div>
                            <div class="mySlides">
                                <img src=" {{ asset('assets/landing_theme_assets/theo/images/romance.png') }}"
                                    style="width:100%; display: none;">
                                <img src=" {{ asset('assets/landing_theme_assets/theo/images/romance1.png') }}"
                                    style="width:100%; display: none;">
                            </div>

                        </div>

                        <div class="playstore d-flex gap-4 py-4">
                            <h5>Download Now</h5>

                            <div><img src="{{ asset('assets/landing_theme_assets/theo/images/play.png') }}"
                                    alt="" srcset=""></div>
                            <div><img src="{{ asset('assets/landing_theme_assets/theo/images/apple.png') }}"
                                    alt="" srcset=""></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="devices">
            <div class="row d-flex align-items-center justify-content-center m-auto text-white">
                <div class="col-md-6  py-5">
                    <p class="devices__text text-center mb-4">Stream on all your <span>favorite devices</span>, any
                        time, anywhere
                    </p>
                    <ul
                        class="devices__icons row d-flex align-items-center justify-content-between px-3 mb-4 text-center">
                        <li class="col-md-2  list-unstyled devices__section active" role="button">
                            <img id="tv" src="{{ asset('assets/landing_theme_assets/theo/images/tv.png') }}"
                                alt="" srcset="">
                            <p>TV</p>
                        </li>
                        <li class="col-md-2 list-unstyled devices__section" role="button">
                            <img id="laptop" class="mb-3"
                                src="{{ asset('assets/landing_theme_assets/theo/images/tab_mobile.png') }}"
                                alt="" srcset="">
                            <p>Tablet & Mobile</p>
                        </li>
                        <li class="col-md-2 list-unstyled devices__section" role="button">
                            <img id="all__Secreens"
                                src="{{ asset('assets/landing_theme_assets/theo/images/laptop.png') }}"
                                alt="" srcset="">
                            <p>Desktop & Laptop</p>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="banner">
            <div
                class="row d-flex align-items-center justify-content-center m-auto text-white py-3 banner__section1 d-block">
                <div class="col-md-6">
                    <div class="row d-flex align-items-center justify-content-center ">
                        <h2 class="text-center mt-4 fw-bolder">Enjoy on your <span>TV.</span></h2>
                        <p class="text-center fs-5 mb-5">Watch on smart TVs, PlayStation, Xbox, Chromecast, Apple TV,
                            Blu-ray
                            players
                            and more.</p>
                        <img class="img-fluid"
                            src="{{ asset('assets/landing_theme_assets/theo/images/banner_tv.png') }}"
                            alt="">
                    </div>
                </div>
            </div>
            <div
                class="row d-flex align-items-center justify-content-center m-auto text-white py-3  banner__section2 d-none">
                <div class="col-md-6">
                    <div class="row d-flex align-items-center justify-content-center">
                        <h2 class="text-center mt-4 fw-bolder">Continue <span>Watching & Favorites</span></h2>
                        <p class="text-center fs-5 mb-5">Continue watching exactly where you stopped and save your
                            favorite fitness
                            classes to watch later.</p>
                        <img class="img-fluid"
                            src="{{ asset('assets/landing_theme_assets/theo/images/banner_tv_mob.png') }}"
                            alt="">
                    </div>
                </div>
            </div>
            <div
                class="row d-flex align-items-center justify-content-center m-auto text-white py-3 banner__section3 d-none">
                <div class="col-md-6">
                    <div class="row d-flex align-items-center justify-content-center ">
                        <h2 class="text-center mt-4 fw-bolder">Enjoy On Your <span>TV</span> & <span>Mobile</span></h2>
                        <p class="text-center fs-5 mb-5">Watch on smart TVs, PlayStation, Xbox, Chromecast, Apple TV,
                            Blu-ray
                            players
                            and more.</p>
                        <img class="img-fluid"
                            src="{{ asset('assets/landing_theme_assets/theo/images/banner_tv_mob_lap.png') }}"
                            alt="">
                    </div>
                </div>
            </div>
        </section>

        <section class="tv__links">
            <div class="tv__icons m-auto w-25 ">
                <div class=" d-flex gap-5 align-items-center justify-content-center py-4 ">
                    <p class="p-0 m-0 watch__now">Watch Now</p>
                    <div class="col-md-4 d-flex  align-items-center gap-2 app__icons">
                        <div><a href="#" class="text-center"><img
                                    src="{{ asset('assets/landing_theme_assets/theo/images/icon1.png') }}"
                                    alt="" srcset=""></a></div>
                        <div><a href="#" class="text-center"><img
                                    src="{{ asset('assets/landing_theme_assets/theo/images/icon2.png') }}"
                                    alt="" srcset=""></a></div>
                        <div><a href="#" class="text-center"><img
                                    src="{{ asset('assets/landing_theme_assets/theo/images/icon3.png') }}"
                                    alt="" srcset=""></a></div>
                    </div>
                </div>
                <div class=" d-flex gap-5 align-items-center justify-content-center py-4 ">
                    <a href="/download-apps"
                        class="text-decoration-none text-white border-2 rounded-pill custom__button">Download</a>

                </div>
            </div>
        </section>

        <section class="membership__section py-5">
            <div class="row d-flex align-items-center justify-content-center m-auto text-white py-5">
                <div class="col-md-6">
                    <div class="tv__icons row d-flex align-items-center justify-content-center gap-3 flex-column mb-3">
                        <div class="col-md-12">
                            <h4 class="text-center"><span>Ready to watch? </span>Enter your email to create or restart
                                your
                                membership.</h4>
                        </div>
                        <form id="form">
                            <div class="col-md-12">
                                <div class="membership d-flex justify-content-between">
                                    <input type="text" name="email" id="email" placeholder="Enter Email">
                                    {{--  <button
                                        class="text-decoration-none text-white border-2 rounded-pill custom__button"
                                        type="button" id="submit">Get
                                        Started</button>  --}}
                                        <a href="" id="submit"class="text-decoration-none text-white border-2 rounded-pill custom__button">Get Started</a>
                                </div>
                                <span class="d-flex align-items-center justify-content-center text-danger email-error"></span>
                            </div>
                            
                        </form>
                    </div>
                </div>
        </section>

        <div class="container m-auto">
            <div class="row g-2 text-white footer">
                <div class="col-md-3">
                    <div class="mb-3"> <a href="/home" class="text-decoration-none"><img
                      src="{{ $data->app->app_info->website_logo ?? '' }}" alt="Logo" width="130px"></a></div>
                    <p><b>Powered By</b> {{ $data->app->app_info->app_name ?? '' }}</p>
                </div>
                <div class="col-md-3">
                    <h5 class="mb-4">GET TO KNOW US</h5>
                    <ul class="d-flex align-items-start flex-column list-unstyled">

                      @foreach (\App\Services\AppConfig::get()->app->data->pages as $page)
                      @if ($page->displayOn === 'F' || $page->displayOn === 'B')
                      <li><a href="/page/{{ $page->page_slug }}" class="text-decoration-none text-white lh-lg">{{ $page->page_title }}</a></li>
                      @endif
                  @endforeach
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="mb-4">TOP CATEGORIES</h5>
                    <ul class="d-flex align-items-start flex-column list-unstyled ">
                      @foreach (\App\Services\AppConfig::get()->app->footer_categories as $category)
                      <li><a href="{{ route('category', $category->cat_guid) }}" class="text-decoration-none text-white lh-lg">{{ $category->cat_title }}</a></li>
                  @endforeach
                        
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="mb-4">LET US HELP YOU</h5>
                    <ul class="d-flex align-items-start flex-column list-unstyled ">
                        <li><a href="/login" class="text-decoration-none text-white lh-lg">Login</a></li>
                        <li><a href="/signup" class="text-decoration-none text-white lh-lg">Register</a></li>
                        <li><a href="/download-apps" class="text-decoration-none text-white lh-lg">Download Apps</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    @include('components.includes.script1')
    <script>
        const deviceSections = document.querySelectorAll('.devices__section');
        const sliderLinks = document.querySelectorAll('.slider-links li');
        const bannerSections = [
            document.querySelector('.banner__section1'),
            document.querySelector('.banner__section2'),
            document.querySelector('.banner__section3')
        ];

        deviceSections.forEach((item, index) => {
            item.addEventListener('click', () => {
                deviceSections.forEach(section => {
                    if (section !== item) {
                        section.classList.remove('active');
                    }
                });
                item.classList.add('active');

                bannerSections.forEach((section, i) => {
                    if (index === i) {
                        section.classList.remove('d-none');
                        section.classList.remove('active');
                    } else {
                        section.classList.add('d-none');
                        section.classList.add('active');
                    }
                });
            });
        });


        sliderLinks.forEach((item, index) => {
            item.addEventListener('click', () => {
                currentSlide(index + 1); // Adjust index to start from 1
            });
        });

        let slideIndex = 1;

        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            const slides = document.getElementsByClassName("mySlides");
            const dots = document.querySelectorAll('.slider-links li');

            if (n > slides.length) {
                slideIndex = 1;
            }
            if (n < 1) {
                slideIndex = slides.length;
            }

            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            for (i = 0; i < dots.length; i++) {
                dots[i].classList.remove('text-red');
            }

            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].classList.add('text-red');
        }

        function autoSlide() {
            const slides = document.querySelectorAll('.mySlides');

            slides.forEach(slide => {
                const images = slide.querySelectorAll('img');
                let visibleIndex = 0;

                // Find the index of the currently visible image
                images.forEach((image, index) => {
                    if (image.style.display !== 'none') {
                        visibleIndex = index;
                    }
                });

                // Hide the currently visible image
                images[visibleIndex].style.display = 'none';

                // Calculate the index of the next image to be displayed
                let nextIndex = visibleIndex + 1;
                if (nextIndex >= images.length) {
                    nextIndex = 0;
                }

                // Display the next image
                images[nextIndex].style.display = 'block';
            });

            setTimeout(autoSlide, 2000); // Change image every 3 seconds (3000 milliseconds)
        }

        autoSlide();
        // function randomizeImages() {
        //     const slides = document.querySelectorAll('.mySlides');

        //     slides.forEach(slide => {
        //         const images = slide.querySelectorAll('img');

        //         // Generate a random index for each slide
        //         const randomIndex = Math.floor(Math.random() * images.length);

        //         // Hide all images
        //         images.forEach(image => {
        //             image.style.display = 'none';
        //         });

        //         // Display the randomly selected image
        //         images[randomIndex].style.display = 'block';
        //     });
        // }

        // // Call the function to randomize images when the page loads
        // window.addEventListener('load', randomizeImages);
    </script>

</body>

</html>
