<link rel="stylesheet" href="{{ asset('assets/footers_assets/css/footer3.css') }}">
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
<footer class="footer-sec footer">
    <div class="main">
        <div class="logo row">
            <div class="footer-header">
                <a href="/home"><img src="{{ \App\Services\AppConfig::get()->app->app_info->website_logo ?? '' }}"
                        class="manik" alt=""></a>
            </div>
            <div class="logo-des">
                <p>
                    {{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_txt ?? '' }}:
                    <a class="text-decoration-none"
                        href="{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_web_url ?? '' }}">
                        <span
                            class="text-white text-bold">{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_web_name ?? '' }}</span>
                    </a>
                </p>
            </div>
        </div>
        <div class="link row">
            <div class="footer-header">
                <h3>Get to Know Us</h3>
            </div>

            <div class="link-des">
                @foreach (\App\Services\AppConfig::get()->app->data->pages as $page)
                    @if ($page->displayOn === 'F' || $page->displayOn === 'B')
                        @if ($page->pageType === 'E')
                            <a class="footer-links" href="{!! $page->externalLink !!}"
                                target="_blank">{{ $page->page_title }}</a>
                        @else
                            <a class="footer-links" href="/page/{{ $page->page_slug }}">{{ $page->page_title }}</a>
                        @endif
                    @endif
                @endforeach
            </div>

        </div>
        <div class="link row">
            <div class="footer-header">
                <h3>Top Categories</h3>
            </div>
            <div class="link-des">
                @foreach (\App\Services\AppConfig::get()->app->footer_categories as $category)
                    <a class="footer-links"
                        href="{{ route('category', $category->cat_guid) }}">{{ $category->cat_title }}</a>
                @endforeach
            </div>
        </div>
        <div class="link row">
            <div class="footer-header">
                <h3>Top TV Shows</h3>
            </div>
            <div class="link-des">
                @foreach (\App\Services\AppConfig::get()->app->top_show->streams as $stream)
                    <a class="footer-links"
                        href="/detailscreen/{{ $stream->stream_guid }}">{{ $stream->show_title }}</a>
                @endforeach
            </div>
        </div>


        <div class="link row">
            <div class="footer-header">
                <h3>Let Us Help You</h3>
            </div>
            <div class="link-des">
                <a class="footer-links" href="{{ route('login') }}">Login</a>
                <a class="footer-links" href="{{ route('register') }}">Register</a>
                <a class="footer-links" href="{{ route('downloadapps') }}">Download Apps</a>
                <a class="footer-links" href="{{ route('subscription') }}">Subscription Plans</a>
            </div>
        </div>

        @if (isset(\App\Services\AppConfig::get()->app->app_info->newsletter) &&
                \App\Services\AppConfig::get()->app->app_info->newsletter === 1)
            <div class="newsletter row" id="newsletter-section">
                <div class="footer-header">
                    <h3>NEWSLETTER</h3>
                </div>
                <div class="newsletter-des">
                    <form id="subscribe-form-footer" method="POST" action="{{ route('newsletter') }}">
                        @csrf
                        <div class="subcribe"><i class="sub-icon ri-mail-check-fill"></i>
                            <input type="email" id="email-input-footer" name="email" placeholder="Enter Email ID"
                                required>
                            <button type="submit" class="submit-button"><i
                                    class="sub-icon ri-arrow-right-line"></i></button>
                        </div>
                        <center>
                            @if (session()->has('data'))
                                @php
                                    $data = session('data');
                                @endphp
                                @if (isset($data['app']['status']) && $data['app']['status'] == 3)
                                    <p
                                        style="color: red;font-weight: 400; margin: 3%; margin-left: 0%; margin-right: 10%;">
                                        @isset($data['app']['msg'])
                                            {{ $data['app']['msg'] }}
                                        @endisset
                                    </p>
                                @endif
                                @if (isset($data['app']['status']) && $data['app']['status'] == 4)
                                    <p
                                        style="color:rgb(0, 131, 0); font-weight: 400;  margin: 3%; margin-left: 0%;margin-right: 10%;">
                                        @isset($data['app']['msg'])
                                            {{ $data['app']['msg'] }}
                                        @endisset
                                    </p>
                                @endif
                            @endif
                        </center>
                    </form>

                    <div class="icons">
                        @foreach (\App\Services\AppConfig::get()->app->social_media->links as $link)
                            <a href="{{ $link->url }}" target="_blank">
                                <i class="social-icon">
                                    <img src="{{ $link->icon }}" alt="{{ $link->title }}"></i></a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

    </div>
    <div class="copyright">
        <hr>
        <p>{{ \App\Services\AppConfig::get()->app->app_info->app_name }}</span>
            {{ date('Y') }}-{{ date('Y', strtotime('+1 years')) }} All Right Reserved
        </p>
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
