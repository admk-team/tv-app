<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @stack('title')
    </title>
    {{-- Old Css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style-old.css') }}">
    <style>
        :root {
          --bgcolor: {{ $api_data->app->website_colors->bgcolor }};
          --themeActiveColor: {{ $api_data->app->website_colors->themeActiveColor }};
          --headerBgColor: {{ $api_data->app->website_colors->headerBgColor }};
          --themePrimaryTxtColor: {{ $api_data->app->website_colors->themePrimaryTxtColor }};
          --themeSecondaryTxtColor: {{ $api_data->app->website_colors->themeSecondaryTxtColor }};
          --navbarMenucolor: {{ $api_data->app->website_colors->navbarMenucolor }};
          --navbarSearchColor: {{ $api_data->app->website_colors->navbarSearchColor }};
          --footerbtmBgcolor: {{ $api_data->app->website_colors->footerbtmBgcolor }};
          --slidercardBgColor: {{ $api_data->app->website_colors->slidercardBgColor }};
          --slidercardTitlecolor: {{ $api_data->app->website_colors->slidercardTitlecolor }};
          --slidercardCatColor: {{ $api_data->app->website_colors->slidercardCatColor }};
          --cardDesColor: {{ $api_data->app->website_colors->cardDesColor }};
        }
    </style>
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    {{-- Icons --}}
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    {{-- Booststrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick-theme.css') }}">
    {{-- Owl Carousal --}}
    <link rel="stylesheet" href="{{ asset('assets/owlcarousal/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/owlcarousal/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/regular.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@100;200;300;400;500;600;700;800&display=swap');
    </style>
    {{-- Custom Css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>

    @include('layouts.partials.header')

    <div class="content">
        @yield('content')
    </div>

    @include('layouts.partials.footer')

    {{-- Booststrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    {{-- Owl Carousal --}}
    <script src="{{ asset('assets/owlcarousal/js/owl.carousel.min.js') }}"></script>
    
    <script src="{{ asset('assets/js/cust-frm-validation.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/jquery.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.jscroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/js/year_select.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    {{-- Custom JS --}}
    <script>
        $(document).ready(function() {
            let root = document.querySelector(":root");

            root.style.setProperty("--bg-color", '{{ $api_data->app->website_colors->bgcolor }}');
            root.style.setProperty("--header-bg-color", '{{ $api_data->app->website_colors->headerBgColor }}');
            root.style.setProperty("--active-color", '{{ $api_data->app->website_colors->themeActiveColor }}');
            root.style.setProperty("--nav-color", '{{ $api_data->app->website_colors->navbarMenucolor }}');
            root.style.setProperty("--primary-text-color", '{{ $api_data->app->website_colors->themePrimaryTxtColor }}');
            root.style.setProperty("--secondary-text-color", '{{ $api_data->app->website_colors->themeSecondaryTxtColor }}');
            root.style.setProperty("--footer-bg-color", '{{ $api_data->app->website_colors->footerbtmBgcolor }}');
            root.style.setProperty("--nav-search-color", '{{ $api_data->app->website_colors->navbarSearchColor }}');
            root.style.setProperty("--card-desc-color", '{{ $api_data->app->website_colors->cardDesColor }}');
            root.style.setProperty("--slider-card-bg-color", '{{ $api_data->app->website_colors->slidercardBgColor }}');
            root.style.setProperty("--slider-card-title-color", '{{ $api_data->app->website_colors->slidercardTitlecolor }}');
            root.style.setProperty("--slider-card-cat-color", '{{ $api_data->app->website_colors->slidercardCatColor }}');
        });
    </script>

    @stack('scripts')
</body>

</html>
