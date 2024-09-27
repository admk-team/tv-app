<div class="my-tabs">
    <div class="sec-device content-wrapper px-2 px-md-3">
        <div class="tab-btns d-flex gap-3 gap-sm-3 gap-md-4 gap-lg-5">
            
            <!-- Start of season section -->
            <?php
            $arrSeasonData = isset($seasons) ? $seasons['streams'] : null;
            
            if (!empty($arrSeasonData)) {
                // Display the Season tab if data is available
                echo '<div class="tab active" data-tab="like"><span>Season</span></div>';
            } else {
                // Display the "You Might Also Like" tab if no season data is available
                echo '<div class="tab active" data-tab="like"><span>You Might Also Like</span></div>';
            }
            ?>
            <!--End of season section-->
            @if (
                (isset($stream_details['video_rating']) && $stream_details['video_rating'] === 'E') ||
                    (isset(\App\Services\AppConfig::get()->app->app_info->global_rating_enable) &&
                        \App\Services\AppConfig::get()->app->app_info->global_rating_enable == 1))
                <div class="tab" data-tab="reviews"><span>Reviews</span></div>
            @endif
        </div>
    </div>

    <div class="tab-content">
        <div data-tab-content="like" class="content ">
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
                                        if ($arrStreamsData['stream_guid'] === $stream_details['stream_guid']) {
                                            continue;
                                        }

                                        $strBrige = '';
                                        if ($arrStreamsData['monetization_type'] == 'F') {
                                            $strBrige = "style='display: none;'";
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
                                            <div class="thumbnail_img">
                                                <div class="trending_icon_box" {!! $strBrige !!}><img
                                                        src="{{ url('/') }}/assets/images/trending_icon.png"
                                                        alt="{{ $arrStreamsData['stream_title'] }}"></div>
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
                                                        <div class="content_title">{{ $arrStreamsData['stream_title'] }}
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
        </div>
        @if (
            (isset($stream_details['video_rating']) && $stream_details['video_rating'] === 'E') ||
                (isset(\App\Services\AppConfig::get()->app->app_info->global_rating_enable) &&
                    \App\Services\AppConfig::get()->app->app_info->global_rating_enable == 1))
            <div data-tab-content="reviews" class="content d-none"><!--Start of Ratings section-->
                <div class="item-ratings">
                    <h1 class="section-title">Reviews</h1>
                    @php
                        if (sizeof($stream_details['ratings'] ?? []) < 1) {
                            echo '<p class="text-white" style="margin-bottom: -8px !important;">No reviews found.</p>';
                        }

                        $userDidComment = false;
                        foreach ($stream_details['ratings'] ?? [] as $rating) {
                            if (
                                session()->has('USER_DETAILS') &&
                                $rating['user']['id'] == session('USER_DETAILS')['USER_ID']
                            ) {
                                $userDidComment = true;
                            }
                        }
                    @endphp
                    @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !$userDidComment && !$userDidComment)
                        {{-- Stars  --}}
                        @if (isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                $stream_details['rating_type'] === 'stars' &&
                                $stream_details['video_rating'] === 'E')
                            <div class="review-rating user-rating">
                                <div class="star" data-rating="1" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>star</title>
                                            <path
                                                d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="2" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>star</title>
                                            <path
                                                d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="3" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>star</title>
                                            <path
                                                d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="4" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>star</title>
                                            <path
                                                d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="5" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>star</title>
                                            <path
                                                d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        @elseif(isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                $stream_details['rating_type'] === 'hearts' &&
                                $stream_details['video_rating'] === 'E')
                            {{-- Hearts  --}}
                            <div class="review-rating user-rating">
                                <div class="star" data-rating="1" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>heart</title>
                                            <path
                                                d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="2" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>heart</title>
                                            <path
                                                d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="3" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>heart</title>
                                            <path
                                                d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="4" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>heart</title>
                                            <path
                                                d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="5" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>heart</title>
                                            <path
                                                d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            {{-- @php
                        $isHearted = 0;
                    @endphp
                    <div class="review-rating user-rating" role="button">
                        <div class="heart" data-rating="{{ $isHearted ? 1 : 0 }}" onclick="handleHeartRating(this)">
                            <svg fill="{{ $isHearted ? '#c54f3f' : '#ffffff' }}" height="27px" width="27px"
                                version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 471.701 471.701"
                                xml:space="preserve" stroke="#bfbfbf">
                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <path
                                            d="M433.601,67.001c-24.7-24.7-57.4-38.2-92.3-38.2s-67.7,13.6-92.4,38.3l-12.9,12.9l-13.1-13.1 c-24.7-24.7-57.6-38.4-92.5-38.4c-34.8,0-67.6,13.6-92.2,38.2c-24.7,24.7-38.3,57.5-38.2,92.4c0,34.9,13.7,67.6,38.4,92.3 l187.8,187.8c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-3.9l188.2-187.5c24.7-24.7,38.3-57.5,38.3-92.4 C471.801,124.501,458.301,91.701,433.601,67.001z M414.401,232.701l-178.7,178l-178.3-178.3c-19.6-19.6-30.4-45.6-30.4-73.3 s10.7-53.7,30.3-73.2c19.5-19.5,45.5-30.3,73.1-30.3c27.7,0,53.8,10.8,73.4,30.4l22.6,22.6c5.3,5.3,13.8,5.3,19.1,0l22.4-22.4 c19.6-19.6,45.7-30.4,73.3-30.4c27.6,0,53.6,10.8,73.2,30.3c19.6,19.6,30.3,45.6,30.3,73.3 C444.801,187.101,434.001,213.101,414.401,232.701z" />
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div> --}}
                        @elseif(isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                $stream_details['rating_type'] === 'thumbs' &&
                                $stream_details['video_rating'] === 'E')
                            {{-- Thumbs  --}}
                            <div class="user-rating" style=" margin-top: 25px; display: flex; gap: 12px;">
                                <div class="like" style="rotate: 180deg" role="button"
                                    onclick="handleRating(this, 'like')">
                                    <input class="form-check-input" type="radio" name="like_status" id="like_status"
                                        value="5" style="display: none">
                                    <label class="form-check-label" for="like_status" role="button">
                                        <svg fill="#6e6e6e" height="27px" width="27px" version="1.1" id="Capa_1"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            viewBox="0 0 208.666 208.666" xml:space="preserve" stroke="#6e6e6e">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g>
                                                    <path
                                                        d="M54.715,24.957c-0.544,0.357-1.162,0.598-1.806,0.696l-28.871,4.403c-2.228,0.341-3.956,2.257-3.956,4.511v79.825 c0,1.204,33.353,20.624,43.171,30.142c12.427,12.053,21.31,34.681,33.983,54.373c4.405,6.845,10.201,9.759,15.584,9.759 c10.103,0,18.831-10.273,14.493-24.104c-4.018-12.804-8.195-24.237-13.934-34.529c-4.672-8.376,1.399-18.7,10.989-18.7h48.991 c18.852,0,18.321-26.312,8.552-34.01c-1.676-1.32-2.182-3.682-1.175-5.563c3.519-6.572,2.86-20.571-6.054-25.363 c-2.15-1.156-3.165-3.74-2.108-5.941c3.784-7.878,3.233-24.126-8.71-27.307c-2.242-0.598-3.699-2.703-3.405-5.006 c0.909-7.13-0.509-20.86-22.856-26.447C133.112,0.573,128.281,0,123.136,0C104.047,0.001,80.683,7.903,54.715,24.957z">
                                                    </path>
                                                </g>
                                            </g>
                                        </svg>
                                    </label>
                                </div>
                                <div class="dislike" role="button" onclick="handleRating(this, 'dislike')">
                                    <input class="form-check-input" type="radio" name="like_status"
                                        id="dislike_status" value="1" style="display: none">
                                    <label class="form-check-label" for="dislike_status" role="button">
                                        <svg fill="#6e6e6e" height="27px" width="27px" version="1.1" id="Capa_1"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            viewBox="0 0 208.666 208.666" xml:space="preserve" stroke="#6e6e6e">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g>
                                                    <path
                                                        d="M54.715,24.957c-0.544,0.357-1.162,0.598-1.806,0.696l-28.871,4.403c-2.228,0.341-3.956,2.257-3.956,4.511v79.825 c0,1.204,33.353,20.624,43.171,30.142c12.427,12.053,21.31,34.681,33.983,54.373c4.405,6.845,10.201,9.759,15.584,9.759 c10.103,0,18.831-10.273,14.493-24.104c-4.018-12.804-8.195-24.237-13.934-34.529c-4.672-8.376,1.399-18.7,10.989-18.7h48.991 c18.852,0,18.321-26.312,8.552-34.01c-1.676-1.32-2.182-3.682-1.175-5.563c3.519-6.572,2.86-20.571-6.054-25.363 c-2.15-1.156-3.165-3.74-2.108-5.941c3.784-7.878,3.233-24.126-8.71-27.307c-2.242-0.598-3.699-2.703-3.405-5.006 c0.909-7.13-0.509-20.86-22.856-26.447C133.112,0.573,128.281,0,123.136,0C104.047,0.001,80.683,7.903,54.715,24.957z">
                                                    </path>
                                                </g>
                                            </g>
                                        </svg>
                                    </label>

                                </div>
                            </div>
                        @elseif (isset(
                                \App\Services\AppConfig::get()->app->app_info->global_rating_enable,
                                \App\Services\AppConfig::get()->app->app_info->global_rating_type) &&
                                \App\Services\AppConfig::get()->app->app_info->global_rating_enable == 1 &&
                                \App\Services\AppConfig::get()->app->app_info->global_rating_type === 'stars')
                            <div class="review-rating user-rating">
                                <div class="star" data-rating="1" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>star</title>
                                            <path
                                                d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="2" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>star</title>
                                            <path
                                                d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="3" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>star</title>
                                            <path
                                                d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="4" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>star</title>
                                            <path
                                                d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="5" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>star</title>
                                            <path
                                                d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        @elseif (isset(
                                \App\Services\AppConfig::get()->app->app_info->global_rating_enable,
                                \App\Services\AppConfig::get()->app->app_info->global_rating_type) &&
                                \App\Services\AppConfig::get()->app->app_info->global_rating_enable == 1 &&
                                \App\Services\AppConfig::get()->app->app_info->global_rating_type === 'hearts')
                            {{-- Hearts  --}}
                            <div class="review-rating user-rating">
                                <div class="star" data-rating="1" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>heart</title>
                                            <path
                                                d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="2" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>heart</title>
                                            <path
                                                d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="3" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>heart</title>
                                            <path
                                                d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="4" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>heart</title>
                                            <path
                                                d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="star" data-rating="5" onclick="handleStarRating(this)">
                                    <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>heart</title>
                                            <path
                                                d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            {{-- @php
                    $isHearted = 0;
                @endphp
                <div class="review-rating user-rating" role="button">
                    <div class="heart" data-rating="{{ $isHearted ? 1 : 0 }}" onclick="handleHeartRating(this)">
                        <svg fill="{{ $isHearted ? '#c54f3f' : '#ffffff' }}" height="27px" width="27px"
                            version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 471.701 471.701"
                            xml:space="preserve" stroke="#bfbfbf">
                            <g id="SVGRepo_bgCarrier" stroke-width="0" />
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path
                                        d="M433.601,67.001c-24.7-24.7-57.4-38.2-92.3-38.2s-67.7,13.6-92.4,38.3l-12.9,12.9l-13.1-13.1 c-24.7-24.7-57.6-38.4-92.5-38.4c-34.8,0-67.6,13.6-92.2,38.2c-24.7,24.7-38.3,57.5-38.2,92.4c0,34.9,13.7,67.6,38.4,92.3 l187.8,187.8c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-3.9l188.2-187.5c24.7-24.7,38.3-57.5,38.3-92.4 C471.801,124.501,458.301,91.701,433.601,67.001z M414.401,232.701l-178.7,178l-178.3-178.3c-19.6-19.6-30.4-45.6-30.4-73.3 s10.7-53.7,30.3-73.2c19.5-19.5,45.5-30.3,73.1-30.3c27.7,0,53.8,10.8,73.4,30.4l22.6,22.6c5.3,5.3,13.8,5.3,19.1,0l22.4-22.4 c19.6-19.6,45.7-30.4,73.3-30.4c27.6,0,53.6,10.8,73.2,30.3c19.6,19.6,30.3,45.6,30.3,73.3 C444.801,187.101,434.001,213.101,414.401,232.701z" />
                                </g>
                            </g>
                        </svg>
                    </div>
                </div> --}}
                        @else
                            {{-- Thumbs  --}}
                            <div class="user-rating" style=" margin-top: 25px; display: flex; gap: 12px;">
                                <div class="like" style="rotate: 180deg" role="button"
                                    onclick="handleRating(this, 'like')">
                                    <input class="form-check-input" type="radio" name="like_status" id="like_status"
                                        value="5" style="display: none">
                                    <label class="form-check-label" for="like_status" role="button">
                                        <svg fill="#6e6e6e" height="27px" width="27px" version="1.1" id="Capa_1"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            viewBox="0 0 208.666 208.666" xml:space="preserve" stroke="#6e6e6e">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g>
                                                    <path
                                                        d="M54.715,24.957c-0.544,0.357-1.162,0.598-1.806,0.696l-28.871,4.403c-2.228,0.341-3.956,2.257-3.956,4.511v79.825 c0,1.204,33.353,20.624,43.171,30.142c12.427,12.053,21.31,34.681,33.983,54.373c4.405,6.845,10.201,9.759,15.584,9.759 c10.103,0,18.831-10.273,14.493-24.104c-4.018-12.804-8.195-24.237-13.934-34.529c-4.672-8.376,1.399-18.7,10.989-18.7h48.991 c18.852,0,18.321-26.312,8.552-34.01c-1.676-1.32-2.182-3.682-1.175-5.563c3.519-6.572,2.86-20.571-6.054-25.363 c-2.15-1.156-3.165-3.74-2.108-5.941c3.784-7.878,3.233-24.126-8.71-27.307c-2.242-0.598-3.699-2.703-3.405-5.006 c0.909-7.13-0.509-20.86-22.856-26.447C133.112,0.573,128.281,0,123.136,0C104.047,0.001,80.683,7.903,54.715,24.957z">
                                                    </path>
                                                </g>
                                            </g>
                                        </svg>
                                    </label>
                                </div>
                                <div class="dislike" role="button" onclick="handleRating(this, 'dislike')">
                                    <input class="form-check-input" type="radio" name="like_status"
                                        id="dislike_status" value="1" style="display: none">
                                    <label class="form-check-label" for="dislike_status" role="button">
                                        <svg fill="#6e6e6e" height="27px" width="27px" version="1.1" id="Capa_1"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            viewBox="0 0 208.666 208.666" xml:space="preserve" stroke="#6e6e6e">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g>
                                                    <path
                                                        d="M54.715,24.957c-0.544,0.357-1.162,0.598-1.806,0.696l-28.871,4.403c-2.228,0.341-3.956,2.257-3.956,4.511v79.825 c0,1.204,33.353,20.624,43.171,30.142c12.427,12.053,21.31,34.681,33.983,54.373c4.405,6.845,10.201,9.759,15.584,9.759 c10.103,0,18.831-10.273,14.493-24.104c-4.018-12.804-8.195-24.237-13.934-34.529c-4.672-8.376,1.399-18.7,10.989-18.7h48.991 c18.852,0,18.321-26.312,8.552-34.01c-1.676-1.32-2.182-3.682-1.175-5.563c3.519-6.572,2.86-20.571-6.054-25.363 c-2.15-1.156-3.165-3.74-2.108-5.941c3.784-7.878,3.233-24.126-8.71-27.307c-2.242-0.598-3.699-2.703-3.405-5.006 c0.909-7.13-0.509-20.86-22.856-26.447C133.112,0.573,128.281,0,123.136,0C104.047,0.001,80.683,7.903,54.715,24.957z">
                                                    </path>
                                                </g>
                                            </g>
                                        </svg>
                                    </label>

                                </div>
                            </div>
                        @endif

                        <span class="text-danger">
                            @error('rating')
                                {{ $message }}
                            @enderror
                        </span>
                        <form action="{{ route('addrating') }}" method="POST" onsubmit="return submitOnce()">
                            @csrf
                            <textarea name="comment" cols="30" rows="10" placeholder="Let others know what you think..."></textarea>
                            <input type="hidden" name="rating" id="hiddenRating">
                            <input type="hidden" name="stream_code" value="{{ $stream_details['stream_guid'] }}">
                            <input type="hidden" name="type" value="stream">
                            <input class="rounded" type="submit" id="submitButton" value="Submit">
                        </form>
                        <hr>
                    @endif

                    <div
                        class="member-reviews {{ !session('USER_DETAILS') || !session('USER_DETAILS')['USER_CODE'] || $userDidComment ? 'mt-4' : '' }}">
                        <?php
                foreach ($stream_details['ratings'] as $review) {
                    $name = $review['user']['name'];
                    $name_arr = explode(' ', $name);
                    $name_symbol = '';

                    $name_symbol .= $name_arr[0][0];

                    if (sizeof($name_arr) > 1)
                        $name_symbol .= $name_arr[1][0];

                    ?>

                        <div class="review">
                            <div class="user">
                                <div class="profile-name"><?= $name_symbol ?></div>
                                <h4 class="username mb-0"><?= $review['user']['name'] ?></h4>
                            </div>
                            <div class="review-rating member">

                                @if (isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                        $stream_details['rating_type'] === 'stars' &&
                                        $stream_details['video_rating'] === 'E')
                                    @for ($i = 0; $i < $review['rating']; $i++)
                                        <div class="star active">
                                            <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                                version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <title>star</title>
                                                    <path
                                                        d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                                    </path>
                                                </g>
                                            </svg>
                                        </div>
                                    @endfor
                                @elseif(isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                        $stream_details['rating_type'] === 'hearts' &&
                                        $stream_details['video_rating'] === 'E')
                                    @for ($i = 0; $i < $review['rating']; $i++)
                                        <div class="star active">
                                            <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                                version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <title>heart</title>
                                                    <path
                                                        d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                                    </path>
                                                </g>
                                            </svg>
                                        </div>
                                    @endfor
                                @elseif(isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                        $stream_details['rating_type'] === 'thumbs' &&
                                        $stream_details['video_rating'] === 'E')
                                    {{-- Thumbs  --}}
                                    <div class="user-rating" style="margin-top: 10px; display: flex; gap: 12px;">
                                        @if ($review['rating'] >= 3)
                                            <div class="like active" style="rotate: 180deg">
                                                <svg fill="{{ \App\Services\AppConfig::get()->app->website_colors->themeActiveColor }}"
                                                    height="27px" width="27px" version="1.1" id="Capa_1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    viewBox="0 0 208.666 208.666" xml:space="preserve" stroke="#6e6e6e">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                    </g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <g>
                                                            <path
                                                                d="M54.715,24.957c-0.544,0.357-1.162,0.598-1.806,0.696l-28.871,4.403c-2.228,0.341-3.956,2.257-3.956,4.511v79.825 c0,1.204,33.353,20.624,43.171,30.142c12.427,12.053,21.31,34.681,33.983,54.373c4.405,6.845,10.201,9.759,15.584,9.759 c10.103,0,18.831-10.273,14.493-24.104c-4.018-12.804-8.195-24.237-13.934-34.529c-4.672-8.376,1.399-18.7,10.989-18.7h48.991 c18.852,0,18.321-26.312,8.552-34.01c-1.676-1.32-2.182-3.682-1.175-5.563c3.519-6.572,2.86-20.571-6.054-25.363 c-2.15-1.156-3.165-3.74-2.108-5.941c3.784-7.878,3.233-24.126-8.71-27.307c-2.242-0.598-3.699-2.703-3.405-5.006 c0.909-7.13-0.509-20.86-22.856-26.447C133.112,0.573,128.281,0,123.136,0C104.047,0.001,80.683,7.903,54.715,24.957z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="dislike">
                                                <svg fill="{{ \App\Services\AppConfig::get()->app->website_colors->themeActiveColor }}"
                                                    height="27px" width="27px" version="1.1" id="Capa_1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    viewBox="0 0 208.666 208.666" xml:space="preserve" stroke="#6e6e6e">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                    </g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <g>
                                                            <path
                                                                d="M54.715,24.957c-0.544,0.357-1.162,0.598-1.806,0.696l-28.871,4.403c-2.228,0.341-3.956,2.257-3.956,4.511v79.825 c0,1.204,33.353,20.624,43.171,30.142c12.427,12.053,21.31,34.681,33.983,54.373c4.405,6.845,10.201,9.759,15.584,9.759 c10.103,0,18.831-10.273,14.493-24.104c-4.018-12.804-8.195-24.237-13.934-34.529c-4.672-8.376,1.399-18.7,10.989-18.7h48.991 c18.852,0,18.321-26.312,8.552-34.01c-1.676-1.32-2.182-3.682-1.175-5.563c3.519-6.572,2.86-20.571-6.054-25.363 c-2.15-1.156-3.165-3.74-2.108-5.941c3.784-7.878,3.233-24.126-8.71-27.307c-2.242-0.598-3.699-2.703-3.405-5.006 c0.909-7.13-0.509-20.86-22.856-26.447C133.112,0.573,128.281,0,123.136,0C104.047,0.001,80.683,7.903,54.715,24.957z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                @elseif (isset(
                                        \App\Services\AppConfig::get()->app->app_info->global_rating_enable,
                                        \App\Services\AppConfig::get()->app->app_info->global_rating_type) &&
                                        \App\Services\AppConfig::get()->app->app_info->global_rating_enable == 1 &&
                                        \App\Services\AppConfig::get()->app->app_info->global_rating_type === 'stars')
                                    @for ($i = 0; $i < $review['rating']; $i++)
                                        <div class="star active">
                                            <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                                version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <title>star</title>
                                                    <path
                                                        d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                                    </path>
                                                </g>
                                            </svg>
                                        </div>
                                    @endfor
                                @elseif(isset(
                                        \App\Services\AppConfig::get()->app->app_info->global_rating_enable,
                                        \App\Services\AppConfig::get()->app->app_info->global_rating_type) &&
                                        \App\Services\AppConfig::get()->app->app_info->global_rating_enable == 1 &&
                                        \App\Services\AppConfig::get()->app->app_info->global_rating_type === 'hearts')
                                    @for ($i = 0; $i < $review['rating']; $i++)
                                        <div class="star active">
                                            <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                                version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <title>heart</title>
                                                    <path
                                                        d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                                    </path>
                                                </g>
                                            </svg>
                                        </div>
                                    @endfor
                                @else
                                    {{-- Thumbs  --}}
                                    <div class="user-rating" style="margin-top: 10px; display: flex; gap: 12px;">
                                        @if ($review['rating'] >= 3)
                                            <div class="like active" style="rotate: 180deg">
                                                <svg fill="{{ \App\Services\AppConfig::get()->app->website_colors->themeActiveColor }}"
                                                    height="27px" width="27px" version="1.1" id="Capa_1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    viewBox="0 0 208.666 208.666" xml:space="preserve" stroke="#6e6e6e">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                    </g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <g>
                                                            <path
                                                                d="M54.715,24.957c-0.544,0.357-1.162,0.598-1.806,0.696l-28.871,4.403c-2.228,0.341-3.956,2.257-3.956,4.511v79.825 c0,1.204,33.353,20.624,43.171,30.142c12.427,12.053,21.31,34.681,33.983,54.373c4.405,6.845,10.201,9.759,15.584,9.759 c10.103,0,18.831-10.273,14.493-24.104c-4.018-12.804-8.195-24.237-13.934-34.529c-4.672-8.376,1.399-18.7,10.989-18.7h48.991 c18.852,0,18.321-26.312,8.552-34.01c-1.676-1.32-2.182-3.682-1.175-5.563c3.519-6.572,2.86-20.571-6.054-25.363 c-2.15-1.156-3.165-3.74-2.108-5.941c3.784-7.878,3.233-24.126-8.71-27.307c-2.242-0.598-3.699-2.703-3.405-5.006 c0.909-7.13-0.509-20.86-22.856-26.447C133.112,0.573,128.281,0,123.136,0C104.047,0.001,80.683,7.903,54.715,24.957z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="dislike">
                                                <svg fill="{{ \App\Services\AppConfig::get()->app->website_colors->themeActiveColor }}"
                                                    height="27px" width="27px" version="1.1" id="Capa_1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    viewBox="0 0 208.666 208.666" xml:space="preserve" stroke="#6e6e6e">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                    </g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <g>
                                                            <path
                                                                d="M54.715,24.957c-0.544,0.357-1.162,0.598-1.806,0.696l-28.871,4.403c-2.228,0.341-3.956,2.257-3.956,4.511v79.825 c0,1.204,33.353,20.624,43.171,30.142c12.427,12.053,21.31,34.681,33.983,54.373c4.405,6.845,10.201,9.759,15.584,9.759 c10.103,0,18.831-10.273,14.493-24.104c-4.018-12.804-8.195-24.237-13.934-34.529c-4.672-8.376,1.399-18.7,10.989-18.7h48.991 c18.852,0,18.321-26.312,8.552-34.01c-1.676-1.32-2.182-3.682-1.175-5.563c3.519-6.572,2.86-20.571-6.054-25.363 c-2.15-1.156-3.165-3.74-2.108-5.941c3.784-7.878,3.233-24.126-8.71-27.307c-2.242-0.598-3.699-2.703-3.405-5.006 c0.909-7.13-0.509-20.86-22.856-26.447C133.112,0.573,128.281,0,123.136,0C104.047,0.001,80.683,7.903,54.715,24.957z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <p class="member-comment">{{ $review['comment'] }}</p>
                        </div>
                        <hr>
                        <?php
                }
            ?>
                    </div>
                </div>

            </div>
        @endif

    </div>
</div>