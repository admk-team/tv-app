<link rel="stylesheet" href="{{ asset('assets/footers_assets/css/footer2.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<footer class="footer-section">
    <div class="container" style="max-width: 90%;">
        <div class="footer-subscribe pt-4 ">
            <div class="row justify-content-center">
                @if (isset(\App\Services\AppConfig::get()->app->app_info->newsletter) &&
                        \App\Services\AppConfig::get()->app->app_info->newsletter === 1)
                    <div class="col-xl-12 col-lg-12 col-md-12" id="newsletter-section">
                        <div class="footer-widget">
                            <div class="row justify-content-center">
                                <div class="col-xl-4 col-lg-4 col-md-6">
                                    <div class="footer-widget-heading">
                                        <h1>Subscribe</h1>
                                    </div>
                                    <div class="footer-text">
                                        <p>Don’t miss to subscribe to our Newsletter, kindly fill the form below.</p>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 mt-4">
                                    <div class="subscribe-form">
                                        <form id="subscribe-form-footer" method="POST" action="{{ route('newsletter') }}">
                                            @csrf
                                            <input type="email" id="email-input-footer" name="email"
                                                placeholder="Email Address" required>
                                            <button type="submit"><i class="fab fa-telegram-plane"></i></button>
                                        </form>
                                        <center>
                                            <p style="color:red">
                                                @if (session()->has('error'))
                                                    {{ session('error') }}
                                                @endif
                                            </p>
                                            @if (session()->has('data'))
                                                @php
                                                    $data = session('data');
                                                @endphp
                                                @if (isset($data['app']['status']) && $data['app']['status'] == 3)
                                                    <p style="color:red; font-weight: 400;">
                                                        @isset($data['app']['msg'])
                                                            {{ $data['app']['msg'] }}
                                                        @endisset
                                                    </p>
                                                @endif
                                                @if (isset($data['app']['status']) && $data['app']['status'] == 4)
                                                    <p style="color:rgb(0, 131, 0); font-weight: 400;">
                                                        @isset($data['app']['msg'])
                                                            {{ $data['app']['msg'] }}
                                                        @endisset
                                                    </p>
                                                @endif
                                            @endif
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    
    <div class="container" style="max-width: 90%;">
        <div class="footer-content  gradient-bg pt-5 pb-5">
            <div class="row">
               
                <div class="col-xl-2 col-lg-3 col-md-6 mt-5">
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <a href="/home"><img
                                    src="{{ \App\Services\AppConfig::get()->app->app_info->website_logo ?? '' }}"
                                    class="img-fluid" alt="logo"></a>
                        </div>
                        <div class="footer-text">
                            <p>
                                {{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_txt ?? '' }}:
                                <a class="text-decoration-none"
                                    href="{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_web_url ?? '' }}">
                                    <span>{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_web_name ?? '' }}</span>
                                </a>
                            </p>

                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6   mb-3">
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Top Categories</h3>
                        </div>
                        <ul class="list">
                            @foreach (\App\Services\AppConfig::get()->app->footer_categories as $category)
                                <li>
                                    <a class="text-decoration-none"
                                        href="{{ route('category', $category->cat_guid) }}">{{ $category->cat_title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6   mb-3">
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Top TV Shows</h3>
                        </div>
                        <ul class="list">
                            @foreach (\App\Services\AppConfig::get()->app->top_show->streams as $stream)
                                <li>
                                    <a class="text-decoration-none"
                                        href="/detailscreen/{{ $stream->stream_guid }}">{{ $stream->show_title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6   mb-3">
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Let Us Help You</h3>
                        </div>
                        <ul class="list">
                            <li>
                                <a class="text-decoration-none" href="{{ route('login') }}">Login</a>
                            </li>
                            <li>
                                <a class="text-decoration-none" href="{{ route('register') }}">Register</a>
                            </li>
                            <li>
                                <a class="text-decoration-none" href="{{ route('downloadapps') }}">Download Apps</a>
                            </li>
                            <li>
                                <a class="text-decoration-none" href="{{ route('subscription') }}">Subscription
                                    Plans</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-6 col-md-12  mb-3">
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Get to Know Us</h3>
                        </div>
                        <ul class="list">
                            @foreach (\App\Services\AppConfig::get()->app->data->pages as $page)
                            @if ($page->displayOn === 'F' || $page->displayOn === 'B')
                                <li>
                                    @if ($page->pageType === 'E')
                                        <a class="text-decoration-none" href="{!! $page->externalLink !!}"
                                            target="_blank">{{ $page->page_title }}</a>
                                    @else
                                        <a class="text-decoration-none"
                                            href="/page/{{ $page->page_slug }}">{{ $page->page_title }}</a>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 mb-3">
                    <div class="footer-social-icon">
                        <div class="footer-widget-heading">
                            <h3>Follow Us</h3>
                        </div>
                        @foreach (\App\Services\AppConfig::get()->app->social_media->links as $link)
                            <a href="{{ $link->url }}" target="_blank" class="social-icon">
                                <img src="{{ $link->icon }}"
                                    alt="{{ $link->title }}">
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 text-center text-lg-left">
                    <div class="copyright-text">
                        <p>{{ \App\Services\AppConfig::get()->app->app_info->app_name }}</span>
                            {{ date('Y') }}-{{ date('Y', strtotime('+1 years')) }} All Right Reserved
                        </p>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 d-none d-lg-block text-right">
                    <div class="footer-menu">
                        <ul class="list">
                            @foreach (\App\Services\AppConfig::get()->app->data->pages as $page)
                                @if ($page->displayOn === 'F' || $page->displayOn === 'B')
                                    <li>
                                        @if ($page->pageType === 'E')
                                            <a href="{!! $page->externalLink !!}"
                                                target="_blank">{{ $page->page_title }}</a>
                                        @else
                                            <a href="/page/{{ $page->page_slug }}">{{ $page->page_title }}</a>
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formFooter = document.getElementById('subscribe-form-footer');
            formFooter.addEventListener('submit', function(event) {
                // Get the current URL
                const currentUrl = window.location.href;

                // Check if the URL already contains a fragment
                const hasFragment = currentUrl.includes('#');

                // Form action URL
                const formAction = formFooter.action;

                // Append the fragment identifier if not already present
                if (!hasFragment) {
                    formFooter.action = formAction + '#newsletter-section';
                }
            });
        });
    </script>
@endpush
