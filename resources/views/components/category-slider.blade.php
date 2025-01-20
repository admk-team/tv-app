@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/cards-item.css') }}" />
    {{-- <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" /> --}}
    <link href="https://vjs.zencdn.net/7.15.4/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-youtube@2.6.1/dist/Youtube.min.js"></script>
@endpush
<section class="sliders">
    <div class="slider-container">
        @foreach ($data->app->categories ?? [] as $category)
            {{-- @dd(\App\Services\AppConfig::get()->app->colors_assets_for_branding->is_potrait_slider_autoplay, \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_landscape_slider_autoplay) --}}
            @if (!empty($category->streams))
                @php
                    $cartMainCls = 'landscape_slider';
                    $cartMainSubCls = 'ripple';
                    $cardThumbCls = 'card card-img-container';
                    $cardThumbCls2 = 'thumbnail-container';
                    $streamPosterKey = 'stream_poster';
                    $items = $category?->items_per_row ? $category->items_per_row : '5';
                    $autoplay = true;

                    switch ($category->card_type) {
                        case 'LA':
                            $cartMainCls = 'landscape_slider';
                            $cartMainSubCls = 'ripple';
                            $cardThumbCls = '';
                            $cardThumbCls2 = "thumbnail_img LA_{$items}";
                            $streamPosterKey = 'stream_poster';
                            $autoplay = \App\Services\AppConfig::get()->app->colors_assets_for_branding
                                ->is_landscape_slider_autoplay;
                            break;

                        case 'PO':
                            $cartMainCls = 'potrait_slider';
                            $cartMainSubCls = "ripple vertical PO_{$items}";
                            $streamPosterKey = 'stream_portrait';
                            $autoplay = \App\Services\AppConfig::get()->app->colors_assets_for_branding
                                ->is_potrait_slider_autoplay;
                            break;

                        case 'ST': // ST: Standard (4x3),
                            $cartMainCls = 'landscape_slider';
                            $cartMainSubCls = 'ripple';
                            $cardThumbCls = '';
                            $cardThumbCls2 = "thumbnail_img thumbnailfourbyfour ST_{$items}";
                            $cardThumbCls2 = "thumbnail_img ST_{$items}";
                            $streamPosterKey = 'stream_sdm';
                            $autoplay = \App\Services\AppConfig::get()->app->colors_assets_for_branding
                                ->is_landscape_slider_autoplay;
                            break;

                        case 'QU': //QU: Square (1x1)
                            $cartMainCls = 'potrait_slider';
                            $cartMainSubCls = "vertical onebyone QU_{$items}";
                            $streamPosterKey = 'stream_square';
                            $autoplay = \App\Services\AppConfig::get()->app->colors_assets_for_branding
                                ->is_potrait_slider_autoplay;
                            break;
                        case 'BA': //Billboard Ads (1606x470)  803 : 235,
                            $cartMainCls = 'billboard_ads';
                            $cartMainSubCls = "ripple BA_{$items}";
                            // $cartMainSubCls = "ripple";
                            $cardThumbCls = '';
                            $cardThumbCls2 = 'thumbnail_img billboard_img';
                            $streamPosterKey = 'stream_poster';
                            break;
                        case 'LB': // Leaderboard Ads (1350x50) 27:1,
                            $cartMainCls = 'leaderboard_ads';
                            $cartMainSubCls = "ripple LB_{$items}";
                            $cardThumbCls = '';
                            $cardThumbCls2 = 'thumbnail_img leaderboard_img m-auto ';
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
                    <div class="{{ $cartMainCls }} slider slick-slider" data-items-per-row="{{ $items }}"
                        data-autoplay="{{ $autoplay }}">
                        @foreach ($category->streams as $stream)
                            @php
                                if (
                                    (isset(\App\Services\AppConfig::get()->app->app_info->bypass_detailscreen) &&
                                        \App\Services\AppConfig::get()->app->app_info->bypass_detailscreen == 1) ||
                                    $stream->bypass_detailscreen == 1 && $stream?->contentType != 'series') {
                                    $screen = 'playerscreen';
                                } elseif($stream?->contentType != 'series'){
                                    $screen = 'detailscreen';
                                }else{
                                    $screen = 'series'; 
                                }
                                if ($stream->stream_type === 'A') {
                                    $url = $stream->stream_promo_url;
                                    if ($stream->is_external_ad === 'N') {
                                        $url = route($screen, $stream->stream_promo_url);
                                    }
                                    if ($stream->banner_ad_click_tracking_url ?? false) {
                                        // wrap url in click tracking url
                                        if (strpos($stream->banner_ad_click_tracking_url, '?') !== false) {
                                            $url = $stream->banner_ad_click_tracking_url . '&url=' . urlencode($url);
                                        } else {
                                            $url = $stream->banner_ad_click_tracking_url . '?url=' . urlencode($url);
                                        }
                                    }
                                } elseif ($stream->stream_type === 'BC') {
                                    $url = route('content-bundle', $stream->stream_guid);
                                } else {
                                    $url = route($screen, $stream->stream_guid);
                                }
                                $streamUrl = $stream->stream_promo_url;
                                $mType = '';
                                if ($streamUrl) {
                                    if (strpos($streamUrl, '.m3u8') !== false) {
                                        $mType = "type='application/x-mpegURL'";
                                    } elseif (strpos($streamUrl, 'youtube.com') !== false) {
                                        $mType = "type='video/youtube'";
                                    } elseif (strpos($streamUrl, 'youtu.be') !== false) {
                                        $isShortYouTube = preg_match(
                                            '/youtu\.be\/([^?&]+)/',
                                            $streamUrl,
                                            $shortYouTubeMatches,
                                        );
                                        if ($isShortYouTube) {
                                            $urlId = $shortYouTubeMatches[1];
                                            $streamUrl = 'https://www.youtube.com/watch?v=' . $urlId;
                                            $mType = "type='video/youtube'";
                                        }
                                    } elseif (strpos($streamUrl, 'vimeo.com') !== false) {
                                        $mType = "type='video/vimeo'";
                                    }
                                }
                            @endphp
                            <div class="item video-link">
                                <div class="{{ $cartMainSubCls }}">
                                    @if (($category->is_top10 ?? null) === 'Y')
                                        <a href="{{ $url }}">
                                            <div class="d-flex cursor-pointer position-relative">
                                                <a class="top-10-slider-wrapper" href="{{ $url }}"></a>
                                                <a class="top-10-slider-number">{{ $loop->iteration }}</a>
                                                <div class="{{ $cardThumbCls2 }}">
                                                    @if (!in_array($category->card_type, ['BA', 'LB']))
                                                        @if (isset($stream->notify_label) &&
                                                                ($stream->notify_label == 'available now' || $stream->notify_label == 'coming soon'))
                                                            <div class="content-label"
                                                                style="color: {{ \App\Services\AppConfig::get()->app->website_colors->themePrimaryTxtColor }}; {{ \App\Helpers\GeneralHelper::generateGradient(\App\Services\AppConfig::get()->app->website_colors->themeActiveColor) }}">
                                                                {{ strtoupper($stream->notify_label) }}
                                                            </div>
                                                        @else
                                                            <div class="trending_icon_box">
                                                                @if ($stream->premium_icon ?? null)
                                                                    @php
                                                                        $premium_icon = json_decode(
                                                                            $stream->premium_icon,
                                                                            true,
                                                                        );
                                                                    @endphp
                                                                    @if ($premium_icon['type'] === 'html')
                                                                        <div class="svg">
                                                                            {!! $premium_icon['icon'] !!}
                                                                        </div>
                                                                    @else
                                                                        <img src="{{ $premium_icon['icon'] }}"
                                                                            alt="icon">
                                                                    @endif
                                                                @endif
                                                            </div>
                                                            @if ($stream->stream_type == 'A')
                                                                @if (isset($stream->label_ad) && $stream->label_ad !== null)
                                                                    <div class="content-label"
                                                                        style="color: {{ \App\Services\AppConfig::get()->app->website_colors->themePrimaryTxtColor }}; {{ \App\Helpers\GeneralHelper::generateGradient(\App\Services\AppConfig::get()->app->website_colors->themeActiveColor) }}">
                                                                        {{ $stream->label_ad }}
                                                                    </div>
                                                                @endif
                                                            @else
                                                                @if (!($stream->premium_icon ?? null))
                                                                    @if (
                                                                        (($stream->label_free ?? null) && $stream->monetization_type === 'F') ||
                                                                            (($stream->label_premium ?? null) && $stream->monetization_type !== 'F'))
                                                                        <div class="content-label"
                                                                            style="color: {{ \App\Services\AppConfig::get()->app->website_colors->themePrimaryTxtColor }}; {{ \App\Helpers\GeneralHelper::generateGradient(\App\Services\AppConfig::get()->app->website_colors->themeActiveColor) }}">
                                                                            @if ($stream->monetization_type === 'F')
                                                                                {{ $stream->label_free }}
                                                                            @else
                                                                                {{ $stream->label_premium }}
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                    <div class="{{ $cardThumbCls }}">
                                                        <img src="{{ $stream->{$streamPosterKey} }}"
                                                            alt="{{ $stream->stream_title }}">
                                                    </div>
                                                    @if (isset(\App\Services\AppConfig::get()->app->toggle_trailer) &&
                                                            \App\Services\AppConfig::get()->app->toggle_trailer == 1 &&
                                                            !empty($stream->stream_promo_url) &&
                                                            !in_array($category->card_type, ['BA', 'LB']) &&
                                                            $stream->stream_type !== 'A' &&
                                                            !empty($streamUrl))
                                                        <video id="my-video-{{ $stream->stream_guid }}" preload="none"
                                                            class="card-video-js vjs-tech" muted>
                                                            <source src="{{ $streamUrl }}" {!! $mType !!}>
                                                        </video>
                                                    @else
                                                        <div class="detail_box_hide">
                                                            @if ($stream->stream_duration_timeformat !== '00:00')
                                                                <div class="detailbox_time">
                                                                    {{ $stream->stream_duration_timeformat ?? '' }}
                                                                </div>
                                                            @endif
                                                            <div class="deta_box">
                                                                <div class="season_title"></div>
                                                                <div class="content_title">{{ $stream->stream_title }}
                                                                </div>
                                                                @if ($stream->stream_description)
                                                                    <div class="content_description">
                                                                        {{ $stream->stream_description }}
                                                                    </div>
                                                                @endif
                                                                @if ($stream->stream_watched_dur_in_pct > 1)
                                                                    <div class="progress"
                                                                        style="background-color:#555455;height:5px; border-radius:2px;">
                                                                        <div class="progress-bar bg-primary"
                                                                            role="progressbar"
                                                                            style="background-color:#07659E;height:5px;border-radius:2px;width: {{ $stream->stream_watched_dur_in_pct }}%"
                                                                            aria-valuenow="{{ $stream->stream_watched_dur_in_pct }}"
                                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ $url }}">
                                            <div class="{{ $cardThumbCls2 }}">
                                                {{-- Premium Icon And Content Label --}}
                                                @if (!in_array($category->card_type, ['BA', 'LB']))
                                                    @if (isset($stream->notify_label) &&
                                                            ($stream->notify_label == 'available now' || $stream->notify_label == 'coming soon'))
                                                        <div class="content-label"
                                                            style="color: {{ \App\Services\AppConfig::get()->app->website_colors->themePrimaryTxtColor }}; {{ \App\Helpers\GeneralHelper::generateGradient(\App\Services\AppConfig::get()->app->website_colors->themeActiveColor) }}">
                                                            {{ strtoupper($stream->notify_label) }}
                                                        </div>
                                                    @else
                                                        <div class="trending_icon_box">
                                                            @if ($stream->premium_icon ?? null)
                                                                @php
                                                                    $premium_icon = json_decode(
                                                                        $stream->premium_icon,
                                                                        true,
                                                                    );
                                                                @endphp
                                                                @if ($premium_icon['type'] === 'html')
                                                                    @if ($stream->stream_type !== 'A')
                                                                        <div class="svg">
                                                                            {!! $premium_icon['icon'] !!}
                                                                        </div>
                                                                    @endif
                                                                @else
                                                                    @if ($stream->stream_type !== 'A')
                                                                        <img src="{{ $premium_icon['icon'] }}"
                                                                            alt="icon">
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </div>
                                                        @if ($stream->stream_type == 'A')
                                                            @if (isset($stream->label_ad) && $stream->label_ad !== null)
                                                                <div class="content-label"
                                                                    style="color: {{ \App\Services\AppConfig::get()->app->website_colors->themePrimaryTxtColor }}; {{ \App\Helpers\GeneralHelper::generateGradient(\App\Services\AppConfig::get()->app->website_colors->themeActiveColor) }}">
                                                                    {{ $stream->label_ad }}
                                                                </div>
                                                            @endif
                                                        @else
                                                            @if (!($stream->premium_icon ?? null))
                                                                @if (
                                                                    (($stream->label_free ?? null) && $stream->monetization_type === 'F') ||
                                                                        (($stream->label_premium ?? null) && $stream->monetization_type !== 'F'))
                                                                    <div class="content-label"
                                                                        style="color: {{ \App\Services\AppConfig::get()->app->website_colors->themePrimaryTxtColor }}; {{ \App\Helpers\GeneralHelper::generateGradient(\App\Services\AppConfig::get()->app->website_colors->themeActiveColor) }}">
                                                                        @if ($stream->monetization_type === 'F')
                                                                            {{ $stream->label_free }}
                                                                        @else
                                                                            {{ $stream->label_premium }}
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                                <div class="{{ $cardThumbCls }} ">
                                                    <img src="{{ $stream->{$streamPosterKey} }}"
                                                        alt="{{ $stream->stream_title }}">
                                                </div>
                                                @if (isset(\App\Services\AppConfig::get()->app->toggle_trailer) &&
                                                        \App\Services\AppConfig::get()->app->toggle_trailer == 1 &&
                                                        !empty($stream->stream_promo_url) &&
                                                        !in_array($category->card_type, ['BA', 'LB']) &&
                                                        $stream->stream_type !== 'A' &&
                                                        !empty($streamUrl))
                                                    <video id="my-video-{{ $stream->stream_guid }}" preload="none"
                                                        class="card-video-js vjs-tech" muted>
                                                        <source src="{{ $streamUrl }}" {!! $mType !!}>
                                                    </video>
                                                @else
                                                    <div class="detail_box_hide">
                                                        @if ($stream->stream_duration_timeformat !== '00:00')
                                                            <div class="detailbox_time">
                                                                {{ $stream->stream_duration_timeformat ?? '' }}
                                                            </div>
                                                        @endif
                                                        <div class="deta_box">
                                                            <div class="season_title"></div>
                                                            <div class="content_title">{{ $stream->stream_title }}
                                                            </div>
                                                            @if ($stream->stream_description)
                                                                <div class="content_description">
                                                                    {{ $stream->stream_description }}
                                                                </div>
                                                            @endif

                                                            @if ($stream->stream_watched_dur_in_pct > 1)
                                                                <div class="progress"
                                                                    style="background-color:#555455;height:5px; border-radius:2px;">
                                                                    <div class="progress-bar bg-primary"
                                                                        role="progressbar"
                                                                        style="background-color:#07659E;height:5px;border-radius:2px;width: {{ $stream->stream_watched_dur_in_pct }}%"
                                                                        aria-valuenow="{{ $stream->stream_watched_dur_in_pct }}"
                                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Check if the user is on a mobile device
            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            if (isMobile) {
                return;
            }
            const videoLinks = document.querySelectorAll('.video-link');


            videoLinks.forEach((link, index) => {
                const video = link.querySelector('.card-video-js');
                if (!video) {
                    // console.error(`Video element not found for link ${index}:`, link);
                    return;
                }

                // Check if the video is already initialized
                if (videojs.getPlayer(video.id)) {
                    // console.log(`Player ${index} (${video.id}) is already initialized.`);
                    return;
                }

                const player = videojs(video.id, {
                    muted: false,
                    preload: 'auto',
                });

                player.ready(() => {

                    link.addEventListener('mouseenter', () => {
                        player.pause();
                        player.muted(false);
                        player.currentTime(0);
                        player.play().then(() => {}).catch((error) => {
                            // console.error(`Error playing video ${index}:`, error);
                        });
                    });

                    link.addEventListener('mouseleave', () => {
                        player.muted(true);
                        player.pause();
                        player.currentTime(0);
                    });
                });
            });
        });
    </script>
@endpush
