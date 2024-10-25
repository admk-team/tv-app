@section('head')
    <link rel="stylesheet" href="{{ asset('assets/footers_assets/css/default_footer.css') }}">
@endsection
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
                    <h5 class="text-center copyright">Subscribe to our Newsletter</h5>
                    <center>
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
                        <form id="subscribe-form" method="POST" action="{{ route('newsletter') }}">
                            @csrf
                            <input type="email" id="email-input" name="email" placeholder="Enter your email"
                                required>
                            <button class="app-primary-btn rounded" type="submit">Subscribe</button>
                        </form>
                    </center>
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
            {{--  <link rel="stylesheet"
                href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

            <form id="subscribe-form-toggle" method="POST" action="{{ route('toggle.subscribe') }}">
                @csrf
                <button id="subscribe-button-toggle" class="sub-btn-icon rounded" type="submit">
                    <i id="subscribe-icon" class="fas fa-bell"></i> <!-- Default icon -->
                    <span id="subscribe-text"></span>
                </button>
                <div id="response-message">{{ session('status') }}</div>
            </form>  --}}


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
                                <a href="{{ $link->url }}" target="_blank"
                                    class="social-share" data-platform="{{ $link->title }}" data-content="Shared content: {{ $link->title }}">
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

@push('scripts')
    <!-- Form Action Fragment Identifier Handling -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('subscribe-form');
            if (form) {
                form.addEventListener('submit', function(event) {
                    const currentUrl = window.location.href;
                    const hasFragment = currentUrl.includes('#');
                    const formAction = form.action;
                    if (!hasFragment) {
                        form.action = formAction + '#newsletter-section';
                    }
                });
            }
        });
    </script>

    {{--  <!-- AJAX Request to Check Subscription Status -->
    <script>
        $(document).ready(function() {
            // Set up AJAX to include CSRF token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('check.subscription.status') }}",
                method: "GET",
                success: function(response) {
                    console.log('Response:', response);
                    if (response.success) {
                        if (response.subscribed) {
                            $('#subscribe-icon').removeClass('fa-bell').addClass('fa-bell-slash');
                            $('#subscribe-text').text('');
                        } else {
                            $('#subscribe-icon').removeClass('fa-bell-slash').addClass('fa-bell');
                            $('#subscribe-text').text('');
                        }
                    } else {
                        $('#subscribe-icon').removeClass('fa-bell-slash').addClass('fa-bell');
                        $('#subscribe-text').text('');
                        console.error('Subscription check failed:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    $('#subscribe-icon').removeClass('fa-bell-slash').addClass('fa-bell');
                    $('#subscribe-text').text('Subscribe'); // Default to Subscribe on error
                    console.error('AJAX error:', error); // Debugging AJAX error
                    console.error('Response text:', xhr.responseText); // Log the response text for debugging
                }
            });
        });

    </script>  --}}
@endpush
