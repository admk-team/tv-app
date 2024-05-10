@extends('components.layouts.landingpage_layout')

@section('head')
    <meta http-equiv="x-dns-prefetch-control" content="on" />
    <meta http-equiv="Pragma" content="no-control" />
    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate" />
    <meta name="charset" content="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/tubi/css/tubi.css') }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/netflix/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/netflix/css/netflix.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/mean/css/style.css') }}">
    <style>
        .body {
            background: black;
            margin: 0;
        }
    </style>
    @if (isset($data->app->landingpages))
    @foreach ($data->app->landingpages as $page)
        @if ($page->page_type === 'Eli' && $page->section_type === 'banner' && $page->status === 1)
            @if ($page->image)
            <style>
                @media(min-width: 768px) {
                    .a8jOE .m4M3j  {
                        background-image: url('{{ asset($page->image) }}');
                    }
                }
            </style>
            @endif
        @endif
    @endforeach
@endif
@endsection

@section('content')
    <div>
        <div class="FCmbE" style="background:#10141F">
            <div class="g5L2R">
                <div class="kRi99"></div>
            </div>
            <div class="tnutt">
                <nav class="XzUbg mtTH6">
                    <div class="EcToA">
                        <div class="SVozw">
                            <div class="vxDaw">
                                {{--  <div class="_SoAG">
                                    <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" data-test-id="icons-menu" role="img">
                                        <title>Menu Icon</title>
                                        <path
                                            d="M20 8H4C3.448 8 3 7.552 3 7C3 6.448 3.448 6 4 6H20C20.553 6 21 6.448 21 7C21 7.552 20.553 8 20 8Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M20 18H4C3.448 18 3 17.552 3 17C3 16.448 3.448 16 4 16H20C20.553 16 21 16.448 21 17C21 17.552 20.553 18 20 18Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M20 13H4C3.448 13 3 12.552 3 12C3 11.448 3.448 11 4 11H20C20.553 11 21 11.448 21 12C21 12.552 20.553 13 20 13Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </div>  --}}
                            </div>
                            <a href="">
                                <img alt="logo" src="{{ $data->app->app_info->website_logo ?? '' }}" width="70px"
                                    class="img-fluid">
                            </a>
                            <div class="ItzA1">
                                <div class="S1MTF W5KqS">
                                    <a href="/home?browse=true" class="knq9q"><span>Browse Content</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="SVozw Z21oI">
                            @if (session()->has('USER_DETAILS'))
                                <div class="dropdown dropdin">
                                    <div class="nav_btnlink" id="dropdownMenuLink1" onclick="dropdownHandle(this)"
                                        data-index=0>
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
                                        <li><a class="text-decoration-none" href="{{ route('logout') }}">Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <a class="knq9q" href="/login">Sign In</a>
                                @if (\App\Services\AppConfig::get()->app->app_info->is_signup_btn_show === 'Y')
                                    <a class="Ii6WJ" href="/signup">Register</a>
                                @endif
                            @endif
                            <form class="qnV1a" action="{{ route('search') }}">
                                <div class="QlsWG">
                                    <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" data-test-id="icons-search" role="img"
                                        class="phovn">
                                        <title>Search Icon</title>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5ZM4.125 10.5C4.125 14.015 6.985 16.875 10.5 16.875C14.015 16.875 16.875 14.015 16.875 10.5C16.875 6.985 14.015 4.125 10.5 4.125C6.985 4.125 4.125 6.985 4.125 10.5Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M18.636 17.214L20.708 19.294C21.098 19.685 21.097 20.318 20.706 20.708C20.511 20.903 20.255 21 20 21C19.744 21 19.487 20.902 19.291 20.706L17.219 18.626L18.636 17.214Z"
                                            fill="currentColor"></path>
                                    </svg>
                                    <input type="text" name="searchKeyword" id="searchKeyword" value=""
                                        class="ZLiF0" required="" placeholder="Find movies, TV shows and more" />
                                </div>
                            </form>
                        </div>
                    </div>
                </nav>
                <div class="a8jOE">
                    <div class="m4M3j">
                        <div class="f1Far">
                            <div class="MQJzq"></div>
                            <div class="Container Cu6Nx">
                                <div class="Row kGgaU">
                                    @if (isset($data->app->landingpages))
                                        @foreach ($data->app->landingpages as $page)
                                            @if ($page->page_type === 'Eli' && $page->section_type === 'banner' && $page->status === 1)
                                                <div class="Col Col--12 Col--md-12 BfEsx">
                                                    <h1 class="H1">
                                                        @php
                                                            $titleLines = explode('<br />', $page->title ?? '');
                                                            $lineCount = 0;
                                                        @endphp

                                                        @foreach ($titleLines as $line)
                                                            @php
                                                                $words = explode(' ', $line);
                                                                $wordCount = count($words);
                                                                $start = 0;
                                                                $end = 0;
                                                            @endphp

                                                            @while ($start < $wordCount)
                                                                @php
                                                                    if ($lineCount === 0) {
                                                                        $end = min($start + 6, $wordCount);
                                                                    } elseif ($lineCount === 1) {
                                                                        $end = min($start + 1, $wordCount);
                                                                    } else {
                                                                        $end = min($start + 3, $wordCount);
                                                                    }
                                                                @endphp

                                                                <span>{{ implode(' ', array_slice($words, $start, $end - $start)) }}</span><br />

                                                                @php
                                                                    $start = $end;
                                                                @endphp
                                                            @endwhile

                                                            @php
                                                                $lineCount++;
                                                            @endphp
                                                        @endforeach
                                                    </h1>
                                                    <div class="LLBYg FWbqn">
                                                        {{ $page->description ?? '' }}
                                                    </div>
                                                    <a href="/login">
                                                        <button class="Button Button--large">
                                                            <div class="Button__bg"></div>
                                                            <div class="Button__content">Start Watching</div>
                                                        </button>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="CSz1m">
                        <div class="Container Cu6Nx">
                            @if (isset($data->app->landingpages))
                                @foreach ($data->app->landingpages as $page)
                                    @if ($page->page_type === 'Eli' && $page->section_type === 'section' && $page->status === 1 && $page->order === 1)
                                        <div class="Row BVyG0">
                                            <div class="Col Col--12 Col--md-8">
                                                <h2 class="H1"> {{ $page->title ?? '' }}</h2>
                                            </div>
                                        </div>
                                        <div class="Row BVyG0">
                                            <div class="Col Col--12 Col--md-6">
                                                <div class="LLBYg l4FB_ FWbqn">
                                                    {{ $page->description ?? '' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Row BVyG0">
                                            <div class="Col Col--12 Col--sMd-8 Col--md-7 Col--lg-6 Col--xl-4">
                                                <ul class="ylxZk c9BsI">
                                                    @foreach (explode(',', $page->icon) as $iconUrl)
                                                        <li class="fww4G">
                                                            <img src="{{ $iconUrl }}" class="img-fluid">
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="BVyG0">
                                                    <a href="javascript:void(0);">
                                                        <button
                                                            class="Button Button--large Button--secondary Button--inverse">
                                                            <div class="Button__bg"></div>
                                                            <div class="Button__content">Supported Devices</div>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                        </div>
                    </div>
                    @if (isset($data->app->landingpages))
                        @foreach ($data->app->landingpages as $page)
                            @if ($page->page_type === 'Eli' && $page->section_type === 'section' && $page->status === 1 && $page->order === 2)
                                <div class="ziHOc" style="background-image: url({{ $page->image ?? '' }})">
                                    <div class="Container
                                Cu6Nx">
                                        <div class="Row BVyG0">
                                            <div class="Col Col--12">
                                                <h2 class="H1">{{ $page->title ?? '' }}</h2>
                                            </div>
                                        </div>
                                        <div class="Row BVyG0">
                                            <div class="Col Col--12 Col--md-6">
                                                <div class="LLBYg FWbqn">
                                                    {{ $page->description ?? '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                    @if (isset($data->app->landingpages) &&
                            array_reduce(
                                $data->app->landingpages,
                                fn($carry, $item) => $carry || ($item->section_type === 'faq' && $item->page_type === 'Eli'),
                                false))
                        <div class="CSz1m">
                            <div class="Container Cu6Nx">
                                <div class="Row BVyG0">
                                    <div class="Col Col--12 Col--md-8">
                                        <h2 class="H1">Frequently Asked Questions</h2>
                                    </div>
                                </div>
                                <div class="Row BVyG0">
                                    <div class="Col Col--12 Col--md-6">
                                        <div class="QQCZW">
                                            <ul>
                                                @foreach ($data->app->landingpages as $page)
                                                    @if ($page->page_type === 'Eli' && $page->section_type === 'faq' && $page->status === 1)
                                                        <li class="AI3Of">
                                                            <div class="ECk_t toggle-accordian"> {{ $page->title ?? '' }}
                                                                <svg class="Z0g3x fnEny"
                                                                    preserveAspectRatio="xMidYMid meet"
                                                                    style="fill:currentcolor" viewBox="0 0 26 26"
                                                                    role="img">
                                                                    <title>Plus Icon</title>
                                                                    <path fill="currentColor"
                                                                        d="M13 .2c.9 0 1.6.7 1.6 1.6v9.6h9.6a1.6 1.6 0 110 3.2h-9.6v9.6a1.6 1.6 0 11-3.2 0v-9.6H1.8a1.6 1.6 0 110-3.2h9.6V1.8c0-.9.7-1.6 1.6-1.6z"
                                                                        fill-rule="evenodd"></path>
                                                                </svg>
                                                            </div>
                                                            <div class="l1yIj" style="display:none;">
                                                                {{ $page->description ?? '' }}</div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (isset($data->app->landingpages))
                        @foreach ($data->app->landingpages as $page)
                            @if ($page->page_type === 'Eli' && $page->section_type === 'section' && $page->status === 1 && $page->order === 3)
                                <div class="cgg2s">
                                    <div class="Container Cu6Nx">
                                        <div class="Row kGgaU BVyG0">
                                            <div class="Col Col--12 Col--md-6 BfEsx">
                                                <h2>{{ $page->title ?? '' }}</h2>
                                                <div class="LLBYg moRjH FWbqn">
                                                    {{ $page->description ?? '' }}
                                                </div>
                                                @if (\App\Services\AppConfig::get()->app->app_info->is_signup_btn_show === 'Y')
                                                    <a href="/signup">
                                                        <button class="Button Button--large Button--secondary">
                                                            <div class="Button__bg"></div>
                                                            <div class="Button__content">Register Free</div>
                                                        </button>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif

                    <div class="ka_NW">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

    <script>
        $('.toggle-accordian').click(function(event) {
            $(this).next().slideToggle();
        })

        function dropdownHandle(e) {
            $(`.profiledropin:eq(${$(e).data('index')})`).slideToggle();
        }
    </script>
    <script>
        $(document).ready(function() {
            // Listen for click event on the SVG icon
            $('.phovn').click(function(event) {
                // Prevent the default behavior of the SVG click
                event.preventDefault();

                // Trigger the form submission
                $(this).closest('form').submit();
            });
        });
    </script>
@endsection
