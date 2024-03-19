<section class="header">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-md fixed-top">
            <a class="navbar-brand" href="/"><img alt="logo"
                    src="{{ \App\Services\AppConfig::get()->app->app_info->website_logo ?? '' }}"></a>
            <button class="navbar-toggler" type="button" onclick="openNav()">
                <span class="toggle-icon"><i class="fa fa-bars" aria-hidden="true"></i></span>
            </button>
            <div class="collapse navbar-collapse justify-content-md-center sidenav" id="mySidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><img class="timesImg"
                        src="images/times.png"></a>
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
                <div class="btns">
                    <a href="/searchscreen">
                        <i class="bi bi-search search-icon"></i>
                    </a>
                </div>
                @if (session()->has('USER_DETAILS'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                            aria-expanded="false">
                            <div class="signin">&nbsp;</div>MJ
                        </a>
                        <div class="dropdown-menu drpdown_borde">
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
