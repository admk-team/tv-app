<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data->app->app_info->app_name ?? '' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link href="{{ asset('assets/landing_theme_assets/lyra/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- START: Top Header -->
    <header class="content-wrapper d-flex justify-content-between align-items-center px-2 px-md-3 py-2 mb-3">
        <a href="/home">
            <img src="{{ asset('assets/landing_theme_assets/lyra/images/logo.png') }}" class="logo" />
        </a>
        <nav class="d-flex gap-2 gap-md-3 align-items-center">
            <a href="" class="browse-btn">Browse Content</a>
            <form>
                <div class="input-group bg-danger">
                    <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="search-icon">
                        <svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="21" cy="21" r="20.6" stroke="white" stroke-width="0.8"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M20.4993 12C19.1439 12.0001 17.8081 12.3244 16.6035 12.9457C15.3989 13.567 14.3604 14.4674 13.5745 15.5718C12.7887 16.6761 12.2783 17.9523 12.086 19.294C11.8937 20.6357 12.025 22.004 12.4691 23.2846C12.9131 24.5652 13.6569 25.7211 14.6385 26.6557C15.6201 27.5904 16.811 28.2768 18.1118 28.6576C19.4126 29.0384 20.7856 29.1026 22.1163 28.8449C23.447 28.5872 24.6967 28.015 25.7613 27.176L29.4133 30.828C29.6019 31.0102 29.8545 31.111 30.1167 31.1087C30.3789 31.1064 30.6297 31.0012 30.8151 30.8158C31.0005 30.6304 31.1057 30.3796 31.108 30.1174C31.1102 29.8552 31.0094 29.6026 30.8273 29.414L27.1753 25.762C28.1633 24.5086 28.7784 23.0024 28.9504 21.4157C29.1223 19.8291 28.8441 18.226 28.1475 16.7901C27.4509 15.3542 26.3642 14.1434 25.0116 13.2962C23.659 12.4491 22.0952 11.9999 20.4993 12ZM13.9993 20.5C13.9993 18.7761 14.6841 17.1228 15.9031 15.9038C17.1221 14.6848 18.7754 14 20.4993 14C22.2232 14 23.8765 14.6848 25.0955 15.9038C26.3145 17.1228 26.9993 18.7761 26.9993 20.5C26.9993 22.2239 26.3145 23.8772 25.0955 25.0962C23.8765 26.3152 22.2232 27 20.4993 27C18.7754 27 17.1221 26.3152 15.9031 25.0962C14.6841 23.8772 13.9993 22.2239 13.9993 20.5Z" fill="white"/>
                        </svg>
                    </button>
                </div>
            </form>
            <a href="" class="btn-primary-new-outline">Login</a>
            <a href="" class="btn-primary-new">Signup</a>
        </nav>
    </header>
    <!-- END: Top Header -->
