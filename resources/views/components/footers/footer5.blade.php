<link rel="stylesheet" href="{{ asset('assets/footers_assets/css/footer5.css') }}">
{{--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">  --}}
<footer class="footer">
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-3 bg-body-dark-costum py-4 py-md-5 py-xxl-8">
                    <div class="row h-100 align-items-end justify-content-center">
                        <div class="col-12 col-md-11 col-xl-10">
                            <div class="footer-logo-wrapper">
                                <a href="/home">
                                    <img src="{{ \App\Services\AppConfig::get()->app->app_info->website_logo ?? '' }}"
                                        alt="BootstrapBrain Logo">
                                </a>
                            </div>
                            <div class="social-media-wrapper mt-5">
                                <ul class="nav">

                                    @foreach (\App\Services\AppConfig::get()->app->social_media->links as $link)
                                        <li class="nav-item me-3">
                                            <a class="nav-link link-primary p-2 bg-light rounded"
                                                href="{{ $link->url }}">
                                                <img src="{{ $link->icon }}" alt="{{ $link->title }}"
                                                    style="max-width: 22px">
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-9 bg-dark-costum py-4 py-md-5 py-xxl-8">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-11 col-xxl-10">
                            <div class="row gy-4 gy-sm-0">
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <div class="widget">
                                        <h4 class="widget-title mb-4 text-white">Let Us Help You</h4>
                                        <ul class="list-unstyled">
                                            <li>
                                                <a class="text-white text-decoration-none"
                                                    href="{{ route('login') }}">Login</a>
                                            </li>
                                            <li>
                                                <a class="text-white text-decoration-none"
                                                    href="{{ route('register') }}">Register</a>
                                            </li>
                                            <li>
                                                <a class="text-white text-decoration-none"
                                                    href="{{ route('downloadapps') }}">Download Apps</a>
                                            </li>
                                            <li>
                                                <a class="text-white text-decoration-none"
                                                    href="{{ route('subscription') }}">Subscription
                                                    Plans</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <div class="widget">
                                        <h4 class="widget-title mb-4 text-white">Top Categories</h4>
                                        <ul class="list-unstyled">
                                            @foreach (\App\Services\AppConfig::get()->app->footer_categories as $category)
                                                <li>
                                                    <a class="text-white text-decoration-none"
                                                        href="{{ route('category', $category->cat_guid) }}">{{ $category->cat_title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12">
                                    <div class="widget">
                                        <h4 class="widget-title mb-4 text-white">Top TV Shows</h4>
                                        <ul class="list-unstyled">
                                            @foreach (\App\Services\AppConfig::get()->app->top_show->streams as $stream)
                                                <li>
                                                    <a
                                                        class="text-white text-decoration-none"href="/detailscreen/{{ $stream->stream_guid }}">{{ $stream->show_title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @if (isset(\App\Services\AppConfig::get()->app->app_info->newsletter) &&
                                \App\Services\AppConfig::get()->app->app_info->newsletter === 1)
                                <div class="col-lg-3 col-md-12 col-sm-12 mb-3" id="newsletter-section">
                                    <div class="widget">
                                        <h4 class="widget-title mb-4 text-white">Our Newsletter</h4>
                                        <p class="mb-4 text-white">
                                            Subscribe to our newsletter today and get the inside scoop delivered
                                            straight to your inbox.</p>
                                            <form id="subscribe-form-footer" method="POST"
                                            action="{{ route('newsletter') }}">
                                            @csrf
                                            <div class="row gy-2">
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="email-newsletter-addon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor"
                                                                class="bi bi-envelope" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                                            </svg>
                                                        </span>
                                                        <input type="email" id="email-input-footer" name="email" class="form-control text-black"
                                                            placeholder="Email Address" aria-label="email-newsletter"
                                                            aria-describedby="email-newsletter-addon" required>
                                                    </div>
                                                    <center>
                                                        @if (session()->has('data'))
                                                            @php
                                                                $data = session('data');
                                                            @endphp
                                                            @if (isset($data['app']['status']) && $data['app']['status'] == 3)
                                                                <p
                                                                    style="color: red;font-weight: 400;">
                                                                    @isset($data['app']['msg'])
                                                                        {{ $data['app']['msg'] }}
                                                                    @endisset
                                                                </p>
                                                            @endif
                                                            @if (isset($data['app']['status']) && $data['app']['status'] == 4)
                                                                <p
                                                                    style="color:rgb(0, 131, 0); font-weight: 400;">
                                                                    @isset($data['app']['msg'])
                                                                        {{ $data['app']['msg'] }}
                                                                    @endisset
                                                                </p>
                                                            @endif
                                                        @endif
                                                    </center>
                                                </div>
                                               
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button class="btn btn-primary"
                                                            type="submit">Subscribe</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif 
                            </div>
                            <div class="row mt-6 border-top border-light-subtle">
                                <div class="credits text-secondary mt-2 fs-7">
                                    <p>
                                        {{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_txt ?? '' }}:
                                        <a class="text-decoration-none"
                                            href="{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_web_url ?? '' }}">
                                            <span
                                                class="text-white text-bold">{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_power_by_web_name ?? '' }}</span>
                                        </a> 
                                    </p> 
                                </div>
                                <div class="text-white footer-copyright-wrapper mt-6">
                                    {{ \App\Services\AppConfig::get()->app->app_info->app_name }}
                                        {{ date('Y') }}-{{ date('Y', strtotime('+1 years')) }} All Right Reserved
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
