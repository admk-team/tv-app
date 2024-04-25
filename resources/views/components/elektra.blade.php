<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:title" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_title ?? '' }}" />
    <meta property="og:image" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_image ?? '' }}" />
    <meta property="og:description" content="{!! strip_tags(\App\Services\AppConfig::get()->app->app_info->seo_description ?? '') !!}" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data->app->app_info->app_name ?? '' }}</title>
    <link rel="icon" href="{{ $data->app->app_info->website_faviocn ?? '' }}">

    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/netflix/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/netflix/css/netflix.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/mean/css/style.css') }}">

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

    <style>
        .nav_btnlink {
            cursor: pointer;
        }

        .userimg {
            width: 40px;
            height: 40px;
            border-radius: 50% 50%;
            font-size: 20px;
            font-weight: bold;
            color: var(--themePrimaryTxtColor);
            padding: 4px 2px;
            text-align: center;
            background: var(--themeActiveColor);
        }

        .dropdown_menus {
            position: absolute;
            top: 161%;
            left: 0;
            z-index: 1000;
            float: left;
            min-width: 10rem;
            padding: .5rem 0;
            margin: .125rem 0 0;
            font-size: 1rem;
            display: none;
            color: #212529;
            text-align: left;
            list-style: none;
            background-color: var(--themePrimaryTxtColor);
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, .15);
            border-radius: .25rem
        }

        .avtartMenu {
            padding-bottom: 0 !important;
            padding-top: 0 !important;
            min-width: 167px !important;
            margin-top: 5px !important;
            left: unset !important;
            right: 0 !important;
            border: unset !important;
            background-clip: unset !important;
            box-shadow: 0 1px 5px 0 rgb(0 0 0 / 22%);
        }

        ul.profiledropin {
            padding: 0px 0px !important;
            margin: 0px 0px !important;
        }

        ul.profiledropin li a {
            font-size: 14px;
            font-family: 'Noto Sans';
            padding: 6px 10px;
            display: block;
            width: 100%;
            color: black;
        }

        ul.profiledropin li a:hover {
            background: var(--themeActiveColor);
            color: var(--themePrimaryTxtColor);
        }

        .avtartMenu li a {
            font-size: 14px !important;
            text-transform: capitalize !important;
            font-family: inherit !important;
        }
    </style>
</head>

