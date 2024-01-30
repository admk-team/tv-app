<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>24 Flix</title>

    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/paramount/css/paramount.css') }}">
    <link rel="icon" href="{{ $data->app->app_info->website_faviocn ?? '' }}">
    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/paramount/css/bootstrap.min.css') }}">
</head>

<body class="intl property-in">
    <style>
        body.intl {
            background-image: url("{{ asset('assets/landing_theme_assets/paramount/images/image.jpg') }}");
        }

        @media (min-width: 768px) {
            body.intl {
                background-image: url("{{ asset('assets/landing_theme_assets/paramount/images/image.jpg') }}");
            }
        }

        @media (min-width: 1440px) {
            body.intl {
                background-image: url("{{ asset('assets/landing_theme_assets/paramount/images/image.jpg') }}");
            }
        }
    </style>

    <section class="padded-container">

        <div class="logo">
            <img alt="
            {{ $appName }} logo" src="{{ $data->app->app_info->website_faviocn ?? '' }}"
                width="100%">
        </div>
        <div class="header">

            <p>ALL FAITH</p>
            <p>MOVIES & SHOWS</p>
            <p>WATCH ANYWHERE</p>

        </div>

        <div class="info-text">
            <p>{{ $appName }} is the place place to watch all of your favorite Faith and Family Movies and TV
                Series. Watch exclusive premieres and originals. Create an account and Start Watching today.</p>
        </div>

        <div class="grid">

            <div class="grid2">

                <div class="rule-line"></div>

            </div>

            <form id="feedback-form">
                <div class="share-text">Share your email address to stay-up-to-date on {{ $appName }} News.</div>

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
                            By clicking the submit button, you agree to {{ $appName }} using your email address to
                            send you marketing communications, updates, special offers and other information about Faith
                            Channel. You can unsubscribe at any time.
                            <a href="javascript:void(0);">Privacy Policy</a>.
                            <div class="grid3">
                                {{ $appName }} is available in select markets. Content varies by region and
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
        <div class="copyright">© <span id="copyright-year"></span> {{ $appName }}. All Rights Reserved.</div>
    </footer>
    <!-- End of footer text-->
</body>



</html>
