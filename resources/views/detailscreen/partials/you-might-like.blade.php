
 <!--Start of season section-->
            <?php
            $arrSeasonData = isset($seasons) ? $seasons['streams'] : null;

            if (!empty($arrSeasonData)) {
            ?>
            <!-- Season listing -->
            <div class="season_boxlists">
                <ul class="season_listings">
                    <?php
                        foreach ($arrSeasonData as $seasonData) {
                            $cls = '';
                            if ($seasonData['is_selected'] == 'Y') {
                                $cls = "class='seasonactive rounded'";
                            }
                        ?>
                    <li><a class="rounded" href="<?php echo url('/'); ?>/detailscreen/<?php echo $seasonData['stream_guid']; ?>"
                            <?php echo $cls; ?>><?php echo $seasonData['season_title']; ?></a></li>
                    <?php
                        }
                        ?>
                </ul>
            </div>
            <?php
            }
            ?>
            <!--End of season section-->
            @if (!empty($latest_items))
                <!--Start of thumbnail slider section-->
                <section class="sliders">
                    <div class="slider-container">
                        <!-- Start shows -->
                        <div class="listing_box">
                            <div class="slider_title_box">
                                <div class="list_heading">
                                    <h1>{{ $latest_items['title'] }}</h1>
                                </div>
                            </div>
                            <div class="landscape_slider slider slick-slider">
                                @foreach ($latest_items['streams'] as $arrStreamsData)
                                    @php
                                        if ($arrStreamsData['stream_guid'] == $stream_guid) {
                                            continue;
                                        }

                                       

                                        if (
                                            (isset(
                                                \App\Services\AppConfig::get()->app->app_info->bypass_detailscreen,
                                            ) &&
                                                \App\Services\AppConfig::get()->app->app_info->bypass_detailscreen ==
                                                    1) ||
                                            $arrStreamsData['bypass_detailscreen'] == 1
                                        ) {
                                            $screen = 'playerscreen';
                                        } else {
                                            $screen = 'detailscreen';
                                        }
                                    @endphp
                                    <div>
                                        <a
                                            href="{{ url('/') }}/{{ $screen }}/{{ $arrStreamsData['stream_guid'] }}">
                                            <div class="thumbnail_img LA_5">
                                                {{--  <div class="trending_icon_box" {!! $strBrige !!}><img
                                                        src="{{ url('/') }}/assets/images/trending_icon.png"
                                                        alt="{{ $arrStreamsData['stream_title'] }}"></div>  --}}
                                                @if (($arrStreamsData['is_newly_added'] ?? 'N') === 'Y')
                                                    <div class="newly-added-label">
                                                        <span>New Episode</span>
                                                    </div>
                                                @endif
                                                <img onerror="this.src='{{ url('/') }}/assets/images/default_img.jpg'"
                                                    src="{{ $arrStreamsData['stream_poster'] }}"
                                                    alt="{{ $arrStreamsData['stream_title'] }}">
                                                <div class="detail_box_hide">
                                                    <div class="detailbox_time">
                                                        {{ $arrStreamsData['stream_duration_timeformat'] }}
                                                    </div>
                                                    <div class="deta_box">
                                                        <div class="season_title">
                                                            {{ $arrStreamsData['stream_episode_title'] && $arrStreamsData['stream_episode_title'] !== 'NULL' ? $arrStreamsData['stream_episode_title'] : '' }}
                                                        </div>
                                                        <div class="content_title">
                                                            {{ $arrStreamsData['stream_title'] }}
                                                        </div>
                                                        <div class="content_description">
                                                            {{ $arrStreamsData['stream_description'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- End Shows -->
                    </div>
                </section>
            @endif