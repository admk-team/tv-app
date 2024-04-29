<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data->app->app_info->app_name ?? '' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link href="{{ asset('assets/landing_theme_assets/new3/css/style.css') }}" rel="stylesheet">
    <style>
        body {
            background-image: linear-gradient(rgba(4, 9, 30, 0.4), rgba(4, 9, 30, 0.4)),
                url("{{ asset('assets/landing_theme_assets/new3/images/banner.png') }}");
        }        
    </style>
</head>

<body>
    <!-- START: Top Header -->
    <header class="d-flex justify-content-between align-items-center px-2 px-md-3 py-2 mb-3">
        <a href="/home">
            <img src="{{ asset('assets/landing_theme_assets/new3/images/logo.png') }}" class="logo" />
        </a>
        <nav class="d-flex gap-2 gap-md-3 align-items-center">
            <a href="" class="browse-btn">Browse Content</a>
            <a href="" class="btn-primary-new-outline">Login</a>
            <a href="" class="btn-primary-new">Signup</a>
        </nav>
    </header>
    <!-- END: Top Header -->

    <!-- START: Hero Section -->
    <section class="sec-hero d-flex flex-column justify-content-center align-items-center px-2 px-md-3 mb-5">
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
            {{--  <div class="active">Comedy</div>
            <div>Romance</div>
            <div>Action</div>
            <div>Drama</div>
            <div>Staff Pick</div>  --}}
        </div>
        <div class="tabs position-relative">
            @if (isset($data->app->categories))
            @php $count = 0; @endphp
            @foreach ($data->app->categories ?? [] as $category)
                @if (!empty($category->streams) && !empty($category->cat_title))
                    @if ($count < 5)
                        <div class="tab-content px-sm-4 px-md-5 @if ($count == 0) active @endif"> <!-- Added active class here -->
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
        
            {{--  <div class="tab-content px-sm-4 px-md-5 active">
                <div class="poster-slides">
                    <img src="{{ asset('assets/landing_theme_assets/new3/images/hero.png') }}">
                    <img src="{{ asset('assets/landing_theme_assets/new3/images/tiger.png') }}">
                    <img src="{{ asset('assets/landing_theme_assets/new3/images/romance1.png') }}">
                    <img
                        src="{{ asset('https://onlinechannel.io/storage/images/stream/poster/ICFFAwardsCeremonyLive[LateShow]_2024-04-17_20-59-35.png') }}">
                    <div class="overlay"></div>
                </div>
            </div>
            <div class="tab-content px-sm-4 px-md-5">
                <div class="poster-slides">
                    <img
                        src="https://onlinechannel.io/storage/7376d3829575f06617d9db3f7f6836df_1693409424_191_nner.png">
                    <img src="{{ asset('assets/landing_theme_assets/new3/images/hero.png') }}">
                    <div class="overlay"></div>
                </div>
            </div>  --}}
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
        <div class="apps__links d-flex align-items-center justify-content-center gap-3 mt-3">
            {{--  @if (!empty($page->playstore_link))  --}}
            <h5>Download Now</h5>
                <div>
                    <a href=""><img src="{{ asset('assets/landing_theme_assets/iris/images/play.png') }}" alt=""
                        srcset=""></a>
                </div>
            {{--  @endif
            @if (!empty($page->appstore_link))  --}}
                <div>
                    <a href=""><img src="{{ asset('assets/landing_theme_assets/iris/images/apple.png') }}" alt=""
                    srcset=""></a>
                </div>
            {{--  @endif  --}}
        </div>
    </section>
    <!-- END: Hero Section -->

    <!-- START: Video Section -->
    <div class="sec-video mb-5">
        <h1><span>Stream</span> Anywhere</h1>
        <p>You can find 24 Flix on all of the major App Stores including IOS, Android, Roku, Apple TV, Amazon Fire TV,
            Samsung, LG, Vidaa and on the web.</p>
        <div class="video">
            <video width="400" autoplay>
                <source src="https://player.vimeo.com/progressive_redirect/playback/830374923/rendition/720p/file.mp4?loc=external&signature=314a23119f729b0f79a31da6232ead8a19419dc7a7adb8289183ce83d4763593" type="video/mp4">
            </video>
        </div>
    </div>
    <!-- END: Video Section -->

    <!-- START: Device Section -->
    <div class="sec-device">
        <div class="tab-btns d-flex gap-2 gap-sm-3 gap-md-4 gap-lg-5">
            <div class="active"><span>TV</span></div>
            <div><span>Tablet & Mobile</span></div>
            <div><span>Desktop & Laptop</span></div>
        </div>

        <div class="mt-5"></div>
    </div>
    <!-- END: Device Section -->

    <script>
        (function() {
            const tabBtns = document.querySelectorAll('.tab-btns > div');
            const tabContents = document.querySelectorAll('.tab-content');
            tabBtns.forEach((btn, index) => {
                btn.addEventListener('click', () => {
                    if (!tabContents[index]) {
                        return;
                    }
                    document.querySelector('.tab-btns .active').classList.remove('active');
                    document.querySelector('.tab-content.active').classList.remove('active');
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
    </script>
</body>

</html>
