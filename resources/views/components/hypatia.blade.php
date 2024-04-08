<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data->app->app_info->app_name ?? '' }}</title>

    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/paramount/css/paramount.css') }}">
    <link rel="icon" href="{{ $data->app->app_info->website_faviocn ?? '' }}">
    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/paramount/css/bootstrap.min.css') }}">
</head>

<body class="intl property-in">
    <style>
        @if (isset($data->app->landingpages))
            @foreach ($data->app->landingpages as $page)
                @if ($page->page_type === 'HYP' && $page->section_type === 'banner' && $page->status === 1)
                    @if ($page->image)
                        body.intl {
                            background-image: url('{{ asset($page->image) }}');
                        }

                        @media (min-width: 768px) {
                            body.intl {
                                background-image: url('{{ asset($page->image) }}');
                            }
                        }

                        @media (min-width: 1440px) {
                            body.intl {
                                background-image: url('{{ asset($page->image) }}');
                            }
                        }
                    @endif
                @endif
            @endforeach
        @endif
    </style>

    <section class="padded-container">
        @if (isset($data->app->landingpages))
            @foreach ($data->app->landingpages as $page)
                @if ($page->page_type === 'HYP' && $page->section_type === 'section' && $page->status === 1 && $page->order === 1)
                    <div class="logo">
                        <img alt="{{ $data->app->app_info->app_name ?? '' }} logo" src="{{ $page->image ?? '' }}"
                            width="100%">
                    </div>
                    <div class="header">
                        @php
                            $words = explode(' ', $page->title ?? '');
                            $totalWords = count($words);
                        @endphp

                        @for ($i = 0; $i < $totalWords; $i += 3)
                            <p>
                                @for ($j = $i; $j < min($i + 3, $totalWords); $j++)
                                    {{ $words[$j] }}
                                @endfor
                            </p>
                        @endfor
                    </div>
                    <div class="info-text">
                        <p>{{ $page->description ?? '' }}
                        </p>
                    </div>
                @endif
            @endforeach
        @endif

        <div class="grid">

            <div class="grid2">

                <div class="rule-line"></div>

            </div>

            <form id="feedback-form">
                <div class="share-text">Share your email address to stay-up-to-date on
                    {{ $data->app->app_info->app_name ?? '' }} News.</div>

                <div class="grid-wrapper">
                    <div class="grid-item span-cols">
                        <div class="field-wrapper field-wrapper--floating-label field-wrapper--undefined"
                            value="">
                            <input maxlength="320" tabindex="2" type="text" name="email" id="email"
                                value="" placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="grid-item span-cols relativ">
                        <div class="g-recaptcha"></div>
                        <button tabindex="3" class="button submit" id="submit_btn">
                            <div class="button__text">Submit</div>
                        </button>
                    </div>

                    <div class="grid-item">
                        <div class="agreement-text">
                            By clicking the submit button, you agree to {{ $data->app->app_info->app_name ?? '' }}
                            using your email address to
                            send you marketing communications, updates, special offers and other information about Faith
                            Channel. You can unsubscribe at any time.
                            <a href="javascript:void(0);">Privacy Policy</a>.
                            <div class="grid3">
                                {{ $data->app->app_info->app_name ?? '' }} is available in select markets. Content
                                varies by region and
                                subject
                                to change.
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="email-success hide">
                Success! Stay tuned for updates.
            </div>

        </div>
    </section>
    <!-- Start of footer text-->
    <footer>
        <div class="footer-links">
            <a href="javascript:void(0);">Terms of Use</a>|
            <a href="javascript:void(0);">Privacy Policy</a>|
            <a href="javascript:void(0);">Cookies</a>|
            <a href="javascript:void(0)" class="ot-sdk-show-settings">Manage Cookies</a>
        </div>
        <div class="copyright">© <span id="copyright-year"></span> {{ $data->app->app_info->app_name ?? '' }}. All
            Rights Reserved.</div>
    </footer>
    <!-- End of footer text-->
</body>



</html>
