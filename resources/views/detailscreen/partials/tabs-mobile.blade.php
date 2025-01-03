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

</div>
<div class="my-tabs">
    <div class="sec-device content-wrapper px-3 px-md-3">
        <div class="tab-btns d-flex gap-3 gap-sm-3 gap-md-4 gap-lg-5">
            <div class="tab mobile-data active" data-tab="overview"><span>Overview</span></div>
            <!-- Start of season section -->
            <?php
            $arrSeasonData = isset($seasons) ? $seasons['streams'] : null;
            
            if (!empty($arrSeasonData)) {
                // Display the Season tab if data is available
                echo '<div class="tab" data-tab="like"><span>Season</span></div>';
            } else {
                // Display the "You Might Also Like" tab if no season data is available
                echo '<div class="tab" data-tab="like"><span>You Might Also Like</span></div>';
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

                    
                    @if($ratingsCount > 0)
                    @if (isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                            $stream_details['rating_type'] === 'stars' &&
                            $stream_details['video_rating'] === 'E')
                        <span class="content_screen themePrimaryTxtColr">
                            <div class="star active" style="display: inline-flex;">
                                <svg fill="#ffffff" width="10px" height="10px" viewBox="0 0 32 32"
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
                            {{ $ratingsCount ?? 0 }}
                        </span>
                    @elseif(isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                            $stream_details['rating_type'] === 'hearts' &&
                            $stream_details['video_rating'] === 'E')
                        <span class="content_screen themePrimaryTxtColr">
                            <div class="star active" style="display: inline-flex;">
                                <svg fill="#ffffff" width="10px" height="10px" viewBox="0 0 32 32"
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
                            {{ $ratingsCount ?? 0 }}
                        </span>
                    @elseif(isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                            $stream_details['rating_type'] === 'thumbs' &&
                            $stream_details['video_rating'] === 'E')
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
                    @elseif (isset(
                            \App\Services\AppConfig::get()->app->app_info->global_rating_enable,
                            \App\Services\AppConfig::get()->app->app_info->global_rating_type) &&
                            \App\Services\AppConfig::get()->app->app_info->global_rating_enable == 1 &&
                            \App\Services\AppConfig::get()->app->app_info->global_rating_type === 'stars')
                        <span class="content_screen themePrimaryTxtColr">
                            <div class="star active" style="display: inline-flex;">
                                <svg fill="#ffffff" width="10px" height="10px" viewBox="0 0 32 32"
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
                            {{ $ratingsCount ?? 0 }}
                        </span>
                    @elseif (isset(
                            \App\Services\AppConfig::get()->app->app_info->global_rating_enable,
                            \App\Services\AppConfig::get()->app->app_info->global_rating_type) &&
                            \App\Services\AppConfig::get()->app->app_info->global_rating_enable == 1 &&
                            \App\Services\AppConfig::get()->app->app_info->global_rating_type === 'hearts')
                        <span class="content_screen themePrimaryTxtColr">
                            <div class="star active" style="display: inline-flex;">
                                <svg fill="#ffffff" width="10px" height="10px" viewBox="0 0 32 32"
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
                                <h1 class="content-heading">{{ $latest_items['title'] }}</h1>
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
        </div>
        @if (
            (isset($stream_details['video_rating']) && $stream_details['video_rating'] === 'E') ||
                (isset(\App\Services\AppConfig::get()->app->app_info->global_rating_enable) &&
                    \App\Services\AppConfig::get()->app->app_info->global_rating_enable == 1))
            <div data-tab-content="reviews" class="content d-none"><!--Start of Ratings section-->
                <div class="item-ratings">
                    <h1 class="section-title" style="display: flex; align-items: center; gap: 10px;">
                        Reviews:
                        @if($ratingsCount > 0)
                        @if (isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                $stream_details['rating_type'] === 'stars' &&
                                $stream_details['video_rating'] === 'E')
                            <div class="star active" style="display: inline-flex;">
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
                        @elseif(isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                $stream_details['rating_type'] === 'hearts' &&
                                $stream_details['video_rating'] === 'E')
                            <div class="star active" style="display: inline-flex;">
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
                        @elseif(isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                $stream_details['rating_type'] === 'thumbs' &&
                                $stream_details['video_rating'] === 'E')
                            <div class="star active" style="display: inline-flex; rotate: 180deg">
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
                            </div>
                        @elseif (isset(
                                \App\Services\AppConfig::get()->app->app_info->global_rating_enable,
                                \App\Services\AppConfig::get()->app->app_info->global_rating_type) &&
                                \App\Services\AppConfig::get()->app->app_info->global_rating_enable == 1 &&
                                \App\Services\AppConfig::get()->app->app_info->global_rating_type === 'stars')
                            <div class="star active" style="display: inline-flex;">
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
                        @elseif (isset(
                                \App\Services\AppConfig::get()->app->app_info->global_rating_enable,
                                \App\Services\AppConfig::get()->app->app_info->global_rating_type) &&
                                \App\Services\AppConfig::get()->app->app_info->global_rating_enable == 1 &&
                                \App\Services\AppConfig::get()->app->app_info->global_rating_type === 'hearts')
                            <div class="star active" style="display: inline-flex;">
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
                        @else
                            {{-- Thumbs  --}}
                            <div class="star active" style="display: inline-flex; rotate: 180deg">
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
                            </div>
                        @endif

                        {{ $ratingsCount ?? 0 }}
                        @endif
                    </h1>
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
                    {{--  @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !$userDidComment && !$userDidComment)  --}}
                    @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null)
                        {{-- Stars  --}}
                        @if (isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                $stream_details['rating_type'] === 'stars' &&
                                $stream_details['video_rating'] === 'E')
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
                                $stream_details['video_rating'] === 'E')
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
                                $stream_details['video_rating'] === 'E')
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
                        @elseif (isset(
                                \App\Services\AppConfig::get()->app->app_info->global_rating_enable,
                                \App\Services\AppConfig::get()->app->app_info->global_rating_type) &&
                                \App\Services\AppConfig::get()->app->app_info->global_rating_enable == 1 &&
                                \App\Services\AppConfig::get()->app->app_info->global_rating_type === 'stars')
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
                        @elseif (isset(
                                \App\Services\AppConfig::get()->app->app_info->global_rating_enable,
                                \App\Services\AppConfig::get()->app->app_info->global_rating_type) &&
                                \App\Services\AppConfig::get()->app->app_info->global_rating_enable == 1 &&
                                \App\Services\AppConfig::get()->app->app_info->global_rating_type === 'hearts')
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
                        <form action="{{ route('addrating') }}" method="POST" onsubmit="return submitOnceMobile()">
                            @csrf
                            <textarea name="comment" cols="30" rows="10" placeholder="Let others know what you think..."></textarea>
                            <input type="hidden" name="rating_mobile" id="hiddenRatingMobile">
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
                    if(isset($review['profile_name']) && $review['profile_name'] ){
                        $name = $review['profile_name'];
                    }else{
                        $name = $review['user']['name'];
                    }
                    $name_arr = explode(' ', $name);
                    $name_symbol = '';

                    $name_symbol .= $name_arr[0][0];

                    if (sizeof($name_arr) > 1)
                        $name_symbol .= $name_arr[1][0];

                    ?>

                        <div class="review">
                            <div class="user">
                                <div class="profile-name"><?= $name_symbol ?></div>
                                @if (isset($review['profile_name']) && $review['profile_name'])
                                    <h4 class="username mb-0"><?= $review['profile_name'] ?></h4>
                                @else
                                    <h4 class="username mb-0"><?= $review['user']['name'] ?></h4>
                                @endif
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
                                    <div class="user-rating-mobile"
                                        style="margin-top: 8px; display: flex; gap: 12px;">
                                        @if ($review['rating'] >= 3)
                                            @for ($i = 0; $i < $review['rating']; $i++)
                                                <div class="star active" style="rotate: 180deg">
                                                    <svg fill="#6e6e6e" height="27px" width="27px" version="1.1"
                                                        id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        viewBox="0 0 208.666 208.666" xml:space="preserve"
                                                        stroke="#6e6e6e">
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
                                        @else
                                            @for ($i = 0; $i < $review['rating']; $i++)
                                                <div class="star active">
                                                    <svg fill="#6e6e6e" height="27px" width="27px" version="1.1"
                                                        id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        viewBox="0 0 208.666 208.666" xml:space="preserve"
                                                        stroke="#6e6e6e">
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
                                    <div class="user-rating-mobile"
                                        style="margin-top: 8px; display: flex; gap: 12px;">
                                        @if ($review['rating'] >= 3)
                                            @for ($i = 0; $i < $review['rating']; $i++)
                                                <div class="star active" style="rotate: 180deg">
                                                    <svg fill="#6e6e6e" height="27px" width="27px" version="1.1"
                                                        id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        viewBox="0 0 208.666 208.666" xml:space="preserve"
                                                        stroke="#6e6e6e">
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
                                        @else
                                            @for ($i = 0; $i < $review['rating']; $i++)
                                                <div class="star active">
                                                    <svg fill="#6e6e6e" height="27px" width="27px" version="1.1"
                                                        id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        viewBox="0 0 208.666 208.666" xml:space="preserve"
                                                        stroke="#6e6e6e">
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
