    <header class="header fixed-menu">
        <nav class="inner">
            <div class="header__logo d-block">
                <a href="/">
                    <img src="{{ \App\Services\AppConfig::get()->app->app_info->website_logo ?? '' }}" alt="Logo">
                </a>
            </div>

            <div class="side-header position-relative ">
                <div class="pt-4 pb-3 d-flex align-items-center justify-content-center flex-column">
                    <div class="inner d-flex align-items-center justify-content-around gap-5 mb-4">
                        <ul class="menu-links d-flex align-items-center justify-content-center gap-4 flex-wrap mb-0">
                            @foreach (\App\Services\AppConfig::get()->app->menus as $menu)
                                @if (!in_array($menu->menu_type, ['HO', 'SE', 'ST', 'PR']))
                                    {{-- Show the menu if it is for group users and the user is a group user --}}
                                    @if (isset($menu->for_group_user) && $menu->for_group_user === 1)
                                        @if (session()->has('USER_DETAILS.GROUP_USER') && session('USER_DETAILS.GROUP_USER') == 1)
                                            <a class="text-decoration-none header-text" href="/{{ $menu->menu_slug }}">
                                                <li class="pc">{{ $menu->menu_title }}</li>
                                            </a>
                                        @endif
                                    @else
                                        {{-- Show the menu if it is not for group users --}}
                                        <a class="text-decoration-none header-text" href="/{{ $menu->menu_slug }}">
                                            <li class="pc">{{ $menu->menu_title }}</li>
                                        </a>
                                    @endif
                                @endif
                            @endforeach
                            @foreach (\App\Services\AppConfig::get()->app->data->pages as $page)
                                @if ($page->displayOn === 'H' || $page->displayOn === 'B')
                                    @if ($page->pageType === 'E')
                                        <a class="text-decoration-none header-text" href="{!! $page->externalLink !!}"
                                            target="_blank">
                                            <li class="pc">{{ $page->page_title }}</li>
                                        </a>
                                    @else
                                        <a class="text-decoration-none header-text" href="/page/{{ $page->page_slug }}">
                                            <li class="pc">{{ $page->page_title }}</li>
                                        </a>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="btns mt-4">
                <a href="/searchscreen">
                    <i class="bi bi-search search-icon"></i>
                </a>
                <button class="navbar-toggler order-3" type="button">
                    <i class="fa fa-bars"></i>
                </button>
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
                                    <li><a class="text-decoration-none"
                                            href="{{ route('profile.index') }}">Profiles</a>
                                    </li>
                                    <li><a class="text-decoration-none"
                                            href="{{ route('profile.manage', session('USER_DETAILS')['USER_ID']) }}">Manage
                                            Profiles</a></li>
                                @endif
                                <li><a class="text-decoration-none"
                                        href="{{ route('transaction-history') }}">Transaction
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

            <div class="menu-icon" onclick="mobileMenuHandler()">
                <i class="bi bi-list"></i>
            </div>
        </nav>
        <div class="mbl-menu">
            <i class="bi bi-x-lg close-icon" onclick="mobileMenuHandler()"></i>
            <ul>
                @foreach (\App\Services\AppConfig::get()->app->menus as $menu)
                    @if (!in_array($menu->menu_type, ['HO', 'SE', 'ST', 'PR']))
                        {{-- Show the menu if it is for group users and the user is a group user --}}
                        @if (isset($menu->for_group_user) && $menu->for_group_user === 1)
                            @if (session()->has('USER_DETAILS.GROUP_USER') && session('USER_DETAILS.GROUP_USER') == 1)
                                <a class="text-decoration-none header-text" href="/{{ $menu->menu_slug }}">
                                    <li class="pc">{{ $menu->menu_title }}</li>
                                </a>
                            @endif
                        @else
                            {{-- Show the menu if it is not for group users --}}
                            <a class="text-decoration-none header-text" href="/{{ $menu->menu_slug }}">
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
            <div class="btns">
                <a href="/searchscreen">
                    <i class="bi bi-search search-icon"></i>
                </a>
                @if (session()->has('USER_DETAILS') && session('USER_DETAILS') !== null)
                    <div id="notification-container" style="display: none;"></div>

                    <form id="subscribe-form-toggle" action="{{ route('toggle.subscribe') }}" method="POST">
                        @csrf
                        <button id="subscribe-button-toggle" class="sub-btn-icon rounded" type="button">
                            <i id="subscribe-icon" class="fas fa-bell"></i>
                            <span id="subscribe-text"></span>
                        </button>
                        <div id="response-message"></div>
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
                    <a class="auth app-primary-btn rounded" href="/login">Login</a>
                    <a class="auth app-secondary-btn rounded" href="{{ route('register') }}">Signup</a>
                @endif
            </div>
        </div>
    </header>
