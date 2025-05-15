<style>
    .ruby {
        display: ruby;
        margin-left: 10px;
    }
</style>
<div class="button_groupbox ruby align-items-center mb-2 mt-2">
    <div class="movieDetailPlaymobile mb-3">
        @if (isset($stream_details['notify_label']) && $stream_details['notify_label'] == 'available now')
            <a href="{{ route('playerscreen', $stream_details['stream_guid']) }}" class="mobile-primary-btn rounded">
                <i class="fa fa-play"></i>
                Available Now
            </a>
        @elseif (isset($stream_details['notify_label']) && $stream_details['notify_label'] == 'coming soon')
            @if (session()->has('USER_DETAILS') && session('USER_DETAILS') !== null)
                <!-- Mobile View -->
                <form id="remind-form-mobile" method="POST" action="{{ route('remind.me') }}">
                    @csrf
                    <input type="hidden" name="stream_code" id="mobile-stream-code"
                        value="{{ $stream_details['stream_guid'] }}">
                    <button class="mobile-primary-btn rounded" id="remind-button-mobile">
                        <i id="mobile-remind-icon" class="fas fa-bell"></i>
                        <span id="mobile-remind-text">Remind me</span>
                    </button>
                </form>
            @else
                <a class="mobile-primary-btn rounded">
                    <i class="fa fa-play"></i>
                    Coming Soon
                </a>
            @endif
        @else
            @if (session('USER_DETAILS') &&
                    session('USER_DETAILS')['USER_CODE'] &&
                    $stream_details['is_buyed'] == 'N' &&
                    ($stream_details['monetization_type'] == 'P' ||
                        $stream_details['monetization_type'] == 'S' ||
                        $stream_details['monetization_type'] == 'O'))
                <a href="{{ route('playerscreen', $stream_details['stream_guid']) }}"
                    class="mobile-primary-btn rounded">
                    <i class="fa fa-dollar"></i>
                    Buy Now
                </a>
            @else
                <a href="{{ route('playerscreen', $stream_details['stream_guid']) }}"
                    class="mobile-primary-btn rounded">
                    <i class="fa fa-play"></i>
                    Play Now
                </a>
            @endif
        @endif
    </div>
    @if ($streamUrl !== '')
        <div class="movieDetailPlaymobile mb-3">
            <a id="trailer-id" class="mobile-primary-btn rounded">
                <i class="fa fa-play"></i> Trailer
            </a>
        </div>
    @endif
    <?php
