<div class="my-tabs">
    <div class="sec-device content-wrapper px-2 px-md-3">
        <div class="tab-btns d-flex gap-3 gap-sm-3 gap-md-4 gap-lg-5">

            <!-- Start of season section -->
            {{--  <?php
            $arrSeasonData = isset($seasons) ? $seasons['streams'] : null;
            
            if (!empty($arrSeasonData)) {
                // Display the Season tab if data is available
                echo '<div class="tab active" data-tab="like"><span>Season</span></div>';
            } else {
                // Display the "You Might Also Like" tab if no season data is available
                echo '<div class="tab active" data-tab="like"><span>You Might Also Like</span></div>';
            }
            ?>  --}}
            @if ($latest_items['title'])
                <div class="tab active" data-tab="like"><span>{{ $latest_items['title'] }}</span></div>
            @endif
            <!--End of season section-->
            @if (isset($stream_details['video_rating']) && $stream_details['video_rating'] == 1)
                <div class="tab" data-tab="reviews"><span>Reviews</span></div>
            @endif
        </div>
    </div>

    <div class="tab-content">
        <div data-tab-content="like" class="content">
            <div class="like-tab-slider-container" data-stream-guid="{{ $stream_details['stream_guid'] ?? '' }}">
                @include('detailscreen.partials.skeleton-slider')
            </div>
        </div>
        @if (isset($stream_details['video_rating']) && $stream_details['video_rating'] == 1)
            <div data-tab-content="reviews" class="content d-none"><!--Start of Ratings section-->
                <div class="item-ratings">
                    <h1 class="section-title" style="display: flex; align-items: center; gap: 10px;">
                        Reviews:
                        <div class="rating"></div>
                        <div id="rating-icon-mobile">
                            @include('detailscreen.partials.rating-icon', [
                                'ratingsCount' => $ratingsCount,
                            ])
                        </div>
                        <span class="average-rating">{{ $averageRating ?? '' }} </span>
                    </h1>

                    <p class="text-white no-reviews-message"
                        style="margin-bottom: -8px !important; {{ !empty($stream_details['ratings']) && is_array($stream_details['ratings']) ? 'display: none;' : '' }}">
                        No reviews found.
                    </p>

                    @php
                        $userDidComment = false;
                        if (
                            !empty($stream_details) &&
                            is_array($stream_details) &&
                            !empty($stream_details['ratings']) &&
                            is_array($stream_details['ratings'])
                        ) {
                            foreach ($stream_details['ratings'] as $rating) {
                                if (
                                    session()->has('USER_DETAILS') &&
                                    isset($rating['user']['id']) &&
                                    $rating['user']['id'] == session('USER_DETAILS')['USER_ID']
                                ) {
                                    $userDidComment = true;
                                    break; // Exit loop early if found
                                }
                            }
                        }
                    @endphp
                    {{--  @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !$userDidComment && !$userDidComment)  --}}

                    @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null)
                        {{-- Stars  --}}
                        @if (isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                $stream_details['rating_type'] === 'stars' &&
                                $stream_details['video_rating'] == 1)
                            <div class="review-rating user-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="star" data-rating="{{ $i }}"
                                        onclick="handleStarRating(this)">
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
                            </div>
                        @elseif(isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                $stream_details['rating_type'] === 'hearts' &&
                                $stream_details['video_rating'] == 1)
                            {{-- Hearts  --}}
                            <div class="review-rating user-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="star" data-rating="{{ $i }}"
                                        onclick="handleStarRating(this)">
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
                            </div>
                        @elseif(isset($stream_details['rating_type'], $stream_details['video_rating']) &&
                                $stream_details['rating_type'] === 'thumbs' &&
                                $stream_details['video_rating'] == 1)
                            {{-- Thumbs  --}}
                            <div class="review-rating user-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="star" data-rating="{{ $i }}" style="rotate: 180deg"
                                        onclick="handleStarRating(this)">
                                        <svg fill="#6e6e6e" height="27px" width="27px" version="1.1" id="Capa_1"
                                            xmlns="http://www.w3.org/2000/svg"
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
                            <div class="review-rating user-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="star" data-rating="{{ $i }}" style="rotate: 180deg"
                                        onclick="handleStarRating(this)">
                                        <svg fill="#6e6e6e" height="27px" width="27px" version="1.1" id="Capa_1"
                                            xmlns="http://www.w3.org/2000/svg"
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
                        <div id="desktopMessageContainer" style="display: none;"></div>
                        <form id="reviewForm" action="{{ route('addrating') }}" method="POST">
                            @csrf
                            <textarea name="comment" cols="30" rows="10" placeholder="Let others know what you think..."></textarea>
                            <input type="hidden" name="rating" id="hiddenRating">
                            <input type="hidden" name="stream_code" value="{{ $stream_details['stream_guid'] }}">
                            <input type="hidden" name="type" value="stream">

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
