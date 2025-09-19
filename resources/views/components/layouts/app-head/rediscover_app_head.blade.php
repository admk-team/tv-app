 <!-- Rediscover -->

 <head>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     {{--  <meta name="csrf-token" content="{{ csrf_token() }}" />  --}}


     @if (isset(\App\Services\AppConfig::get()->app->app_info->is_gtm_enabled) &&
             \App\Services\AppConfig::get()->app->app_info->is_gtm_enabled == 1)
         <!-- Google Tag Manager -->
         <script>
             (function(w, d, s, l, i) {
                 w[l] = w[l] || [];
                 w[l].push({
                     'gtm.start': new Date().getTime(),
                     event: 'gtm.js'
                 });
                 var f = d.getElementsByTagName(s)[0],
                     j = d.createElement(s),
                     dl = l != 'dataLayer' ? '&l=' + l : '';
                 j.async = true;
                 j.src =
                     'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                 f.parentNode.insertBefore(j, f);
             })(window, document, 'script', 'dataLayer', 'GTM-KG9QRPKN');
         </script>
         <!-- End Google Tag Manager -->
     @endif
     @if (Route::is('detailscreen', 'playerscreen', 'series'))
         @yield('meta-tags')
     @else
         <meta property="og:title" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_title ?? '' }}" />
         <meta property="og:image" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_image ?? '' }}" />
         <meta property="og:description" content="{!! strip_tags(\App\Services\AppConfig::get()->app->app_info->seo_description ?? '') !!}" />
     @endif
     <title>
         {{ \App\Services\AppConfig::get()->app->app_info->app_name ?? '' }}
     </title>
     @stack('style')
     {{-- Old Css --}}

     <link rel="shortcut icon" href="{{ \App\Services\AppConfig::get()->app->app_info->website_faviocn ?? '' }}">
     <link rel="stylesheet" href="{{ asset('assets/css/style-old.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/userprofile.css') }}">
     @if (isset(\App\Services\AppConfig::get()->app->app_info->faq_section) &&
             \App\Services\AppConfig::get()->app->app_info->faq_section == 1)
         <link rel="stylesheet" href="{{ asset('assets/css/faq_style.css') }}">
     @endif
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
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
         rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
         integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <link rel="stylesheet" href="{{ asset('assets/owlcarousal/css/owl.carousel.min.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/owlcarousal/css/owl.theme.default.min.css') }}">
     <link rel="stylesheet" type="text/css" href="{{ asset('assets/slick/slick.css') }}">
     <link rel="stylesheet" type="text/css" href="{{ asset('assets/slick/slick-theme.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/regular.min.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
     <style>
         @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@100;200;300;400;500;600;700;800&display=swap');
     </style>
     {{-- Custom Css --}}
     <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
     <meta name="csrf_token" content="{{ csrf_token() }}" />
     @yield('head')
     {{-- alert csss --}}
     <link rel="stylesheet" href="sweetalert2.min.css">
     @include('layouts.one-signal.one-signal-scripts')
 </head>

 <body>
     @if (isset(\App\Services\AppConfig::get()->app->app_info->is_gtm_enabled) &&
             \App\Services\AppConfig::get()->app->app_info->is_gtm_enabled == 1)
         <!-- Google Tag Manager (noscript) -->
         <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KG9QRPKN" height="0" width="0"
                 style="display:none;visibility:hidden"></iframe></noscript>
         <!-- End Google Tag Manager (noscript) -->
     @endif