if (session('USER_DETAILS.USER_CODE')) {
    $signStr = "+";
    $cls = 'fa fa-plus';
    if ($stream_details['stream_is_stream_added_in_wish_list'] == 'Y') {
        $cls = 'fa fa-minus';
        $signStr = "-";
    }
?>
    <div class="share_circle addWtchBtn mb-3">
        <a href="javascript:void(0);" onClick="javascript:manageFavItem();"><i id="btnicon-fav"
                class="<?php echo $cls; ?> theme-active-color"></i></a>
        <input type="hidden" id="myWishListSign" value='<?php echo $signStr; ?>' />
        <input type="hidden" id="strQueryParm" value='<?php echo $strQueryParm; ?>' />
        <input type="hidden" id="reqUrl" value='{{ route('wishlist.toggle') }}' />
        @csrf
    </div>
    @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'])
        @if (!empty($stream_details['is_watch_party']) && $stream_details['is_watch_party'] == 1)
            <div class="share_circle addWtchBtn mb-3">
                <a href="{{ route('create.watch.party', $stream_details['stream_guid']) }}" data-bs-toggle="tooltip"
                    title="Create a Watch Party">
                    <i class="fa fa-users theme-active-color"></i>
                </a>
            </div>
        @endif
    @endif
    <?php
}
?>
    <div class="share_circle addWtchBtn mb-3" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
        <a href="javascript:void(0)"><i class="fa fa-share theme-active-color"></i></a>
    </div>
    @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'])
        @if (
            !empty($stream_details['is_gift']) &&
                $stream_details['is_gift'] == 1 &&
                ($stream_details['monetization_type'] == 'P' ||
                    $stream_details['monetization_type'] == 'S' ||
                    $stream_details['monetization_type'] == 'O'))
            <div class="share_circle addWtchBtn mb-3" data-bs-toggle="modal" data-bs-target="#giftModal">
                <a href="javascript:void(0);"><i class="fa-solid fa-gift theme-active-color"></i></a>
            </div>
        @endif
    @endif
    @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'])
        @if (
            !empty($stream_details['is_gift']) &&
                $stream_details['is_gift'] == 1 &&
                ($stream_details['monetization_type'] == 'P' ||
                    $stream_details['monetization_type'] == 'S' ||
                    $stream_details['monetization_type'] == 'O'))
            <div class="share_circle addWtchBtn mb-3" data-bs-toggle="modal" data-bs-target="#giftModal">
                <a href="javascript:void(0);"><i class="fa-solid fa-gift theme-active-color"></i></a>
            </div>
        @endif
    @endif
    @if (isset(\App\Services\AppConfig::get()->app->badge_status) && \App\Services\AppConfig::get()->app->badge_status === 1)
        @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'])
            @if (isset($stream_details['gamified_content']) && $stream_details['gamified_content'] == 1)
                <div class="share_circle addWtchBtn mb-3">
                    <a href="{{ route('user.badge') }}" data-bs-toggle="tooltip" title="Gamified Content">
                        <i class="fa-solid fa-award theme-active-color"></i>
                    </a>
                </div>
            @endif
        @endif
    @endif
    @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'])
        @if (isset($stream_details['tip_jar']) && $stream_details['tip_jar'] == 1)
            <div class="share_circle addWtchBtn">
                <form id="tipjarForm" action="{{ route('tipjar.view') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $stream_details['stream_guid'] }}" name="streamcode" />
                    <input type="hidden" value="{{ $stream_details['stream_poster'] }}" name="streamposter" />
                </form>
                <a href="javascript:void(0);" data-bs-toggle="tooltip" title="Tip Jar"
                    onclick="document.getElementById('tipjarForm').submit();">
                    <i class="fa-solid fa-hand-holding-dollar theme-active-color"></i>
                </a>
            </div>
        @endif
    @endif
    @if (session('USER_DETAILS') &&
            session('USER_DETAILS')['USER_CODE'] &&
            isset(\App\Services\AppConfig::get()->app->frnd_option_status) &&
            \App\Services\AppConfig::get()->app->frnd_option_status === 1)
        <div class="share_circle addWtchBtn" data-bs-toggle="modal" data-bs-target="#recommendation">
            <a href="javascript:void(0);" role="button" data-bs-toggle="tooltip" title="Recommendations">
                <i class="fa-solid fa-film theme-active-color"></i>
            </a>
        </div>
    @endif
