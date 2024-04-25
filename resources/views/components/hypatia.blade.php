<!DOCTYPE html>
<html lang="en">

<head>
    <meta property="og:title" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_title ?? '' }}" />
    <meta property="og:image" content="{{ \App\Services\AppConfig::get()->app->app_info->seo_image ?? '' }}" />
    <meta property="og:description" content="{!! strip_tags(\App\Services\AppConfig::get()->app->app_info->seo_description ?? '') !!}" />
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
    <div class="">
        
    </div>
    <div class="signup-login">
        <a href="/home?browse=true">Browse Content</a> | 
        <a href="/login">Login</a> | 
        @if (\App\Services\AppConfig::get()->app->app_info->is_signup_btn_show === 'Y')
        <a href="/signup">SignUp</a>
        @endif
    </div>
    <section class="padded-container padded-container d-flex flex-column justify-content-center">
       
                    <div class="logo">
                        <img alt="{{ $data->app->app_info->app_name ?? '' }} logo" src="{{ $data->app->app_info->website_logo ?? '' }}"
                            width="100%">
                    </div>
                    @if (isset($data->app->landingpages))
                    @foreach ($data->app->landingpages as $page)
                        @if ($page->page_type === 'HYP' && $page->section_type === 'section' && $page->status === 1 && $page->order === 1)
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
            @if (isset($data->app->landingpages))
                @foreach ($data->app->landingpages as $page)
                    @if ($page->page_type === 'HYP' && $page->section_type === 'section' && $page->status === 1 && $page->order === 2)
                        <form id="feedback-form">
                            <div class="share-text">{{ $page->title ?? '' }}</div>

                            <div class="grid-wrapper">
                                <form id="form">
                                <div class="grid-item span-cols">
                                    <div class="field-wrapper field-wrapper--floating-label field-wrapper--undefined"
                                        value="">
                                        <input maxlength="320" tabindex="2" type="email" name="email"
                                            id="email" value="" placeholder="Enter Email">
                                    </div>
                                </div>
                                <div class="grid-item span-cols relativ">
                                    <div class="g-recaptcha"></div>
                                    <button type="submit" tabindex="3" class="button submit" id="submit">
                                        <div class="button__text">Submit</div>
                                    </button>
                                </div>
                                <span class="text-danger email-error"></span> <!-- Error message span -->
                              </form>
                                <div class="grid-item">
                                    <div class="agreement-text">
                                        By clicking the submit button, you agree to
                                        {{ $page->description ?? '' }}
                                        {{--  <a href="javascript:void(0);">Privacy Policy</a>.  --}}
                                        {{--  <div class="grid3">
                                            {{ $data->app->app_info->app_name ?? '' }} is available in select markets.
                                            Content
                                            varies by region and
                                            subject
                                            to change.
                                        </div>  --}}
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                @endforeach
            @endif
            <div class="email-success hide">
                Success! Stay tuned for updates.
            </div>

        </div>
    </section>
    <!-- Start of footer text-->
    <footer>
        <div class="footer-links text-center">
            <a href="{{ route('login') }}">Login</a>|
            @if (\App\Services\AppConfig::get()->app->app_info->is_signup_btn_show === 'Y')
            <a href="{{ route('register') }}">Register</a>|
            @endif
            <a href="{{ route('downloadapps') }}">Download Apps</a>|
            <a href="{{ route('subscription') }}" class="ot-sdk-show-settings">Subscription Plans</a>
        </div>
        <div class="copyright text-center">© <span id="copyright-year"></span> {{ $data->app->app_info->app_name ?? '' }}
            {{ date('Y') }} - {{ date('Y', strtotime('+1 years')) }}. All
            Rights Reserved.</div>
    </footer>
    <!-- End of footer text-->
   
    @include('components.includes.script1')
    
</body>

</html>
