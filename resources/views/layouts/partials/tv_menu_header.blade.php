<section class="header">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-md fixed-top">
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
                            @if ($count >= 9)
                            @break
                        @endif
                        @php
                            $count++;
                        @endphp
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
                @if (session()->has('USER_DETAILS'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                            aria-expanded="false">
                            <div class="signin">&nbsp;</div>{{ session('USER_DETAILS')['USER_NAME'][0] }}
                        </a>
                        <div class="dropdown-menu drpdown_borde">
                            <ul class="dropsmenubox">
                                <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profiles</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('profile.manage', session('USER_DETAILS')['USER_ID']) }}">Manage
                                        Profiles</a></li>
                                <li><a class="dropdown-item" href="{{ route('password.edit') }}">Change
                                        Password</a></li>
                                @if (\App\Services\AppConfig::get()->app->app_info->watch_history === 1)
                                    <li><a class="dropdown-item" href="{{ route('watch.history') }}">Watch
                                            History</a></li>
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
