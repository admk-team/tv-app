                        <?php
                         if(isset($reviews) && !empty($reviews)){
                foreach ($reviews as $review) {
                    $name = $review['profile_name'] ?? ($review['user']['name'] ?? '');
$name_arr = array_filter(explode(' ', trim($name))); // Filter empty elements
$name_symbol = '';

if (isset($name_arr[0]) && strlen($name_arr[0]) > 0) {
    $name_symbol .= mb_substr($name_arr[0], 0, 1); // Use mb_substr for multibyte characters
}

if (isset($name_arr[1]) && strlen($name_arr[1]) > 0) {
    $name_symbol .= mb_substr($name_arr[1], 0, 1);
}

                    ?>

                        <div class="review">
                            <div class="user">
                                <div class="profile-name"><?= $name_symbol ?></div>
                                @if ($review['profile_name'])
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
                                    <div class="user-rating" style="margin-top: 10px; display: flex; gap: 12px;">
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
                                    <div class="user-rating" style="margin-top: 10px; display: flex; gap: 12px;">
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
            }
            ?>
