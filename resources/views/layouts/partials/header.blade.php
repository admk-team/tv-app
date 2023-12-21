<header class="header">
    <nav class="inner">
        <ul class="links">
            <li class="logo">
                <a href="/">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="">
                </a>
            </li>
            @foreach ($api_data->app->menus as $menu)
                @if (!in_array($menu->menu_type, ['HO', 'SE', 'ST', 'PR']))
                    <a class="text-decoration-none" href="/{{ $menu->menu_slug }}">
                        <li class="pc">{{ $menu->menu_title }}</li>
                    </a>
                @endif
            @endforeach
        </ul>
        <div class="btns">
            <a href="/search">
                <i class="bi bi-search search"></i>
            </a>
            <a class="auth app-primary-btn" href="/login">Login</a>
            <a class="auth app-secondary-btn" href="/signup">Signup</a>
        </div>
        <div class="menu-icon" onclick="mobileMenuHandler()">
            <i class="bi bi-list"></i>
        </div>
    </nav>
    <div class="mbl-menu">
        <i class="bi bi-x-lg close-icon" onclick="mobileMenuHandler()"></i>
        <ul>
            @foreach ($api_data->app->menus as $menu)
                @if (!in_array($menu->menu_type, ['HO', 'SE', 'ST', 'PR']))
                    <a class="text-decoration-none" href="/{{ $menu->menu_slug }}">
                        <li class="pc">{{ $menu->menu_title }}</li>
                    </a>
                @endif
            @endforeach
        </ul>
        <div class="btns">
            <a href="/search">
                <i class="bi bi-search search"></i>
            </a>
            <a class="auth app-primary-btn" href="/login">Login</a>
            <a class="auth app-secondary-btn" href="{{ route('register') }}">Signup</a>
        </div>
    </div>
</header>

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
    </script>
@endpush
