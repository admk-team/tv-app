<footer>

    <div class="footer_section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <h5 class="footer_title">Get to Know Us</h5>
                    <ul class="footer_link px-0">
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
                <div class="col-sm-6 col-md-3">
                    <h5 class="footer_title">Top Categories</h5>
                    <ul class="footer_link px-0">
                        @foreach (\App\Services\AppConfig::get()->app->footer_categories as $category)
                            <li>
                                <a class="text-decoration-none"
                                    href="{{ route('category', $category->cat_guid) }}">{{ $category->cat_title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h5 class="footer_title">Top TV Shows</h5>
                    <ul class="footer_link px-0">
                        @foreach (\App\Services\AppConfig::get()->app->top_show->streams as $stream)
                            <li>
                                <a class="text-decoration-none"
                                    href="/detailscreen/{{ $stream->stream_guid }}">{{ $stream->show_title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h5 class="footer_title">Let Us Help You</h5>
                    <ul class="footer_link px-0">
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
                            <a class="text-decoration-none" href="{{ route('subscription') }}">Subscription Plans</a>
                        </li>

                    </ul>
                </div>
            </div>
            @if (isset(\App\Services\AppConfig::get()->app->app_info->newsletter) &&
                    \App\Services\AppConfig::get()->app->app_info->newsletter === 1)
                    <div id="newsletter-section" class="row">
                        <h5 class="text-center text-white">Subscribe to our Newsletter</h5>
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
                                @if (isset($data['app']['status']) && $data['app']['status'] == 0)
                                    <p style="color:red; font-weight: 400;">
                                        @isset($data['app']['msg'])
                                            {{ $data['app']['msg'] }}
                                        @endisset
                                    </p>
                                @endif
                                @if (isset($data['app']['status']) && $data['app']['status'] == 1)
                                    <p style="color:rgb(0, 131, 0); font-weight: 400;">
                                        @isset($data['app']['msg'])
                                            {{ $data['app']['msg'] }}
                                        @endisset
                                    </p>
                                @endif
                            @endif
                        </center>
                        <form id="subscribe-form" method="POST" action="{{ route('newsletter') }}">
                            @csrf
                            <input type="email" id="email-input" name="email" placeholder="Enter your email" required>
                            <button class="app-primary-btn rounded" type="submit">Subscribe</button>
                        </form>
                    </div>
                    
                    
            @endif
            <div class="row">
                <div class="col-sm-6 col-md-12 footer_rights" style="text-align: center;">
                    <ul class="footer_link px-0">
                        <li>
                            <span
                                class="copyright">{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_txt ?? '' }}</span>
                            <a class="text-decoration-none"
                                href="{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_web_url ?? '' }}">{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_web_name ?? '' }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer_bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 foot1">
                    <div class="footer_rights">
                        <span class="copyright">© {{ \App\Services\AppConfig::get()->app->app_info->app_name }}</span>
                        {{ date('Y') }}-{{ date('Y', strtotime('+1 years')) }} ALL RIGHTS RESERVED.
                    </div>
                </div>

                <div class="col-md-6 foot2">
                    <ul class="social_link px-0">
                        @foreach (\App\Services\AppConfig::get()->app->social_media->links as $link)
                            <li class="hov1">
                                <a href="{{ $link->url }}" target="_blank">
                                    <img src="{{ $link->icon }}">
                                </a>
                                <div class="tooltip fade top in" role="tooltip">
                                    <div class="tooltip-arrow" style="left: 50%;">
                                    </div>
                                    <div class="tooltip-inner">{{ $link->title }}</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('subscribe-form');
        form.addEventListener('submit', function(event) {
            // Get the current URL
            const currentUrl = window.location.href;
    
            // Check if the URL already contains a fragment
            const hasFragment = currentUrl.includes('#');
    
            // Form action URL
            const formAction = form.action;
    
            // Append the fragment identifier if not already present
            if (!hasFragment) {
                form.action = formAction + '#newsletter-section';
            }
        });
    });
    </script>
    