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
                            $cardThumbCls2 = 'thumbnail_img leaderboard_img';
                            $streamPosterKey = 'stream_poster';
                            break;
                    }
                @endphp
                <div class="listing_box">
                    <div class="slider_title_box">
                        <div class="list_heading">
                            <h1>{{ $category->cat_title ?? '' }}</h1>
                        </div>
                    </div>
                    <div class="{{ $cartMainCls }} slider slick-slider">
                        @foreach ($category->streams as $stream)
                            <div class="item">
                                <div class="{{ $cartMainSubCls }}">
                                    <a href='{{ route('detailscreen', $stream->stream_guid) }}'>
                                        <div class="{{ $cardThumbCls2 }}">
                                            <div class="trending_icon_box" style='display: none;'><img
                                                src="{{ url('/') }}/assets/images/trending_icon.png" alt="{{ $stream->stream_title }}">
                                            </div>
                                            <div class="{{ $cardThumbCls }}">
                                                <img src="{{ $stream->{$streamPosterKey} }}" alt="{{ $stream->stream_title }}">
                                            </div>
                                            <div class="detail_box_hide">
                                                <div class="detailbox_time">
                                                    {{ $stream->stream_duration_timeformat ?? '' }}
                                                </div>
                                                <div class="deta_box">
                                                    <div class="season_title"></div>
                                                    <div class="content_title">{{ $stream->stream_title }}</div>
                                                    <div class="content_description">{{ $stream->stream_description }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
