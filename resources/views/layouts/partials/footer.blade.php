<footer>

    <div class="footer_section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <h5 class="footer_title">Get to Know Us</h5>
                    <ul class="footer_link px-0">
                        @foreach ($api_data->app->data->pages as $page)
                            @if ($page->displayOn == 'F')
                                <li>
                                    <a class="text-decoration-none"
                                        href="/page/{{ $page->page_slug }}">{{ $page->page_title }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h5 class="footer_title">Top Categories</h5>
                    <ul class="footer_link px-0">
                        @foreach ($api_data->app->footer_categories as $category)
                            <li>
                                <a class="text-decoration-none"
                                    href="/category/{{ $category->cat_guid }}">{{ $category->cat_title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h5 class="footer_title">Top TV Shows</h5>
                    <ul class="footer_link px-0">
                        @foreach ($api_data->app->top_show->streams as $stream)
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
                            <a class="text-decoration-none" href="/signin">Login</a>
                        </li>
                        <li>
                            <a class="text-decoration-none" href=" /signup">Register</a>
                        </li>

                        <li>
                            <a class="text-decoration-none" href="/download-apps">Download Apps</a>
                        </li>


                        <li>
                            <a class="text-decoration-none" href="/subscription">Subscription Plans</a>
                        </li>

                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-12 footer_rights" style="text-align: center;">
                    <ul class="footer_link px-0">
                        <li>
                            <span
                                class="copyright">{{ $api_data->app->colors_assets_for_branding->web_power_by_txt ?? '' }}</span>
                            <a class="text-decoration-none"
                                href="{{ $api_data->app->colors_assets_for_branding->web_power_by_web_url ?? '' }}">{{ $api_data->app->colors_assets_for_branding->web_power_by_web_name ?? '' }}</a>
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
                    <div class="footer_rights"><span class="copyright">© 24 Flix</span>
                        2022-2023 ALL RIGHTS RESERVED.</div>
                </div>
                <div class="col-md-6 foot2">
                    <ul class="social_link px-0">
                        @foreach ($api_data->app->social_media->links as $link)
                            <li class="hov1">
                                <a href="{{ $link->url }}" target="_blank">
                                    <img src="{{ asset('assets/images/' . $link->icon_cls_name ?? '') . '.png' }}">
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
