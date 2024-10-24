<link rel="stylesheet" href="{{ asset('assets/footers_assets/css/footer4.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                <div class="single_footer">
                    <h4>Get to Know Us</h4>
                    <ul>
                        @foreach (\App\Services\AppConfig::get()->app->data->pages as $page)
                            @if ($page->displayOn === 'F' || $page->displayOn === 'B')
                                <li>
                                    @if ($page->pageType === 'E')
                                        <a href="{!! $page->externalLink !!}" target="_blank">{{ $page->page_title }}</a>
                                    @else
                                        <a href="/page/{{ $page->page_slug }}">{{ $page->page_title }}</a>
                                    @endif
                            @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                <div class="single_footer single_footer_address">
                    <h4>Top Categories</h4>
                    <ul>
                        @foreach (\App\Services\AppConfig::get()->app->footer_categories as $category)
                            <li>
                                <a href="{{ route('category', $category->cat_guid) }}">{{ $category->cat_title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                <div class="single_footer single_footer_address">
                    <h4>Top TV Shows</h4>
                    <ul>
                        @foreach (\App\Services\AppConfig::get()->app->top_show->streams as $stream)
                            <li>
                                <a href="/detailscreen/{{ $stream->stream_guid }}">{{ $stream->show_title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                <div class="single_footer single_footer_address">
                    <h4>Let Us Help You</h4>
                    <ul>
                        <li>
                            <a href="{{ route('login') }}">Login</a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}">Register</a>
                        </li>
                        <li>
                            <a href="{{ route('downloadapps') }}">Download Apps</a>
                        </li>
                        <li>
                            <a href="{{ route('subscription') }}">Subscription
                                Plans</a>
                        </li>
                    </ul>
                </div>
            </div>
            @if (isset(\App\Services\AppConfig::get()->app->app_info->newsletter) &&
                    \App\Services\AppConfig::get()->app->app_info->newsletter === 1)
                <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12" id="newsletter-section">
                    <div class="single_footer single_footer_address">
                        <h4>NEWSLETTER</h4>
                        <div class="signup_form">
                            <form class="subscribe" id="subscribe-form-footer" method="POST"
                                action="{{ route('newsletter') }}">
                                @csrf
                                <input  type="email" id="email-input-footer" name="email" class="subscribe__input" placeholder="Enter Email Address">
                                <button type="submit" class="subscribe__btn"><i
                                        class="fab fa-telegram-plane"></i></button>
                            </form>
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
                        </div>
                    </div>
                    <div class="social_profile">
                        <ul>
                            @foreach (\App\Services\AppConfig::get()->app->social_media->links as $link)
                                <li><a href="{{ $link->url }}"
                                     class="social-share" data-platform="{{ $link->title }}" data-content="Shared content: {{ $link->title }}"> <i><img
                                                src="{{ $link->icon }}"
                                                alt="{{ $link->title }}" style="max-width: 100%"></i></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <p class="copyright">
                    {{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_txt ?? '' }} : <a
                        href="{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_web_url ?? '' }}">{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_web_name ?? '' }}</a> |
                    {{ \App\Services\AppConfig::get()->app->app_info->app_name }}</span>
                    {{ date('Y') }}-{{ date('Y', strtotime('+1 years')) }} All Right Reserved</p>
            </div>
        </div>
    </div>
</div>

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
