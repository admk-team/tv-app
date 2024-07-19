    <header class="header fixed-menu">
        <nav class="inner mt-2">
            <div class="header__logo">
                <a href="/">
                    <img src="{{ \App\Services\AppConfig::get()->app->app_info->website_logo ?? '' }}">
                </a>
            </div>

            <ul class="nav-links-items">
                @foreach (\App\Services\AppConfig::get()->app->menus as $menu)
                    @if (!in_array($menu->menu_type, ['HO', 'SE', 'ST', 'PR']))
                        @if ($menu->menu_type === 'FA' && !session()->has('USER_DETAILS.USER_CODE'))
                            @continue
                        @endif
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

            <div class="btns">
                <a href="/searchscreen">
                    <i class="bi bi-search search-icon"></i>
                </a>
               @if (session()->has('USER_DETAILS') && session('USER_DETAILS') !== null)
                    <li class="nav-item">
                        <div class="dropdown dropdin">
                            <div class="nav_btnlink" id="dropdownMenuLink1" onclick="dropdownHandle(this)" data-index=0>
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
            <div class="btns">
                <a href="/searchscreen">
                    <i class="bi bi-search search-icon"></i>
                </a>
               @if (session()->has('USER_DETAILS') && session('USER_DETAILS') !== null)
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
                    <a class="auth app-primary-btn" href="/login">Login</a>
                    <a class="auth app-secondary-btn" href="{{ route('register') }}">Signup</a>
                @endif
            </div>
        </div>
    </header>
