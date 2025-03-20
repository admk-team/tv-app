<!DOCTYPE html>
<html>

<head>
    @if (env('APP_CODE') == '4lIxYy5Ac430Pfy0O0YrEzjlDpyvuPl6')
        <!--Solace Adsence Start-->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6509344422546339"
            crossorigin="anonymous"></script>
        <!-- Adsence End-->
    @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:title" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_title ?? '' }}" />
    <meta property="og:image" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_image ?? '' }}" />
    <meta property="og:description" content="{!! strip_tags(\App\Services\AppConfig::get()->app->app_info->seo_description ?? '') !!}" />
    <title>{{ \App\Services\AppConfig::get()->app->app_info->app_name ?? '' }}</title>
    <link rel="icon" href="{{ \App\Services\AppConfig::get()->app->app_info->website_faviocn ?? '' }}">
    <style>
        :root {
            --bgcolor: {{ \App\Services\AppConfig::get()->app->website_colors->bgcolor }};
            --themeActiveColor: {{ \App\Services\AppConfig::get()->app->website_colors->themeActiveColor }};
            --headerBgColor: {{ \App\Services\AppConfig::get()->app->website_colors->headerBgColor }};
            --themePrimaryTxtColor: {{ \App\Services\AppConfig::get()->app->website_colors->themePrimaryTxtColor }};
            --themeSecondaryTxtColor: {{ \App\Services\AppConfig::get()->app->website_colors->themeSecondaryTxtColor }};
            --navbarMenucolor: {{ \App\Services\AppConfig::get()->app->website_colors->navbarMenucolor }};
            --navbarSearchColor: {{ \App\Services\AppConfig::get()->app->website_colors->navbarSearchColor }};
            --footerbtmBgcolor: {{ \App\Services\AppConfig::get()->app->website_colors->footerbtmBgcolor }};
            --slidercardBgColor: {{ \App\Services\AppConfig::get()->app->website_colors->slidercardBgColor }};
            --slidercardTitlecolor: {{ \App\Services\AppConfig::get()->app->website_colors->slidercardTitlecolor }};
            --slidercardCatColor: {{ \App\Services\AppConfig::get()->app->website_colors->slidercardCatColor }};
            --cardDesColor: {{ \App\Services\AppConfig::get()->app->website_colors->cardDesColor }};
        }
    </style>
    <style>
        .nav_btnlink {
            cursor: pointer;
        }

        .userimg {
            width: 40px;
            height: 40px;
            border-radius: 50% 50%;
            font-size: 20px;
            font-weight: bold;
            color: var(--themePrimaryTxtColor);
            padding: 4px 2px;
            text-align: center;
            background: var(--themeActiveColor);
        }

        .dropdown_menus {
            position: absolute;
            top: 161%;
            left: 0;
            z-index: 1000;
            float: left;
            min-width: 10rem;
            padding: .5rem 0;
            margin: .125rem 0 0;
            font-size: 1rem;
            display: none;
            color: #212529;
            text-align: left;
            list-style: none;
            background-color: var(--themePrimaryTxtColor);
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, .15);
            border-radius: .25rem
        }

        .avtartMenu {
            padding-bottom: 0 !important;
            padding-top: 0 !important;
            min-width: 167px !important;
            margin-top: 5px !important;
            left: unset !important;
            right: 0 !important;
            border: unset !important;
            background-clip: unset !important;
            box-shadow: 0 1px 5px 0 rgb(0 0 0 / 22%);
        }

        ul.profiledropin {
            padding: 0px 0px !important;
            margin: 0px 0px !important;
        }

        ul.profiledropin li a {
            font-size: 14px;
            font-family: 'Noto Sans';
            padding: 6px 10px;
            display: block;
            width: 100%;
            color: black;
        }

        ul.profiledropin li a:hover {
            background: var(--themeActiveColor);
            color: var(--themePrimaryTxtColor);
        }

        .avtartMenu li a {
            font-size: 14px !important;
            text-transform: capitalize !important;
            font-family: inherit !important;
        }
    </style>
    @yield('head')
</head>

<body>
    @yield('content')

    @yield('scripts')
</body>

</html>
