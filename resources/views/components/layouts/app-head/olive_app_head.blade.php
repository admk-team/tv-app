  <!-- OliveBranch -->
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
      })(window, document, 'script', 'dataLayer', 'GTM-56JGF936');
  </script>
  <!-- End Google Tag Manager -->

  <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="06c77dde59dd05c5961a21f24a6cfd408f9e9e7e" content="06c77dde59dd05c5961a21f24a6cfd408f9e9e7e" />
      @include('gtm_tags.head')
      @if (Route::is('detailscreen', 'playerscreen', 'series'))
          @yield('meta-tags')
      @else
          <meta property="og:title" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_title ?? '' }}" />
          <meta property="og:image" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_image ?? '' }}" />
          <meta property="og:description" content="{!! strip_tags(\App\Services\AppConfig::get()->app->app_info->seo_description ?? '') !!}" />
      @endif
      <title>
          {{ $appInfo->app_name ?? '' }}@stack('title')
      </title>

      {{-- Old Css --}}
      <link rel="shortcut icon" href="{{ $appInfo->website_faviocn ?? '' }}">
      <link rel="stylesheet" href="{{ asset('assets/css/style-old.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/css/userprofile.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/css/tv-guide.css') }}">
      @stack('style')
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
      @if (isset($appInfo->faq_section) && $appInfo->faq_section == 1)
          <link rel="stylesheet" href="{{ asset('assets/css/faq_style.css') }}">
      @endif
      {{-- Adsencs link --}}
      <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5219646118453263"
          crossorigin="anonymous"></script>
      @yield('head')
      @include('layouts.one-signal.one-signal-scripts')

      <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- Matomo Tag Manager -->

      <script>
          var _mtm = window._mtm = window._mtm || [];

          _mtm.push({
              'mtm.startTime': (new Date().getTime()),
              'event': 'mtm.Start'
          });

          (function() {

              var d = document,
                  g = d.createElement('script'),
                  s = d.getElementsByTagName('script')[0];

              g.async = true;
              g.src = 'https://cdn.matomo.cloud/olivebranch.matomo.cloud/container_sZAj7sNy.js';
              s.parentNode.insertBefore(g, s);

          })();
      </script>

      <!-- End Matomo Tag Manager -->
  </head>
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=AW-16683333036"></script>
  <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
          dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'AW-16683333036');
  </script>

  <body>
      <!-- Google Tag Manager (noscript) -->
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-56JGF936" height="0" width="0"
              style="display:none;visibility:hidden"></iframe></noscript>
      <!-- End Google Tag Manager (noscript) -->
