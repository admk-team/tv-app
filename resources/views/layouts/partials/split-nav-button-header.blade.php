<header class="pt-4">
    <div class="wrapper d-flex align-items-center justify-content-around ">
        <div class="py-3 my-2 header__logo">
            <a href="/">
                <img src="{{ \App\Services\AppConfig::get()->app->app_info->website_logo ?? '' }}" alt="Logo">
            </a>
        </div>
        <div class="btns d-flex align-items-center gap-3">
            <a href="/searchscreen" class="search-box header-text">
                <i class="bi bi-search search-icon"></i>
            </a>
            @if (session()->has('USER_DETAILS') && session('USER_DETAILS') !== null)
                <form id="subscribe-form-toggle" method="POST" action="{{ route('toggle.subscribe') }}">
                    @csrf
                    <button id="subscribe-button-toggle" class="sub-btn-icon rounded" type="submit">
                        <i id="subscribe-icon" class="fas fa-bell"></i> <!-- Default icon -->
                        <span id="subscribe-text"></span>
                    </button>
                    <div id="response-message">{{ session('status') }}</div>
                </form>
                <li class="nav-item">
                    <div class="dropdown dropdin">
                        <div class="nav_btnlink" id="dropdownMenuLink1" onclick="dropdownHandle(this)" data-index=0>
                            <div class="userimg">{{ session('USER_DETAILS')['USER_NAME'][0] }}</div>
                        </div>
                        <ul class="dropdown_menus profiledropin avtartMenu" style="display: none;">
                            <li style="display: none;"><a href="update-profile.php"><span
                                        class="userno">user-26</span></a></li>
                            @if (\App\Services\AppConfig::get()->app->app_info->profile_manage == 1)
                                <li><a class="text-decoration-none" href="{{ route('profile.index') }}">Profiles</a>
                                </li>
                                <li><a class="text-decoration-none"
                                        href="{{ route('profile.manage', session('USER_DETAILS')['USER_ID']) }}">Manage
                                        Profiles</a></li>
                            @endif
                            <li><a class="text-decoration-none" href="{{ route('transaction-history') }}">Transaction
                                    History</a></li>
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
                            <li><a class="text-decoration-none" href="{{ route('logout') }}">Logout</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @else
                <a class="auth app-primary-btn rounded" href="/login">Login</a>
                @if (\App\Services\AppConfig::get()->app->app_info->is_signup_btn_show === 'Y')
                    <a class="auth app-secondary-btn rounded" href="/signup">Signup</a>
                @endif
            @endif
        </div>
        <div class="menu-icon mx-4" onclick="mobileMenuHandler()">
            <i class="bi bi-list"></i>
        </div>
    </div>
    <nav class="mx-4 split_nav">
        <ul class="d-flex align-items-center justify-content-center gap-1 flex-wrap mb-0"
            style="padding-left: 0 !important;">
            @foreach (\App\Services\AppConfig::get()->app->menus as $menu)
                @if (!in_array($menu->menu_type, ['HO', 'SE', 'ST', 'PR']))
                    @if ($menu->menu_type === 'FA' && !session()->has('USER_DETAILS.USER_CODE'))
                        @continue
                    @endif
                    <a class="text-decoration-none header-text border-hover" href="/{{ $menu->menu_slug }}">
                        <li class="pc">{{ $menu->menu_title }}</li>
                    </a>
                @endif
            @endforeach
            @foreach (\App\Services\AppConfig::get()->app->data->pages as $page)
                @if ($page->displayOn === 'H' || $page->displayOn === 'B')
                    @if ($page->pageType === 'E')
                        <a class="text-decoration-none text-white border-hover" href="{!! $page->externalLink !!}"
                            target="_blank">
                            <li class="pc">{{ $page->page_title }}</li>
                        </a>
                    @else
                        <a class="text-decoration-none header-text border-hover" href="/page/{{ $page->page_slug }}">
                            <li class="pc">{{ $page->page_title }}</li>
                        </a>
                    @endif
                @endif
            @endforeach
        </ul>

    </nav>

    <div class="mbl-menu">
        <i class="bi bi-x-lg close-icon" onclick="mobileMenuHandler()"></i>
        <ul>
            @foreach (\App\Services\AppConfig::get()->app->menus as $menu)
                @if (!in_array($menu->menu_type, ['HO', 'SE', 'ST', 'PR']))
                    <a class="text-decoration-none" href="/{{ $menu->menu_slug }}">
                        <li class="pc">{{ $menu->menu_title }}</li>
                    </a>
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
                @if (session()->has('USER_DETAILS') && session('USER_DETAILS') !== null)
                    <form id="subscribe-form-toggle" method="POST" action="{{ route('toggle.subscribe') }}">
                        @csrf
                        <button id="subscribe-button-toggle" class="sub-btn-icon rounded" type="submit">
                            <i id="subscribe-icon" class="fas fa-bell"></i> <!-- Default icon -->
                            <span id="subscribe-text"></span>
                        </button>
                        <div id="response-message">{{ session('status') }}</div>
                    </form>
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
                                <li><a class="text-decoration-none"
                                        href="{{ route('transaction-history') }}">Transaction
                                        History</a></li>
                                <li><a class="text-decoration-none" href="{{ route('password.edit') }}">Change
                                        Password</a>
                                </li>
                                <li><a class="text-decoration-none" href="{{ route('logout') }}">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                @else
                    <a class="auth app-primary-btn rounded" href="/login">Login</a>
                    <a class="auth app-secondary-btn rounded" href="{{ route('register') }}">Signup</a>
                @endif
            </div>
        @endif
        @if (\App\Services\AppConfig::get()->app->app_info->web_menu === 'Left')
            <div class="btns">

                @if (session()->has('USER_DETAILS') && session('USER_DETAILS') !== null)
                    <form id="subscribe-form-toggle" method="POST" action="{{ route('toggle.subscribe') }}">
                        @csrf
                        <button id="subscribe-button-toggle" class="sub-btn-icon rounded" type="submit">
                            <i id="subscribe-icon" class="fas fa-bell"></i> <!-- Default icon -->
                            <span id="subscribe-text"></span>
                        </button>
                        <div id="response-message">{{ session('status') }}</div>
                    </form>
                    <li class="nav-item">
                        <div class="dropdown dropdin">
                            <div class="nav_btnlink" id="dropdownMenuLink1" onclick="dropdownHandle(this)"
                                data-index=1>
                                <div class="userimg">u</div>
                            </div>
                            <ul class="dropdown_menus profiledropin avtartMenu gap-0"
                                style="display: none; left: 50% !important; position: absolute; transform: translateX(-50%);">
                                <li style="display: none;"><a href="update-profile.php"><span
                                            class="userno">user-26</span></a></li>
                                <li><a class="text-decoration-none" href="{{ route('profile.index') }}">Profiles</a>
                                </li>
                                <li><a class="text-decoration-none"
                                        href="{{ route('transaction-history') }}">Transaction
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