</div>
<div class="my-tabs">
    <div class="sec-device content-wrapper px-3 px-md-3">
        <div class="tab-btns d-flex gap-3 gap-sm-3 gap-md-4 gap-lg-5">
            <div class="tab mobile-data active" data-tab="overview"><span>Overview</span></div>
            <!-- Start of season section -->
            {{--  <?php
            $arrSeasonData = isset($seasons) ? $seasons['streams'] : null;
            
            if (!empty($arrSeasonData)) {
                // Display the Season tab if data is available
                echo '<div class="tab" data-tab="like"><span>Season</span></div>';
            } else {
                // Display the "You Might Also Like" tab if no season data is available
                echo '<div class="tab" data-tab="like"><span>You Might Also Like</span></div>';
            }
            ?>  --}}
            @if ($latest_items['title'])
                <div class="tab " data-tab="like"><span>{{ $latest_items['title'] }}</span></div>
            @endif
            <!--End of season section-->
            @if (
                (isset($stream_details['video_rating']) && $stream_details['video_rating'] == 1))
                <div class="tab" data-tab="reviews"><span>Reviews</span></div>
            @endif
        </div>
    </div>

    <div class="tab-content">
        <div data-tab-content="overview" class="content">
            <div class="px-4">
                @if (isset($stream_details['title_logo'], $stream_details['show_title_logo']) &&
                        $stream_details['title_logo'] &&
                        $stream_details['show_title_logo'] == 1)
                    <div class="title_logo mb-1">
                        <img class="img-fluid" src="{{ $stream_details['title_logo'] }}"
                            alt="{{ $stream_details['stream_title'] ?? 'Logo' }}">
                    </div>
                @else
                    <h1 class="content-heading themePrimaryTxtColr"
                        title="{{ $stream_details['stream_title'] ?? '' }}">
                        {{ $stream_details['stream_title'] ?? '' }}
                    </h1>
                @endif
                <div class="content-timing mb-2">
                    @if ($stream_details['released_year'])
                        <a href="{{ route('year', $stream_details['released_year']) }}" class="text-decoration-none">
                            <span class="year themePrimaryTxtColr">{{ $stream_details['released_year'] }}</span>
                        </a>
                        <span class="mobile-dot-sep"></span>
                    @endif
                    @if ($streamType != 'S')
                        @if ($stream_details['stream_duration'] && $stream_details['stream_duration'] !== '0')
                            <span
                                class="themePrimaryTxtColr">{{ \App\Helpers\GeneralHelper::showDurationInHourAndMins($stream_details['stream_duration']) }}</span>
                            <span class="mobile-dot-sep"></span>
                        @endif
                        {{-- <span class="movie_type">{{ $stream_details['cat_title'] }}</span> --}}
                        <span class="movie_type themePrimaryTxtColr">
                            @foreach ($stream_details['genre'] ?? [] as $item)
                                <a href="{{ route('category', $item['code']) }}?type=genre"
                                    class="px-0 themePrimaryTxtColr">{{ $item['title'] }}</a>{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </span>
                    @endif
                    @if ($streamType == 'S')
                        <span
                            class="movie_type themePrimaryTxtColr">{{ $stream_details['stream_episode_title'] && $stream_details['stream_episode_title'] !== 'NULL' ? $stream_details['stream_episode_title'] : '' }}</span>
                        <span class="movie_type themePrimaryTxtColr">{{ $stream_details['show_name'] }}</span>
                    @endif


                    @if ($ratingsCount > 0)
                        @if (isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                $stream_details['rating_type'] === 'stars' &&
                               $stream_details['video_rating'] == 1)
                            <span class="content_screen themePrimaryTxtColr">
                                <div class="star active" style="display: inline-flex;">
                                    <svg fill="#ffffff" width="10px" height="10px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>star</title>
                                            <path
                                                d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                {{ $ratingsCount ?? 0 }}
                            </span>
                        @elseif(isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                $stream_details['rating_type'] === 'hearts' &&
                               $stream_details['video_rating'] == 1)
                            <span class="content_screen themePrimaryTxtColr">
                                <div class="star active" style="display: inline-flex;">
                                    <svg fill="#ffffff" width="10px" height="10px" viewBox="0 0 32 32"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>heart</title>
                                            <path
                                                d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                {{ $ratingsCount ?? 0 }}
                            </span>
                        @elseif(isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                $stream_details['rating_type'] === 'thumbs' &&
                                $stream_details['video_rating'] == 1)
                            <span class="content_screen themePrimaryTxtColr">
                                <div class="star active" style="display: inline-flex; rotate: 180deg">
                                    <svg fill="#6e6e6e" width="10px" height="10px" version="1.1" id="Capa_1"
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
                                </div>
                                {{ $ratingsCount ?? 0 }}
                            </span>
                        @else
                            {{-- Thumbs  --}}
                            <span class="content_screen themePrimaryTxtColr">
                                <div class="star active" style="display: inline-flex; rotate: 180deg">
                                    <svg fill="#6e6e6e" width="10px" height="10px" version="1.1" id="Capa_1"
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
                                </div>
                                {{ $ratingsCount ?? 0 }}
                            </span>
                        @endif
                    @endif
                    @if ($stream_details['content_qlt'] != '')
                        <span class="content_screen themePrimaryTxtColr"
                            style=" border: 1px var(--themePrimaryTxtColor) solid !important; ">
                            @php
                                $content_qlt_arr = explode(',', $stream_details['content_qlt']);
                                $content_qlt_codes_arr = explode(',', $stream_details['content_qlt_codes']);
                            @endphp
                            @foreach ($content_qlt_arr as $i => $item)
                                <a style=" color: var(--themePrimaryTxtColor) !important;"
                                    href="{{ route('quality', trim($content_qlt_codes_arr[$i])) }}">{{ $item }}</a>
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </span>
                    @endif
                    @if ($stream_details['content_rating'] != '')
                        <span class="content_screen themePrimaryTxtColr"
                            style=" border: 1px var(--themePrimaryTxtColor) solid !important; ">
                            @php
                                $content_rating_arr = explode(',', $stream_details['content_rating']);
                                $content_rating_codes_arr = explode(',', $stream_details['content_rating_codes']);
                            @endphp
                            @foreach ($content_rating_arr as $i => $item)
                                <a style="color: var(--themePrimaryTxtColor) !important;"
                                    href="{{ route('rating', trim($content_rating_codes_arr[$i])) }}">{{ $item }}</a>
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </span>
                    @endif
                </div>

                <div class="about-movie aboutmovie_gaps mt-1 themePrimaryTxtColr">
                    {{ $stream_details['stream_description'] }}</div>
                <dl class="movies_listview mb-3">
                    <dl>
                        @if (isset($stream_details['cast']) || isset($stream_details['director']) || isset($stream_details['writer']))
                            @if ($stream_details['cast'])
                                <div class="content-person themePrimaryTxtColr">
                                    <dt class="themePrimaryTxtColr">Cast:</dt>
                                    <dd class="themePrimaryTxtColr">
                                        {{ $stream_details['cast'] }}
                                    </dd>
                                </div>
                            @endif
                            @if ($stream_details['director'])
                                <div class="content-person">
                                    <dt class="themePrimaryTxtColr">Director:</dt>
                                    <dd class="themePrimaryTxtColr">
                                        {{ $stream_details['director'] }}
                                    </dd>
                                </div>
                            @endif
                            @if ($stream_details['writer'])
                                <div class="content-person">
                                    <dt class="themePrimaryTxtColr">Writer:</dt>
                                    <dd class="themePrimaryTxtColr">
                                        {{ $stream_details['writer'] }}
                                    </dd>
                                </div>
                            @endif
                        @else
                            @foreach ($stream_details['starring_data'] as $roleKey => $persons)
                                @if (!empty($persons))
                                    <div class="content-person themePrimaryTxtColr">
                                        <dt class="themePrimaryTxtColr">{{ $roleKey }}:</dt>
                                        <dd class="themePrimaryTxtColr">
                                            @php
                                                if (!is_array($persons)) {
                                                    $persons = explode(',', $persons);
                                                }
                                            @endphp

                                            @foreach ($persons as $i => $person)
                                                @if (is_array($person))
                                                    <a class="person-link themePrimaryTxtColr"
                                                        href="{{ route('person', $person['id']) }}">{{ $person['title'] }}</a>
                                                    @if (!$loop->last)
                                                        <span class="test-comma themePrimaryTxtColr">, </span>
                                                    @endif
                                                @else
                                                    <a class="person-link themePrimaryTxtColr"
                                                        href="{{ route('person', $person) }}">{{ $person }}</a>
                                                    @if (!$loop->last)
                                                        <span class="test-comma themePrimaryTxtColr">, </span>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </dd>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        @if (!empty($stream_details['advisories']))
                            <div class="content-person themePrimaryTxtColr">
                                <dt class="themePrimaryTxtColr">Advisory: </dt>
                                <dd class="themePrimaryTxtColr">
                                    @foreach ($stream_details['advisories'] as $i => $val)
                                        <a class="person-link themePrimaryTxtColr"
                                            href="{{ route('advisory', $val['code']) }}">{{ $val['title'] }}</a>
                                        @if (count($stream_details['advisories']) - 1 !== $i)
                                            <span class="test-comma themePrimaryTxtColr">, </span>
                                        @endif
                                    @endforeach
                                </dd>
                            </div>
                        @endif

                        @if (!empty($stream_details['languages']))
                            <div class="content-person">
                                <dt class="themePrimaryTxtColr">Language: </dt>
                                <dd class="themePrimaryTxtColr">
                                    @foreach ($stream_details['languages'] as $i => $val)
                                        <a class="person-link themePrimaryTxtColr"
                                            href="{{ route('language', $val['code']) }}">{{ $val['title'] }}</a>
                                        @if (count($stream_details['languages']) - 1 !== $i)
                                            <span class="test-comma themePrimaryTxtColr">, </span>
                                        @endif
                                    @endforeach
                                </dd>
                            </div>
                        @endif
                        @if (!empty($stream_details['tags']))
                            <div class="content-person">
                                <dt class="themePrimaryTxtColr">Tags: </dt>
                                <dd class="themePrimaryTxtColr">
                                    @foreach ($stream_details['tags'] as $i => $val)
                                        <a class="person-link themePrimaryTxtColr"
                                            href="{{ route('tag', $val['code']) }}">{{ $val['title'] }}</a>
                                        @if (count($stream_details['tags']) - 1 !== $i)
                                            <span class="test-comma themePrimaryTxtColr">, </span>
                                        @endif
                                    @endforeach
                                </dd>
                            </div>
                        @endif
                    </dl>
                </dl>
            </div>
        </div>
          <div data-tab-content="like" class="content d-none">
            <div class="like-tab-slider-mobile-container" data-stream-guid="{{ $stream_details['stream_guid'] ?? '' }}">
                @include('detailscreen.partials.skeleton-slider')
            </div>
        </div>
        @if (
            (isset($stream_details['video_rating']) && $stream_details['video_rating'] == 1))
            <div data-tab-content="reviews" class="content d-none"><!--Start of Ratings section-->
                <div class="item-ratings">
                    <h1 class="section-title" style="display: flex; align-items: center; gap: 10px;">
                        Reviews:
                        <div id="rating-icon">
                            @include('detailscreen.partials.rating-icon', [
                                'ratingsCount' => $ratingsCount,
                            ])
                        </div>
                        <span class="average-rating">{{ $averageRating ?? '' }} </span>
                    </h1>
                    <p class="text-white no-reviews-message-mobile"
                        style="margin-bottom: -8px !important; {{ sizeof($stream_details['ratings'] ?? []) > 0 ? 'display: none;' : '' }}">
                        No reviews found.
                    </p>
                    @php
                        // Ensure $stream_details is an array before checking 'ratings'
                        $ratings =
                            !empty($stream_details) &&
                            is_array($stream_details) &&
                            isset($stream_details['ratings']) &&
                            is_array($stream_details['ratings'])
                                ? $stream_details['ratings']
                                : [];

                        if (count($ratings) < 1) {
                            echo '<p class="text-white" style="margin-bottom: -8px !important;">No reviews found.</p>';
                        }

                        $userDidComment = false;
                        foreach ($ratings as $rating) {
                            if (
                                session()->has('USER_DETAILS') &&
                                isset($rating['user']['id']) &&
                                $rating['user']['id'] == session('USER_DETAILS')['USER_ID']
                            ) {
                                $userDidComment = true;
                                break; // Stop loop early if found
                            }
                        }
                    @endphp
                    {{--  @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !$userDidComment && !$userDidComment)  --}}
                    @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null)
                        {{-- Stars  --}}
                        @if (isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                $stream_details['rating_type'] === 'stars' &&
                                $stream_details['video_rating'] == 1)
                            <div class="review-rating user-rating-mobile">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="star-mobile" data-rating-mobile="{{ $i }}"
                                        onclick="handleStarRatingMobile(this)">
                                        <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                            version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <title>star</title>
                                                <path
                                                    d="M3.488 13.184l6.272 6.112-1.472 8.608 7.712-4.064 7.712 4.064-1.472-8.608 6.272-6.112-8.64-1.248-3.872-7.808-3.872 7.808z">
                                                </path>
                                            </g>
                                        </svg>
                                    </div>
                                @endfor
                            </div>
                        @elseif(isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                $stream_details['rating_type'] === 'hearts' &&
                                $stream_details['video_rating'] == 1)
                            {{-- Hearts  --}}
                            <div class="review-rating user-rating-mobile">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="star-mobile" data-rating-mobile="{{ $i }}"
                                        onclick="handleStarRatingMobile(this)">
                                        <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
                                            version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#545454">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <title>heart</title>
                                                <path
                                                    d="M0.256 12.16q0.544 2.080 2.080 3.616l13.664 14.144 13.664-14.144q1.536-1.536 2.080-3.616t0-4.128-2.080-3.584-3.584-2.080-4.16 0-3.584 2.080l-2.336 2.816-2.336-2.816q-1.536-1.536-3.584-2.080t-4.128 0-3.616 2.080-2.080 3.584 0 4.128z">
                                                </path>
                                            </g>
                                        </svg>
                                    </div>
                                @endfor
                            </div>
                        @elseif(isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                $stream_details['rating_type'] === 'thumbs' &&
                                $stream_details['video_rating'] == 1)
                            {{-- Thumbs  --}}
                            <div class="review-rating user-rating-mobile">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="star-mobile" data-rating-mobile="{{ $i }}"
                                        style="rotate: 180deg" onclick="handleStarRatingMobile(this)">
                                        <svg fill="#6e6e6e" height="27px" width="27px" version="1.1"
                                            id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 208.666 208.666"
                                            xml:space="preserve" stroke="#6e6e6e">
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
                                @endfor
                            </div>
                        @else
                            {{-- Thumbs  --}}
                            <div class="review-rating user-rating-mobile">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="star-mobile" data-rating-mobile="{{ $i }}"
                                        style="rotate: 180deg" onclick="handleStarRatingMobile(this)">
                                        <svg fill="#6e6e6e" height="27px" width="27px" version="1.1"
                                            id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 208.666 208.666"
                                            xml:space="preserve" stroke="#6e6e6e">
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
                                @endfor
                            </div>
                        @endif

                        <span class="text-danger">
                            @error('rating')
                                {{ $message }}
                            @enderror
                        </span>
                        <div id="mobileMessageContainer" style="display: none;"></div>
                        <form id="reviewForm" action="{{ route('addrating') }}" method="POST">
                            @csrf
                            <textarea name="comment" cols="30" rows="10" placeholder="Let others know what you think..."></textarea>
                            <input type="hidden" name="rating_mobile" id="hiddenRatingMobile">
                            <input type="hidden" name="stream_code" value="{{ $stream_details['stream_guid'] }}">
                            <input type="hidden" name="type" value="stream">
                            <style>
                                #submitButton {
                                    background-color: var(--themeActiveColor);
                                    border: 0;
                                    margin-top: 18px;
                                    color: #fff;
                                    padding: 9px 19px;
                                    border-radius: 2px;
                                }
                            </style>
                            <button class="rounded" type="submit" id="submitButton">
                                <span class="button-text">Submit</span>
                                <span class="spinner-border spinner-border-sm" style="display: none;" role="status"
                                    aria-hidden="true"></span>
                            </button>
                        </form>
                        <hr>
                    @endif

                    <div
                        class="member-reviews {{ !session('USER_DETAILS') || !session('USER_DETAILS')['USER_CODE'] || $userDidComment ? 'mt-4' : '' }}">
                        @include('detailscreen.partials.review', ['reviews' => $stream_details['ratings']])
                    </div>
                </div>
            </div>

        @endif

    </div>
</div>
