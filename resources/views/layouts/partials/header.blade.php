<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    body {
        overflow-x: hidden;
    }

    .header__logo {
        max-width: 15%;
        width: 100px;
    }

    .header__logo img {
        width: 100%;
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
        color: var(--bgcolor) !important;
    }

    {{--  #split_menu_links:hover a {
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
        color: var(--themePrimaryTxtColor);
        border-radius: 4px;
        padding: 8px 12px;
    }  --}} .menu-icon {
        display: none;
    }

    .header-text {
        color: var(--themePrimaryTxtColor);
    }

    @media only screen and (max-width: 1100px) {

        .header .inner {
            flex-direction: column;
        }
    }

    @media only screen and (max-width: 768px) {
        .header .inner {
            flex-direction: row;
            display: flex;
            justify-content: space-between;
        }

        .nav-links-items {
            display: none !important;
        }

        .menu-links {
            display: none !important;
        }

        /*
        .menu-icon i {
            color: var(--themePrimaryTxtColor);
            border-radius: 4px;
            display: block;

        }
        */

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
        /* right: 5%; */
        /* width: 100%; */
        width: 60%;
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

    .nav-links-items {
        background-color: var(--themeActiveColor);
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        gap: 1rem;
        margin-bottom: 0 !important;
        padding-left: 0 !important;
        border-radius: 40px;
    }

    .nav-links-items li {
        padding: 1rem;
    }

    .nav-links-items a {
        color: var(--themePrimaryTxtColor);
        font-weight: 600;
    }

    .nav-links-items li:hover {
        color: var(--themePrimaryTxtColor);
        background-color: var(--bgcolor);
    }

    .nav-links-items li:first-child:hover {
        border-top-left-radius: 40px;
        border-bottom-left-radius: 40px;
    }

    .nav-links-items li:last-child:hover {
        border-top-right-radius: 40px;
        border-bottom-right-radius: 40px;
    }

    /* .nav-links-items li:hover:not(:first-child):not(:last-child) {
    color: var(--themePrimaryTxtColor);
    background-color: red;
}

.nav-links-items li:first-child:hover {
    color: var(--themePrimaryTxtColor);
    background-color: red;
    border-top-left-radius: 40px;
    border-bottom-left-radius: 40px;
}

.nav-links-items li:last-child:hover {
    color: var(--themePrimaryTxtColor);
    background-color: red;
    border-top-right-radius: 40px;
} */



    .nav-links-items li.active:hover {
        color: var(--themePrimaryTxtColor);
        background-color: var(--bgcolor);
    }

    /* Fixed menus */
    .fixed-menu {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        /* Adjust z-index as needed */

    }

    .fixed-menu2 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        /* Adjust z-index as needed */
    }

    /* Non-fixed menus */
    .non-fixed-menu {
        /* Add your styling for non-fixed menus */
    }

    /* Content */
    .content {
        padding-top: 0;
        /* Initially no padding */
    }

    /* Add padding to content when menus are fixed */
    .fixed-menu~.content {
        padding-top: 115px;
        /* Adjust the value as needed */
    }

    .fixed-menu2~.content {
        padding-top: 280px;
        /* Adjust the value as needed */
    }

    .fixed-header-height {
        height: 100px;
    }
</style>

{{-- @if (\App\Services\AppConfig::get()->app->app_info->web_menu == 'Center')
    @include('layouts.partials.tv_menu_header')
@else
    @include('layouts.partials.default-header')
@endif --}}


@php
    $webMenu = \App\Services\AppConfig::get()->app->app_info->web_menu ?? 'default';
@endphp

@switch($webMenu)
    @case('default')
    @case('left')
        @include('layouts.partials.default-header')
        @break
    @case('center')
        @include('layouts.partials.tv_menu_header')
        @break
    @case('righSide-Header')
        @include('layouts.partials.side-header')
        @break
    @case('centered-Header')
        @include('layouts.partials.centered-header')
        @break
    @case('splitNav-Header')
        @include('layouts.partials.split-center-header')
        @break
    @case('splitNavButton-Header')
        @include('layouts.partials.split-nav-button-header')
        @break
    @case('darkNavLinks-Header')
        @include('layouts.partials.5th-header')
        @break
@endswitch




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

            // Check localStorage for the side-header state
            if (localStorage.getItem('sideHeaderState') === 'show') {
                sideHeader.classList.add('show');
                sideHeader.style.overflow = "hidden";
            }

            navbarToggler.addEventListener('click', () => {
                sideHeader.classList.toggle('show');
                if (sideHeader.classList.contains('show')) {
                    sideHeader.style.overflow = "hidden";
                    localStorage.setItem('sideHeaderState', 'show');
                } else {
                    sideHeader.style.overflow = "hidden";
                    localStorage.setItem('sideHeaderState', 'hide');
                }
            });
        });

        // document.addEventListener('DOMContentLoaded', (event) => {
        //     const sideHeader = document.querySelector('.side-header');
        //     const navbarToggler = document.querySelector('.navbar-toggler');
        //     const body = document.body;

        //     navbarToggler.addEventListener('click', () => {
        //         sideHeader.classList.toggle('show');
        //         if (sideHeader.classList.contains('show')) {
        //             sideHeader.style.overflow = "hidden";
        //         } else {
        //             sideHeader.style.overflow = "hidden";
        //         }

        //     });
        // });
    </script>
@endpush
