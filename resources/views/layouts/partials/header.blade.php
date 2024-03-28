<style>
    ul.profiledropin li a {
        color: black !important;
    }
</style>
@if (\App\Services\AppConfig::get()->app->app_info->web_menu == 'Center')
    @include('layouts.partials.tv_menu_header')
@else
    <header class="header">
        <nav class="inner">
            <ul class="links">
                <li class="logo">
                    <a href="/">
                        <img src="{{ $appInfo->website_logo ?? '' }}" alt="">
                    </a>
                </li>

                @foreach (\App\Services\AppConfig::get()->app->menus as $menu)
                    @if (
                        \App\Services\AppConfig::get()->app->app_info->web_menu === '' ||
                            \App\Services\AppConfig::get()->app->app_info->web_menu == 'Left')
                        @if (!in_array($menu->menu_type, ['HO', 'SE', 'ST', 'PR']))
                            <a class="text-decoration-none" href="/{{ $menu->menu_slug }}">
                                <li class="pc">{{ $menu->menu_title }}</li>
                            </a>
                        @endif
                    @endif
                @endforeach
            </ul>
            @if (\App\Services\AppConfig::get()->app->app_info->web_menu === '')
                <div class="btns">
                    <a href="/searchscreen">
                        <i class="bi bi-search search-icon"></i>
                    </a>
                    @if (session()->has('USER_DETAILS'))
                        <li class="nav-item">
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
                                    <li><a class="text-decoration-none" href="{{ route('logout') }}">Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    @else
                        <a class="auth app-primary-btn rounded" href="/login">Login</a>
                        <a class="auth app-secondary-btn rounded" href="/signup">Signup</a>
                    @endif
                </div>
            @endif
            @if (\App\Services\AppConfig::get()->app->app_info->web_menu === 'Left')
                <div class="btns">
                    @if (session()->has('USER_DETAILS'))
                        <li class="nav-item">
                            <div class="dropdown dropdin">
                                <div class="nav_btnlink" id="dropdownMenuLink1" onclick="dropdownHandle(this)"
                                    data-index=0>
                                    <div class="userimg">{{ session('USER_DETAILS')['USER_NAME'][0] }}</div>
                                </div>
                                <ul class="dropdown_menus profiledropin avtartMenu" style="display: none;">
                                    <li style="display: none;"><a href="update-profile.php"><span
                                                class="userno">user-26</span></a></li>
                                    <li><a class="text-decoration-none"
                                            href="{{ route('profile.index') }}">Profiles</a>
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
                        </li>
                    @else
                </div>
                <div class="links">
                    <a class="text-decoration-none" href="/login">
                        <li class="pc">LOGIN</li>
                    </a>
                    <a class="text-decoration-none" href="/signup">
                        <li class="pc">Register</li>
                    </a>
                    <div class="btns">
                        <a href="/searchscreen">
                            <i class="bi bi-search search-icon"></i>
                        </a>
                    </div>
                </div>
            @endif

@endif

<div class="menu-icon" onclick="mobileMenuHandler()">
    <i class="bi bi-list"></i>
