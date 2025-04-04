@extends('components.layouts.landingpage_layout')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/netflix/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/netflix/css/netflix.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/mean/css/style.css') }}">
@endsection

@section('content')
    <div class="our_storycard">
        @if (isset(\App\Services\AppConfig::get()->app->landingpages))
            @foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
                @if ($page->page_type === 'Ele' && $page->section_type === 'banner' && $page->status === 1)
                    <div class="content_bgsnew"> <img
                            src="{{ $page->image ?? asset('assets/landing_theme_assets/netflix/images/backs.jpg') }}">
                        <div class="concord_gradient"></div>
                    </div>
                @endif
            @endforeach
        @endif

        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 shadow-sm">
            {{--  <h5 class="my-0 mr-md-auto font-weight-normal text-white">{{ \App\Services\AppConfig::get()->app->app_info->app_name ?? '' }}</h5>
              --}}
            <a class="my-0 mr-md-auto img-fluid" href="/home"><img alt="logo"
                    src="{{ \App\Services\AppConfig::get()->app->app_info->website_logo ?? '' }}" width="100px"
                    class="img-fluid" /></a>
            <a href="/home?browse=true" class="text-decoration-none text-white border-2 rounded-pill px-3">Browse
                Content</a>
            <nav class="my-2 my-md-0 mr-md-3">
                <a class="p-2 text-white" href="/login">Login</a>
            </nav>
            @if (session()->has('USER_DETAILS') && session('USER_DETAILS') !== null)
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
                        @if (isset(\App\Services\AppConfig::get()->app->badge_status) && \App\Services\AppConfig::get()->app->badge_status === 1)
                            <li><a class="text-decoration-none" href="{{ route('user.badge') }}">User Badge</a>
                            </li>
                        @endif
                        <li><a class="text-decoration-none" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div>
            @else
                @if (\App\Services\AppConfig::get()->app->app_info->is_signup_btn_show === 'Y')
                    <a class="btn btn_signup" href="/signup">Signup</a>
                @endif
            @endif
        </div>

        <div class="position-relative overflow-hidden p-3 p-md-5 text-center">
            <div class="col-md-8 p-lg-8 mx-auto my-8">
                @foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
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
                            <input type="email" name="email" class="form-control form_inputsss"
                                placeholder="Email Address" required>
                            <!-- Adding type="email" and required attributes -->
                        </div>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn_dangin" id="submit">Get Started</button>
                        </div>
                    </div>
                    <span class="text-danger email-error"></span> <!-- Error message span -->
                </form>

            </div>
            <div class="product-device shadow-sm d-none d-md-block"></div>
            <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
        </div>
    </div>
    @if (isset(\App\Services\AppConfig::get()->app->landingpages))
        @foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
            @if ($page->page_type === 'Ele' && $page->section_type === 'tv_section' && $page->status === 1)
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
            @endif
            <!-- End of first row box -->
            @if ($page->page_type === 'Ele' && $page->section_type === 'tablet_section' && $page->status === 1)
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
            @if ($page->page_type === 'Ele' && $page->section_type === 'desktop_section' && $page->status === 1)
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
                <div class="our_storycard"></div>
            @endif
        @endforeach
    @endif

    <!-- Start FAQ-->
    @if (isset(\App\Services\AppConfig::get()->app->landingpages) &&
            array_reduce(
                \App\Services\AppConfig::get()->app->landingpages,
                fn($carry, $item) => $carry || ($item->section_type === 'faq' && $item->page_type === 'Ele'),
                false))
        <div class="d-flex justify-content-center">
            <div class="leftinpars">
                <h1>Frequently Asked Questions</h1>
            </div>
        </div>
        @foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
            @if ($page->page_type === 'Ele' && $page->section_type === 'faq' && $page->status === 1)
                <div class="accrodingin">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne{{ $loop->index }}">
                                <button class="accordion-button faq_question collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOne{{ $loop->index }}"
                                    aria-expanded="false" aria-controls="flush-collapseOne{{ $loop->index }}">
                                    {{ $page->title ?? '' }} <svg id="thin-x" viewBox="0 0 26 26"
                                        class="svg-icon svg-icon-thin-x svg-closed" focusable="true">
                                        <path
                                            d="M10.5 9.3L1.8 0.5 0.5 1.8 9.3 10.5 0.5 19.3 1.8 20.5 10.5 11.8 19.3 20.5 20.5 19.3 11.8 10.5 20.5 1.8 19.3 0.5 10.5 9.3Z">
                                        </path>
                                    </svg>
                                </button>
                            </h2>
                            <div id="flush-collapseOne{{ $loop->index }}" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body acrodinbibody">{{ $page->description ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="our_storycard"></div>
    @endif

    @if (isset(\App\Services\AppConfig::get()->app->landingpages))
        @foreach (\App\Services\AppConfig::get()->app->landingpages as $page)
            @if ($page->page_type === 'Ele' && $page->section_type === 'membership' && $page->status === 1)
                <div class="position-relative overflow-hidden p-3 p-md-5 text-center">
                    <div class="col-md-8 p-lg-8 mx-auto my-8">
                        <p class="membertttiltes"> {{ $page->description ?? '' }}</p>

                        <form id="form1">
                            <div class="input-group is-invalid">
                                <div class="custom-file customins">
                                    <input type="email" name="email" class="form-control form_inputsss"
                                        placeholder="Email Address" required>
                                    <!-- Adding type="email" and required attributes -->
                                </div>
                                <div class="input-group-append">
                                    <button type="submit" class="btn  btn_dangin" id="submit1">Get
                                        Started</button>
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
        <div class="d-flex justify-content-between  p-2">
            <div class=" text-white-costum fs-14px">
                © {{ \App\Services\AppConfig::get()->app->app_info->app_name ?? '' }}
                {{ date('Y') }}-{{ date('Y', strtotime('+1 years')) }} ALL RIGHTS RESERVED. </div>
            <div class=" text-end text-white-costum">
                @foreach (\App\Services\AppConfig::get()->app->social_media->links as $link)
                    <a href="{{ $link->url }}" target="_blank" class="me-3 text-reset"
                        style="text-decoration:none !important; ">
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
@endsection
@section('scripts')
    @include('components.includes.script')
    <script>
        function dropdownHandle(e) {
            $(`.profiledropin:eq(${$(e).data('index')})`).slideToggle();
        }
    </script>
@endsection