<body>
    <div class="our_storycard">
        @if (isset($data->app->landingpages))
            @foreach ($data->app->landingpages as $page)
                @if ($page->page_type === 'Ele' && $page->section_type === 'banner' && $page->status === 1)
                    <div class="content_bgsnew"> <img
                            src="{{ $page->image ?? asset('assets/landing_theme_assets/netflix/images/backs.jpg') }}">
                        <div class="concord_gradient"></div>
                    </div>
                @endif
            @endforeach
        @endif

        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 shadow-sm">
            {{--  <h5 class="my-0 mr-md-auto font-weight-normal text-white">{{ $data->app->app_info->app_name ?? '' }}</h5>
              --}}
              <a class="my-0 mr-md-auto img-fluid" href="/home"><img alt="logo"
                src="{{ $data->app->app_info->website_logo ?? '' }}" width="100px" class="img-fluid" /></a>
                <a href="/home?browse=true" class="text-decoration-none text-white border-2 rounded-pill px-3">Browse Content</a>
            <nav class="my-2 my-md-0 mr-md-3">
                <a class="p-2 text-white" href="/login">Login</a>
            </nav>
            @if (session()->has('USER_DETAILS'))
                <div class="dropdown dropdin">
                    <div class="nav_btnlink" id="dropdownMenuLink1" onclick="dropdownHandle(this)" data-index=0>
                        <div class="userimg">{{ session('USER_DETAILS')['USER_NAME'][0] }}</div>
                    </div>
                    <ul class="dropdown_menus profiledropin avtartMenu" style="display: none;">
                        <li style="display: none;"><a href="update-profile.php"><span class="userno">user-26</span></a>
                        </li>
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
            @if (\App\Services\AppConfig::get()->app->app_info->is_signup_btn_show === 'Y')
                <a class="btn btn-danger" href="/signup">Signup</a>
            @endif
            @endif
        </div>

        <div class="position-relative overflow-hidden p-3 p-md-5 text-center">
            <div class="col-md-8 p-lg-8 mx-auto my-8">
                @foreach ($data->app->landingpages as $page)
                    @if ($page->page_type === 'Ele' && $page->section_type === 'banner' && $page->status === 1)
                        <h1 class="display-4 unlimmited_headers">
                            {{ $page->title ?? '' }}</h1>
                        <p class="lead cards_headtitles">{{ $page->subtitle ?? '' }}
                        </p>
                        <p class="leadinsttiltes">
                            {{ $page->description ?? '' }}
                        </p>
                    @endif
                @endforeach
                <form id="form">
                    <div class="input-group is-invalid">
                        <div class="custom-file customins">
                            <input type="email" name="email" class="form-control form_inputsss" placeholder="Email Address" required>
                            <!-- Adding type="email" and required attributes -->
                        </div>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-danger btn_dangin" id="submit">Get Started</button>
                        </div>
                    </div>
                    <span class="text-danger email-error"></span> <!-- Error message span -->
                </form>
                
            </div>
            <div class="product-device shadow-sm d-none d-md-block"></div>
            <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
        </div>
    </div>
    @if (isset($data->app->landingpages))
        @foreach ($data->app->landingpages as $page)
            @if ($page->page_type === 'Ele' && $page->section_type === 'section' && $page->status === 1)
                @if ($page->order % 2 === 1)
                    <!-- First design for odd order -->
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
                                <div class="leftinbox">
                                    <div class="leftinpars">
                                        <h1>{{ $page->title ?? '' }}</h1>
                                        <p> {{ $page->description ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-5">
                                <div class="rightinpars">
                                    <img src=" {{ $page->image }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of first row box -->
                @else
                    <!-- Second design for even order -->
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="rightinpars">
                                    <img src=" {{ $page->image }}" alt="">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="leftinbox">
                                    <div class="leftinpars">
                                        <h1>{{ $page->title ?? '' }}</h1>
                                        <p> {{ $page->description ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of first row box -->
                @endif
                <div class="our_storycard"></div>
            @endif

            {{--  <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-7">
                        <div class="leftinbox">
                            <div class="leftinpars">
                                <h1>Watch everywhere.</h1>
                                <p>Unlimited movies, TV series on Roku TV, FireTV, Tizen and Apple. For download click
                                    on below
                                    buttons.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-5">
                        <div class="rightinpars">

                            <img src="{{ asset('assets/landing_theme_assets/netflix/images/device-pile-in.png') }}"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start of first row box -->
            <div class="our_storycard"></div>

            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="rightinpars">

                            <img src="{{ asset('assets/landing_theme_assets/netflix/images/childrensnew.png') }}"
                                alt="">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="leftinbox">
                            <div class="leftinpars">
                                <h1>Hundreds of Movies & Shows for Kids</h1>
                                <p>Kids can watch unlimited movies and shows anywhere at anytime. Download our app and
                                    start
                                    watching.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of first row box -->  --}}
        @endforeach
    @endif

    <!-- Start FAQ-->
    @if (isset($data->app->landingpages) &&
            array_reduce(
                $data->app->landingpages,
                fn($carry, $item) => $carry || ($item->section_type === 'faq' && $item->page_type === 'Ele'),
                false))
        <div class="d-flex justify-content-center">
            <div class="leftinpars">
                <h1>Frequently Asked Questions</h1>
            </div>
        </div>
        @foreach ($data->app->landingpages as $page)
            @if ($page->page_type === 'Ele' && $page->section_type === 'faq' && $page->status === 1)
                <div class="accrodingin">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne{{$loop->index}}">
                                <button class="accordion-button faq_question collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOne{{$loop->index}}"
                                    aria-expanded="false" aria-controls="flush-collapseOne{{$loop->index}}">
                                    {{ $page->title ?? '' }} <svg id="thin-x" viewBox="0 0 26 26"
                                        class="svg-icon svg-icon-thin-x svg-closed" focusable="true">
                                        <path
                                            d="M10.5 9.3L1.8 0.5 0.5 1.8 9.3 10.5 0.5 19.3 1.8 20.5 10.5 11.8 19.3 20.5 20.5 19.3 11.8 10.5 20.5 1.8 19.3 0.5 10.5 9.3Z">
                                        </path>
                                    </svg>
                                </button>
                            </h2>
                            <div id="flush-collapseOne{{$loop->index}}" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body acrodinbibody">{{ $page->description ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="our_storycard"></div>
    @endif

    @if (isset($data->app->landingpages))
        @foreach ($data->app->landingpages as $page)
            @if ($page->page_type === 'Ele' && $page->section_type === 'membership' && $page->status === 1)
                <div class="position-relative overflow-hidden p-3 p-md-5 text-center">
                    <div class="col-md-8 p-lg-8 mx-auto my-8">
                        <p class="leadinsttiltes"> {{ $page->description ?? '' }}</p>

                        <form id="form1">
                            <div class="input-group is-invalid">
                                <div class="custom-file customins">
                                    <input type="email" name="email" class="form-control form_inputsss" placeholder="Email Address" required>
                                    <!-- Adding type="email" and required attributes -->
                                </div>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-danger btn_dangin" id="submit1">Get Started</button>
                                </div>
                            </div>
                            <span class="text-danger email-error"></span> <!-- Error message span -->
                        </form>
                    </div>
                </div>
                <div class="our_storycard"></div>
            @endif
        @endforeach
    @endif

    {{--  <!-- Start of first row box -->
    <div class="accrodingin">
        <div class="row">
            <p class="demonsson">Questions? Call 000-800-919-1694</p>
        </div>
        <div class="row">
            <div class="col-md-3">
                <ul class="footerinlinst">
                    <li><a href="javascript:void(0);">FAQ</a></li>
                    <li><a href="javascript:void(0);">Investor Relations</a></li>
                    <li><a href="javascript:void(0);">Privacy</a></li>
                    <li><a href="javascript:void(0);">Speed Test</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="footerinlinst">
                    <li><a href="javascript:void(0);">FAQ</a></li>
                    <li><a href="javascript:void(0);">Investor Relations</a></li>
                    <li><a href="javascript:void(0);">Privacy</a></li>
                    <li><a href="javascript:void(0);">Speed Test</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="footerinlinst">
                    <li><a href="javascript:void(0);">FAQ</a></li>
                    <li><a href="javascript:void(0);">Investor Relations</a></li>
                    <li><a href="javascript:void(0);">Privacy</a></li>
                    <li><a href="javascript:void(0);">Speed Test</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="footerinlinst">
                    <li><a href="javascript:void(0);">FAQ</a></li>
                    <li><a href="javascript:void(0);">Investor Relations</a></li>
                    <li><a href="javascript:void(0);">Privacy</a></li>
                    <li><a href="javascript:void(0);">Speed Test</a></li>
                </ul>
            </div>

        </div>

    </div>  --}}
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
                    @if ($page->displayOn === 'F' || $page->displayOn === 'B')
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
                        <a href="/login" class="text-reset">Login</a>
                    </p>
                    @if (\App\Services\AppConfig::get()->app->app_info->is_signup_btn_show === 'Y')
                    <p>
                        <a href="/signup" class="text-reset">Register</a>
                    </p>
                    @endif
                    <p>
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
        <div class="d-flex justify-content-between  p-2">
            <div class=" text-white fs-14px">
                © {{ $data->app->app_info->app_name ?? '' }}
                {{ date('Y') }}-{{ date('Y', strtotime('+1 years')) }} ALL RIGHTS RESERVED. </div>
            <div class=" text-end text-white">
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
    @include('components.includes.script')
    <script>
        function dropdownHandle(e) {
            $(`.profiledropin:eq(${$(e).data('index')})`).slideToggle();
        }
    </script>
   
</body>

</html>