</div>
</nav>
<div class="mbl-menu">
    <i class="bi bi-x-lg close-icon" onclick="mobileMenuHandler()"></i>
    <ul>
        @foreach (\App\Services\AppConfig::get()->app->menus as $menu)
            @if (
                \App\Services\AppConfig::get()->app->app_info->web_menu === '' ||
                    \App\Services\AppConfig::get()->app->app_info->web_menu == 'Left')
                @if (!in_array($menu->menu_type, ['HO', 'SE', 'ST', 'PR']))
                    <a class="text-decoration-none" href="/{{ $menu->menu_slug }}">
                        <li class="pc">{{ $menu->menu_title }}</li>
                    </a>
                @endif
            @endif
        @endforeach
        @foreach (\App\Services\AppConfig::get()->app->data->pages as $page)
            @if ($page->displayOn === 'H' || $page->displayOn === 'B')
                @if ($page->pageType === 'E')
                    <a class="text-decoration-none" href="{!! $page->externalLink !!}" target="_blank">
                        <li class="pc">{{ $page->page_title }}</li>
                    </a>
                @else
                    <a class="text-decoration-none" href="/page/{{ $page->page_slug }}">
                        <li class="pc">{{ $page->page_title }}</li>
                    </a>
                @endif
            @endif
        @endforeach
    </ul>
    @if (\App\Services\AppConfig::get()->app->app_info->web_menu === '')
        <div class="btns">
            <a href="/searchscreen">
                <i class="bi bi-search search-icon"></i>
            </a>
            @if (session()->has('USER_DETAILS'))
                <li class="nav-item">
                    <div class="dropdown dropdin">
                        <div class="nav_btnlink" id="dropdownMenuLink1" onclick="dropdownHandle(this)" data-index=1>
                            <div class="userimg">u</div>
                        </div>
                        <ul class="dropdown_menus profiledropin avtartMenu gap-0"
                            style="display: none; left: 50% !important; position: absolute; transform: translateX(-50%);">
                            <li style="display: none;"><a href="update-profile.php"><span
                                        class="userno">user-26</span></a></li>
                            <li><a class="text-decoration-none" href="{{ route('profile.index') }}">Profiles</a>
                            </li>
                            <li><a class="text-decoration-none" href="{{ route('transaction-history') }}">Transaction
                                    History</a></li>
                            <li><a class="text-decoration-none" href="{{ route('password.edit') }}">Change
                                    Password</a>
                            </li>
                            <li><a class="text-decoration-none" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </div>
                </li>
            @else
                <a class="auth app-primary-btn" href="/login">Login</a>
                <a class="auth app-secondary-btn" href="{{ route('register') }}">Signup</a>
            @endif
        </div>
    @endif
    @if (\App\Services\AppConfig::get()->app->app_info->web_menu === 'Left')
        <div class="btns">

            @if (session()->has('USER_DETAILS'))
                <li class="nav-item">
                    <div class="dropdown dropdin">
                        <div class="nav_btnlink" id="dropdownMenuLink1" onclick="dropdownHandle(this)" data-index=1>
                            <div class="userimg">u</div>
                        </div>
                        <ul class="dropdown_menus profiledropin avtartMenu gap-0"
                            style="display: none; left: 50% !important; position: absolute; transform: translateX(-50%);">
                            <li style="display: none;"><a href="update-profile.php"><span
                                        class="userno">user-26</span></a></li>
                            <li><a class="text-decoration-none" href="{{ route('profile.index') }}">Profiles</a>
                            </li>
                            <li><a class="text-decoration-none" href="{{ route('transaction-history') }}">Transaction
                                    History</a></li>
                            <li><a class="text-decoration-none" href="{{ route('password.edit') }}">Change
                                    Password</a>
                            </li>
                            <li><a class="text-decoration-none" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </div>
                </li>
            @else
                <ul class="list-unstyled">
                    <a class="text-decoration-none" href="/login">
                        <li class="web_menu_left_option_button">LOGIN</li>
                    </a>
                    <a class="text-decoration-none" href="/signup">
                        <li class="web_menu_left_option_button">Register</li>
                    </a>
                </ul>
            @endif
            <a href="/searchscreen">
                <i class="bi bi-search search-icon"></i>
            </a>
        </div>
    @endif
</div>
</header>
@endif
@push('scripts')
    <script>
        function mobileMenuHandler() {
            let mobileMenu = $(".mbl-menu");
            $(mobileMenu).toggleClass("active");

            if ($(mobileMenu).hasClass("active")) {
                $("body").css("overflow", "hidden");
            } else {
                $("body").css("overflow", "visible");
            }
        }

        function dropdownHandle(e) {
            $(`.profiledropin:eq(${$(e).data('index')})`).slideToggle();
        }
    </script>
@endpush