@if(false)
    <!-- START: Hero Section -->
    <section class="sec-hero content-wrapper d-flex flex-column justify-content-center align-items-center px-2 px-md-3 mb-5">
        <div class="tab-btns d-flex justify-content-between w-100">
            <div class="active">Comedy</div>
            <div>Romance</div>
            <div>Action</div>
            <div>Drama</div>
            <div>Staff Pick</div>
        </div>
        <div class="tabs position-relative">
            <div class="tab-content px-sm-4 px-md-5 active">
                <div class="poster-slides">
                    <img src="{{ asset('assets/landing_theme_assets/lyra/images/hero.png') }}">
                    <img src="{{ asset('assets/landing_theme_assets/lyra/images/tiger.png') }}">
                    <img src="{{ asset('assets/landing_theme_assets/lyra/images/romance1.png') }}">
                    <img
                        src="{{ asset('https://onlinechannel.io/storage/images/stream/poster/ICFFAwardsCeremonyLive[LateShow]_2024-04-17_20-59-35.png') }}">
                    <div class="overlay"></div>
                </div>
            </div>
            <div class="tab-content px-sm-4 px-md-5">
                <div class="poster-slides">
                    <img
                        src="https://onlinechannel.io/storage/7376d3829575f06617d9db3f7f6836df_1693409424_191_nner.png">
                    <img src="{{ asset('assets/landing_theme_assets/lyra/images/hero.png') }}">
                    <div class="overlay"></div>
                </div>
            </div>
            <div class="text-content px-sm-4 px-md-5 d-flex flex-column justify-content-end">
                <div class="wrapper">
                    <h3>Welcome to 24 flix</h3>
                    <h1>Unlimited Movies and TV show</h1>
                    <p>Escape into a realm of movies, TV series, documentaries, and beyond. From heart-pounding
                        thrillers to heartwarming dramas, find it all on 24 Flix.</p>
                    <div class="mt-2 mt-sm-4 mt-md-5 mb-2">
                        <a href="/" class="btn-primary-new border get-started-btn">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Hero Section -->

    <!-- START: Video Section -->
    <div class="sec-video mb-5">
        <div class="content-wrapper">
            <h1><span>Stream</span> Anywhere</h1>
            <p>You can find 24 Flix on all of the major App Stores including IOS, Android, Roku, Apple TV, Amazon Fire TV,
                Samsung, LG, Vidaa and on the web.</p>
        </div>
        <div class="video">
            <video width="400" autoplay>
                <source src="http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4" type="video/mp4">
            </video>
        </div>
    </div>
    <!-- END: Video Section -->

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
                        <h1>Enjoy on your <span>Television</span></h1>
                        <p>Watch on smart TVs, Chromecast, Apple TV, Blu-ray players and more.</p>
                        <div class="platforms d-flex align-items-center gap-3 gap-md-4">
                            <div class="text">Watch Now:</div>
                            <div class="icons">
                                <img src="{{ asset('assets/landing_theme_assets/lyra/images/roku.png') }}" width="66px">
                                <img src="{{ asset('assets/landing_theme_assets/lyra/images/firetv.png') }}" width="66px">
                                <img src="{{ asset('assets/landing_theme_assets/lyra/images/appletv.png') }}" width="66px">
                            </div>
                        </div>
                        <a href="" class="btn-primary-new device-download-btn">Download Now</a>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <img class="device-img" src="https://play-lh.googleusercontent.com/GD78NlC-yoQXcLsvTc3JLr_VVR5YKQp43FOfWLB7e5lwU_La_hy4olpMaj0_yY7ScgQ">
                    </div>
                </div>
            </div>

            <div class="tab-content">
                <div class="row">
                    <div class="col-md-8 order-last order-md-first">
                        <h1>Enjoy on your <span>Tab & Mobile.</span></h1>
                        <p>Watch on smart TVs, Chromecast, Apple TV, Blu-ray players and more.</p>
                        <div class="platforms d-flex align-items-center gap-3 gap-md-4">
                            <div class="text">Watch Now:</div>
                            <div class="icons">
                                <img src="{{ asset('assets/landing_theme_assets/lyra/images/roku.png') }}" width="66px">
                                <img src="{{ asset('assets/landing_theme_assets/lyra/images/firetv.png') }}" width="66px">
                                <img src="{{ asset('assets/landing_theme_assets/lyra/images/appletv.png') }}" width="66px">
                            </div>
                        </div>
                        <a href="" class="btn-primary-new device-download-btn">Download Now</a>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <img class="device-img" src="https://play-lh.googleusercontent.com/GD78NlC-yoQXcLsvTc3JLr_VVR5YKQp43FOfWLB7e5lwU_La_hy4olpMaj0_yY7ScgQ">
                    </div>
                </div>
            </div>

            <div class="tab-content">
                <div class="row">
                    <div class="col-md-8 order-last order-md-first">
                        <h1>Enjoy on your <span>Desktop & Laptop.</span></h1>
                        <p>Watch on smart TVs, Chromecast, Apple TV, Blu-ray players and more.</p>
                        <div class="platforms d-flex align-items-center gap-3 gap-md-4">
                            <div class="text">Watch Now:</div>
                            <div class="icons">
                                <img src="{{ asset('assets/landing_theme_assets/lyra/images/roku.png') }}" width="66px">
                                <img src="{{ asset('assets/landing_theme_assets/lyra/images/firetv.png') }}" width="66px">
                                <img src="{{ asset('assets/landing_theme_assets/lyra/images/appletv.png') }}" width="66px">
                            </div>
                        </div>
                        <a href="" class="btn-primary-new device-download-btn">Download Now</a>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <img class="device-img" src="https://play-lh.googleusercontent.com/GD78NlC-yoQXcLsvTc3JLr_VVR5YKQp43FOfWLB7e5lwU_La_hy4olpMaj0_yY7ScgQ">
                    </div>
                </div>
            </div>
        </div>
    </div>      
    <!-- END: Device Section -->

    <!-- START: CTA Section -->
    <div class="sec-cta content-wrapper px-2 px-md-3">
        <div class="row">
            <div class="col-md-5 text">
                <h1>Ready to <span>watch?</span></h1>
                <p>Enter your email to create or restart your membership.</p>
            </div>
            <div class="col-md-7 form d-flex align-items-center">
                <form class="flex-grow-1 max-w-100">
                    <div class="field d-flex align-items-center">
                        <input type="text" placeholder="Enter your Email">
                        <button class="btn-primary-new get-started-btn">Get Started</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: CTA Section -->
    @endif

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
                    document.querySelector('.sec-device .tab-content.active').classList.remove('active');
                    btn.parentNode.classList.add('active');
                    tabContents[index].classList.add('active');
                });
            });
        })();
    </script>
</body>

</html>
