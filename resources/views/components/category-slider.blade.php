<section class="sliders">
    <div class="slider-container">
        @foreach ($data->app->categories ?? [] as $category)
            @if (!empty($category->streams))
                @php
                    $cartMainCls = 'landscape_slider';
                    $cartMainSubCls = 'ripple';
                    $cardThumbCls = 'card card-img-container';
                    $cardThumbCls2 = 'thumbnail-container';
                    $streamPosterKey = 'stream_poster';

                    switch ($category->card_type) {
                        case 'LA':
                            $cartMainCls = 'landscape_slider';
                            $cartMainSubCls = 'ripple';
                            $cardThumbCls = '';
                            $cardThumbCls2 = 'thumbnail_img';
                            $streamPosterKey = 'stream_poster';
                            break;
                        case 'PO':
                            $cartMainCls = 'potrait_slider';
                            $cartMainSubCls = 'ripple vertical';
                            $streamPosterKey = 'stream_portrait';
                            break;
                        case 'ST': // ST: Standard (4x3),
                            $cartMainCls = 'landscape_slider';
                            $cartMainSubCls = 'ripple';
                            $cardThumbCls = '';
                            $cardThumbCls2 = 'thumbnail_img thumbnailfourbyfour';
                            $streamPosterKey = 'stream_sdm';
                            break;
                        case 'QU': //QU: Square (1x1)
                            $cartMainCls = 'potrait_slider';
                            $cartMainSubCls = 'vertical onebyone';
                            $streamPosterKey = 'stream_square';
                            break;
                        case 'BA': //Billboard Ads (1606x470)  803 : 235,
                            $cartMainCls = 'billboard_ads';
                            $cartMainSubCls = 'ripple';
                            $cardThumbCls = '';
                            $cardThumbCls2 = 'thumbnail_img billboard_img';
                            $streamPosterKey = 'stream_poster';
                            break;
                        case 'LB': // Leaderboard Ads (1350x50) 27:1,
                            $cartMainCls = 'leaderboard_ads';
                            $cartMainSubCls = 'ripple';
                            $cardThumbCls = '';
                            $cardThumbCls2 = 'thumbnail_img leaderboard_img m-auto';
                            $streamPosterKey = 'stream_poster';
                            break;
                    }
                @endphp
                <div class="listing_box">
                    <div class="slider_title_box">
                        <div class="list_heading">
                            <h1>{{ $category->cat_title ?? '' }}</h1>
                        </div>
                        @if (($category->is_show_view_more ?? 'N') === 'Y')
                            <div class="list_change_btn"><a href="{{ route('category', $category->cat_guid) }}">View
                                    All</a></div>
                        @endif
                    </div>
                    <div class="{{ $cartMainCls }} slider slick-slider">
                        @foreach ($category->streams as $stream)
                            @php
                                $url = route('detailscreen', $stream->stream_guid);
                                if ($stream->stream_type === 'A') {
                                    $url = $stream->stream_promo_url;
                                    if ($stream->is_external_ad === 'N') {
                                        $url = route('detailscreen', $stream->stream_promo_url);
                                    }
                                }
                            @endphp
                            <div class="item">
                                <div class="{{ $cartMainSubCls }}">
                                    @if ($category->cat_title == 'Top 10')
                                        <a href="{{ $url }}">
                                            <div class="d-flex cursor-pointer position-relative">
                                                <a class="top-10-slider-wrapper" href="{{ $url }}"></a>
                                                <a class="top-10-slider-number">{{ $loop->iteration }}</a>
                                                <div class="{{ $cardThumbCls2 }}">
                                                    <div class="trending_icon_box" {!! $stream->monetization_type == 'F' ? 'style="display: none;"' : '' !!}><img
                                                            src="{{ url('/') }}/assets/images/trending_icon.png"
                                                            alt="Trending">
                                                    </div>
                                                    <div class="{{ $cardThumbCls }}">
                                                        <img src="{{ $stream->{$streamPosterKey} }}"
                                                            alt="{{ $stream->stream_title }}">
                                                    </div>
                                                    <div class="detail_box_hide">
                                                        <div class="detailbox_time">
                                                            {{ $stream->stream_duration_timeformat ?? '' }}
                                                        </div>
                                                        <div class="deta_box">
                                                            <div class="season_title"></div>
                                                            <div class="content_title">{{ $stream->stream_title }}
                                                            </div>
                                                            <div class="content_description">
                                                                {{ $stream->stream_description }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ $url }}">
                                            <div class="{{ $cardThumbCls2 }}">
                                                <div class="trending_icon_box" {!! (!$stream->monetization_type || $stream->monetization_type == 'F') ? 'style="display: none;"' : '' !!}><img
                                                        src="{{ url('/') }}/assets/images/trending_icon.png"
                                                        alt="Trending">
                                                </div>
                                                @if (($stream->is_newly_added ?? 'N') === 'Y')
                                                    <div class="newly-added-label">
                                                        <span>New Episode</span>
                                                    </div>
                                                @endif
                                                <div class="{{ $cardThumbCls }}">
                                                    <img src="{{ $stream->{$streamPosterKey} }}"
                                                        alt="{{ $stream->stream_title }}">
                                                </div>
                                                <div class="detail_box_hide">
                                                    <div class="detailbox_time">
                                                        {{ $stream->stream_duration_timeformat ?? '' }}
                                                    </div>
                                                    <div class="deta_box">
                                                        <div class="season_title">
                                                            {{ $stream?->stream_episode_title && $stream?->stream_episode_title !== 'NULL' ? $stream?->stream_episode_title : '' }}
                                                        </div>
                                                        <div class="content_title">{{ $stream->stream_title }}</div>
                                                        <div class="content_description">
                                                            {{ $stream->stream_description }}
                                                        </div>

                                                        @if ($stream->stream_watched_dur_in_pct > 1)
                                                            {{-- <div style="background-color:{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->tv_cw_unflled_color }};height:5px; border-radius:2px;margin-top:10px;">
                                                                    <div style="background-color:{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->tv_cw_flled_color }};height:5px;border-radius:2px;width:{{ $arrStreamsData['stream_watched_dur_in_pct']}}%"></div>
                                                                </div> --}}
                                                            <div
                                                                style="background-color:#555455;height:5px; border-radius:2px;margin-top:10px;">
                                                                <div
                                                                    style="background-color:#07659E;height:5px;border-radius:2px;width:{{ $stream->stream_watched_dur_in_pct }}%">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>
