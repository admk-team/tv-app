<section class="header fixed-menu">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-md fixed-top fixed-header-height">
            <a class="navbar-brand" href="/"><img alt="logo"
                    src="{{ \App\Services\AppConfig::get()->app->app_info->website_logo ?? '' }}"></a>
            <button class="navbar-toggler" type="button" onclick="openNav()">
                <span class="toggle-icon"><i class="fa fa-bars" aria-hidden="true"></i></span>
            </button>
            <div class="collapse navbar-collapse justify-content-md-center sidenav" id="mySidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">
                    <img class="timesImg" src="{{ asset('assets/images/times.png') }}">
                </a>
                <ul class="navbar-nav navbar_center">
                    @php
                        $count = 0;
                    @endphp

                    @foreach (\App\Services\AppConfig::get()->app->menus as $menu)
                        @if (!in_array($menu->menu_type, ['HO', 'SE', 'ST', 'PR']))
                            @if ($count >= 10)
                            @break
                        @endif
                        @php
                            $count++;
                        @endphp

                        {{-- Skip if the menu is of type 'FA' and the user is not logged in --}}
                        @if ($menu->menu_type === 'FA' && !session()->has('USER_DETAILS.USER_CODE'))
                            @continue
                        @endif
                        @if (!empty($menu->for_group_user))
                            {{-- Check if the user has a group assigned in session --}}
                            @if (session()->has('USER_DETAILS.GROUP_USER') && !empty(session('USER_DETAILS.GROUP_USER')))
                                @php
                                    // Ensure both are arrays
                                    $menuGroups = is_array($menu->for_group_user)
                                        ? $menu->for_group_user
                                        : explode(',', (string) $menu->for_group_user);
                                    $userGroups = is_array(session('USER_DETAILS.GROUP_USER'))
                                        ? session('USER_DETAILS.GROUP_USER')
                                        : explode(',', (string) session('USER_DETAILS.GROUP_USER'));

                                    // Find common groups
                                    $commonGroups = array_intersect($menuGroups, $userGroups);
                                @endphp

                                {{-- If there's at least one common group, show the menu --}}
                                @if (!empty($commonGroups))
                                    {{-- Show the menu if it is not for group users --}}
                                    <li class="nav-item">
                                        <a class="nav-link" href="/{{ $menu->menu_slug }}">
                                            <div id="movies" class="clsiconmenu"
                                                style="background: url('{{ $menu->tv_menu_icon_active ?? '' }}');">
                                                &nbsp;
                                            </div>
                                            {{ $menu->menu_title }}
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @else
                            {{-- Show the menu if it is not for group users --}}
                            <li class="nav-item">
                                <a class="nav-link" href="/{{ $menu->menu_slug }}">
                                    <div id="movies" class="clsiconmenu"
                                        style="background: url('{{ $menu->tv_menu_icon_active ?? '' }}');">
                                        &nbsp;
                                    </div>
                                    {{ $menu->menu_title }}
                                </a>
                            </li>
                        @endif
                    @endif
                @endforeach

                @foreach (\App\Services\AppConfig::get()->app->data->pages as $page)
                    @if ($count >= 10)
                    @break
                @endif
                @php
                    $count++;
                @endphp
                @if ($page->displayOn === 'H' || $page->displayOn === 'B')
                    @if ($page->pageType === 'E')
                        <li class="nav-item">
                            <a class="nav-link" href="{!! $page->externalLink !!}">
                                <div id="movies" class="clsiconmenu"
                                    style="background: url('{{ $page->page_banner_poster ?? '' }}');">
                                    &nbsp;
                                </div>
                                {{ $page->page_title }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/page/{{ $page->page_slug }}">
                                <div id="movies" class="clsiconmenu"
                                    style="background: url('{{ $page->page_banner_poster ?? '' }}');">
                                    &nbsp;
                                </div>
                                {{ $page->page_title }}
                            </a>
                        </li>
                    @endif
                @endif
            @endforeach

            {{--  <div class="btns">
                    <a href="/searchscreen">
                        <i class="bi bi-search search-icon"></i>
                    </a>
                </div>  --}}
            <li class="nav-item"><a class="nav-link" href="/searchscreen">
                    <button type="submit"
                        style="text-decoration:none;border: none;background-color: transparent;">
                        <div class="search">&nbsp;</div>
                    </button>
                </a>
            </li>
            @if (session()->has('USER_DETAILS') && session('USER_DETAILS') !== null)
                <li class="nav-item">
                    <div class="mt-2">
                        <form id="subscribe-form-toggle" method="POST"
                            action="{{ route('toggle.subscribe') }}">
                            @csrf
                            <button id="subscribe-button-toggle" class="sub-btn-icon rounded" type="submit">
                                <i id="subscribe-icon" class="fas fa-bell"></i> <!-- Default icon -->
                                <span id="subscribe-text"></span>
                            </button>
                            <div id="response-message">{{ session('status') }}</div>
                        </form>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                        aria-expanded="false">
                        <div class="signin">&nbsp;</div>{{ session('USER_DETAILS')['USER_NAME'][0] }}
                    </a>
                    <div class="dropdown-menu drpdown_borde">
                        <ul class="dropsmenubox">
                            @if (\App\Services\AppConfig::get()->app->app_info->profile_manage == 1)
                                <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profiles</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('profile.manage', session('USER_DETAILS')['USER_ID']) }}">Manage
                                        Profiles</a></li>
                                <li><a class="text-decoration-none"
                                        href="{{ route('profile.setting', session('USER_DETAILS')['USER_ID']) }}">Setting
                                    </a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('transaction-history') }}">Transaction
                                    History</a></li>
                            <li><a class="dropdown-item" href="{{ route('password.edit') }}">Change
                                    Password</a></li>
                            @if (\App\Services\AppConfig::get()->app->app_info->watch_history === 1)
                                <li><a class="dropdown-item" href="{{ route('watch.history') }}">Watch
                                        History</a></li>
                            @endif
                            @if (isset(\App\Services\AppConfig::get()->app->badge_status) && \App\Services\AppConfig::get()->app->badge_status === 1)
                                <li><a class="dropdown-item" href="{{ route('user.badge') }}">User
                                        Badge</a>
                                </li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </div>
                </li>
            @else
                <li class="nav-item"><a class="nav-link" href="/login">
                        <div class="signin">&nbsp;</div>LOGIN
                    </a></li>
                <li class="nav-item"><a class="nav-link" href="/signup">Register</a></li>
            @endif
        </ul>
    </div>
</nav>
</header>
</div>
</section>
