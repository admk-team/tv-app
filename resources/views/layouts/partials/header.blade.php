<style>
    body {
        overflow-x: hidden;
    }

    .border-hover {
        cursor: pointer;
        position: relative;
        transition: all 1s;
        padding: 8px 12px;

    }

    .border-hover::after,
    .border-hover::before {
        content: "";
        width: 100%;
        height: 100%;
        position: absolute;
        transition: all 1s;
        border: 0 solid transparent;
        /* Initially no border and transparent */
    }

    .border-hover::after {
        top: -1px;
        left: -1px;
        border-top-width: 0;
        border-left-width: 0;
    }

    .border-hover::before {
        bottom: -1px;
        right: -1px;
        border-bottom-width: 0;
        border-right-width: 0;
    }

    .border-hover:hover {
        border-top-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .border-hover:hover::before,
    .border-hover:hover::after {
        border-color: var(--themeActiveColor);
        border-top-width: 2px;
        border-left-width: 2px;
        border-bottom-width: 2px;
        border-right-width: 2px;
    }



    ul.profiledropin li a {
        color: black !important;
    }

    #split_menu_links:hover a {
        /* transform: scale(.5); */
        opacity: 0.2;
        filter: blur(5px);
        background-color: var(--themeActiveColor);
        border-radius: 4px;
    }

    #split_menu_links a:hover {
        /* transform: scale(1); */
        opacity: 1;
        filter: blur(0);
        text-decoration: none;
        color: #fff;
        border-radius: 4px;
        padding: 8px 12px;
    }

    .menu-icon {
        display: none;
    }

    .menu-icon i {
        display: none;
    }

    @media only screen and (max-width: 768px) {
        .centered-header .menu-links {
            display: none !important;
        }

        .menu-icon i {
            color: #fff;
            font-size: 2rem;
            background-color: var(--themeActiveColor);
            border-radius: 4px;
            padding: 0.2rem;
            display: block;
        }

        .menu-icon {
            display: block;
        }

        .navbar-toggler {
            display: none;
        }

        .side-header {
            display: none;
        }

        /* Split Navbar   */
        .wrapper {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            align-content: center;
            justify-content: space-between;
            align-items: center;
        }

        .split_nav {
            display: none !important;
        }

    }

    .navbar-toggler-icon {
        filter: brightness(10.5);
        order: 3;
    }

    .side-header {
        position: absolute;
        top: 3%;
        right: 5%;
        width: 100%;
        color: white;
        transform: translateX(200%);
        transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        opacity: 0;
        visibility: hidden;
        overflow: hidden;
    }

    .side-header.show {
        transform: translateX(0);
        opacity: 1;
        visibility: visible;
    }

    .navbar-toggler {
        order: 3;
    }

    body.no-scroll {
        overflow: hidden;
    }
</style>

{{-- @if (\App\Services\AppConfig::get()->app->app_info->web_menu == 'Center')
    @include('layouts.partials.tv_menu_header')
@else
    @include('layouts.partials.default-header')
@endif --}}


@if (
    \App\Services\AppConfig::get()->app->app_info->web_menu == 'default' ||
        \App\Services\AppConfig::get()->app->app_info->web_menu == 'left')
    @include('layouts.partials.default-header')
@elseif (\App\Services\AppConfig::get()->app->app_info->web_menu == 'center')
    @include('layouts.partials.tv_menu_header')
@elseif (\App\Services\AppConfig::get()->app->app_info->web_menu == 'righSide-Header')
    @include('layouts.partials.side-header')
@elseif (\App\Services\AppConfig::get()->app->app_info->web_menu == 'centered-Header')
    @include('layouts.partials.centered-header')
@elseif (\App\Services\AppConfig::get()->app->app_info->web_menu == 'splitNav-Header')
    @include('layouts.partials.split-center-header')
@elseif (\App\Services\AppConfig::get()->app->app_info->web_menu == 'splitNavButton-Header')
    @include('layouts.partials.split-nav-button-header')
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

        document.addEventListener('DOMContentLoaded', (event) => {
            const sideHeader = document.querySelector('.side-header');
            const navbarToggler = document.querySelector('.navbar-toggler');
            const body = document.body;

            navbarToggler.addEventListener('click', () => {
                sideHeader.classList.toggle('show');
                if (sideHeader.classList.contains('show')) {
                    sideHeader.style.overflow = "hidden";
                } else {
                    sideHeader.style.overflow = "hidden";
                }

            });
        });
    </script>
@endpush
