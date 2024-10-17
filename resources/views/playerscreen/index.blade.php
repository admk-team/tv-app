@extends('layouts.app')
@section('head')
    {{-- Custom Css --}}

    <!-- Include Video.js Library -->
    <link rel="stylesheet" href="{{ asset('assets/css/details-screen-styling.css') }}">
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
@endsection
@section('content')
    <?php
    // Config
    $IS_SIGNIN_BYPASS = 'N';
    define('VIDEO_DUR_MNG_BASE_URL', env('API_BASE_URL') . '/mngstrmdur');
    // Config End

    session('GLOBAL_PASS', 0);
    request()->server('REQUEST_METHOD');
    $protocol = request()->server('HTTPS') === 'on' ? 'https' : 'http';
    $host = request()->server('HTTP_HOST');
    $url = request()->server('REQUEST_URI');
    $fullUrl = $protocol . '://' . $host . $url;
    $shortUrl = null;
    $queryString = parse_url($url, PHP_URL_QUERY);
    if ($queryString !== null) {
        $globalPass = substr($queryString, 0);
        if ($globalPass !== null) {
            $shortUrl = $protocol . '://' . $host . strtok($url, '?');
            session('GLOBAL_PASS', 1);
        }
    }
    $ARR_FEED_DATA = \App\Helpers\GeneralHelper::parseDetailPgFeedArrData(0, $arrRes);
    $arrSlctItemData = $ARR_FEED_DATA['arrSelectedItemData'];
    $streamType = $arrSlctItemData['stream_type'];
    $streamUrl = $arrSlctItemData['stream_url'];
    $adParam = 'videoId=' . $streamGuid . '&title=' . $arrSlctItemData['stream_title'];
    // Login requried
    if ($IS_SIGNIN_BYPASS == 'N' && (!session('USER_DETAILS') || session('USER_DETAILS')['USER_CODE']) && false) {
        session('IS_SIGNIN_BYPASS', url('/playerscreen/' . $streamGuid));
        \App\Helpers\GeneralHelper::headerRedirect(url('/signin'));
    }

    //monetioztion
    $redirectUrl = null;
    if ($limitWatchTime === 'yes' && (!session('USER_DETAILS') || !session('USER_DETAILS')['USER_CODE'])) {
        session(['REDIRECT_TO_SCREEN' => route('playerscreen', $streamGuid)]);
        session()->save();
        $redirectUrl = route('login');
    }

    $sharingURL = route('playerscreen', $streamGuid);
    $isBuyed = $arrSlctItemData['is_buyed'];
    $monetizationType = $arrSlctItemData['monetization_type'];
    if ($monetizationType != 'F' && $isBuyed == 'N' && !$redirectUrl) {
        session()->forget('coupon_applied'); // Remove old
        session(['REDIRECT_TO_SCREEN' => route('playerscreen', $streamGuid)]);
        if ($limitWatchTime === 'no' && (!session('USER_DETAILS') || !session('USER_DETAILS')['USER_CODE'])) {
            session(['REDIRECT_TO_SCREEN' => route('playerscreen', $streamGuid)]);
            session()->save();
            \Illuminate\Support\Facades\Redirect::to(route('login'))->send();
        } elseif ($monetizationType == 'S') {
            $sArr['REQUEST_FROM'] = 'player';
            session(['MONETIZATION' => $sArr]);
            session()->save();
            \Illuminate\Support\Facades\Redirect::to(route('subscription'))->send();
        } else {
            $suffix = '';
            if ((int) $arrSlctItemData['planFaq'] > 1) {
                $suffix = 's';
            }
            $sArr['MONETIZATION_GUID'] = $arrSlctItemData['monetization_guid'];
            $sArr['MONETIZATION_TYPE'] = $monetizationType;
            $sArr['SUBS_TYPE'] = $monetizationType;
            $sArr['PAYMENT_INFORMATION'] = $arrSlctItemData['stream_title'];
            $sArr['STREAM_DESC'] = $arrSlctItemData['stream_description'];
            $sArr['PLAN'] = $arrSlctItemData['planFaq'] . ' ' . $arrSlctItemData['plan_period'] . $suffix;
            $sArr['AMOUNT'] = $arrSlctItemData['amount'];
            $sArr['POSTER'] = $arrSlctItemData['stream_poster'];
            session(['MONETIZATION' => $sArr]);
            session()->save();
            \Illuminate\Support\Facades\Redirect::to(route('monetization'))->send();
        }
    }

    // Check if subscription is required for all content and is not subscribed
    if (\App\Helpers\GeneralHelper::subscriptionIsRequired() && $isBuyed == 'N') {
        if ($limitWatchTime === 'no' && (!session('USER_DETAILS') || !session('USER_DETAILS')['USER_CODE'])) {
            session(['REDIRECT_TO_SCREEN' => route('playerscreen', $streamGuid)]);
            session()->save();
            \Illuminate\Support\Facades\Redirect::to(route('login'))->send();
        } elseif (session('USER_DETAILS') && isset(session('USER_DETAILS')['USER_CODE'])) {
            session(['REDIRECT_TO_SCREEN' => route('playerscreen', $streamGuid)]);
            session()->save();
            \Illuminate\Support\Facades\Redirect::to(route('subscription'))->send();
        }
    }

    $mType = 'video';
    if (strpos($streamUrl, '.m3u8')) {
        $mType = 'hls';
    }
    $apiPath = App\Services\Api::endpoint('/mngstrmdur');
    $strQueryParm = "streamGuid=$streamGuid&userCode=" . @session('USER_DETAILS')['USER_CODE'] . '&frmToken=' . session('SESSION_TOKEN') . '&userProfileId=' . session('USER_DETAILS.USER_PROFILE');

    // dd(session('USER_DETAILS.USER_PROFILE'));
    // here get the video duration
    $seekFunStr = '';
    $arrFormData4VideoState = [];
    $arrFormData4VideoState['streamGuid'] = $streamGuid;
    //$arrFormData4VideoState['streamDuration'] = "50";
    $arrFormData4VideoState['requestAction'] = 'getStrmDur';
    $arrRes4VideoState = \App\Helpers\GeneralHelper::sendCURLRequest(0, VIDEO_DUR_MNG_BASE_URL, $arrFormData4VideoState);
    //print_r($arrRes4VideoState);
    $stillwatching = \App\Services\AppConfig::get()->app->app_info->still_watching;
    $is_embed = \App\Services\AppConfig::get()->app->is_embed ?? null;
    $playerstillwatchduration = \App\Services\AppConfig::get()->app->app_info->still_watching_duration;
    $status = $arrRes4VideoState['app']['status'];
    if ($status == 1) {
        $streamDurationInSec = $arrRes4VideoState['app']['data']['stream_duration'];
        $seekFunStr = "this.currentTime($streamDurationInSec);";
    }

    // Here Set Ad URL in Session
    $adUrl = \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_site_ad_url;
    if (!session('ADS_INFO')) {
        session([
            'ADS_INFO' => [
                'adUrl' => \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_site_ad_url,
                'channelName' => \App\Services\AppConfig::get()->app->app_info->app_name,
                'domain_name' => \App\Services\AppConfig::get()->app->colors_assets_for_branding->domain_name,
            ],
        ]);
    }

    $useragent = request()->server('HTTP_USER_AGENT');
    $isMobileBrowser = 0;
    if (
        preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) ||
        preg_match(
            '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',
            substr($useragent, 0, 4),
        )
    ) {
        $isMobileBrowser = 1;
    }
    $isMobileBrowser = 0;
    //$dataVast = 'data-vast="' . url('/get-ad?' . $adParam) . '"';
    $cb = time();
    $userAgent = urlencode(request()->server('HTTP_USER_AGENT'));
    $userIP = \App\Helpers\GeneralHelper::getRealIpAddr();
    $channelName = urlencode(\App\Services\AppConfig::get()->app->app_info->app_name);

    $isLocalHost = false;
    $host = parse_url(url()->current())['host'];
    if (in_array($host, ['localhost', '127.0.0.1'])) {
        $isLocalHost = true;
    }

    //&app_bundle=669112
    //
    $appStoreUrl = urlencode(\App\Services\AppConfig::get()->app->colors_assets_for_branding->roku_app_store_url);
    if (parse_url($adUrl, PHP_URL_QUERY)) {
        $adMacros = $adUrl . "&width=1920&height=1080&cb=$cb&" . (!$isLocalHost ? "uip=$userIP&" : '') . "device_id=RIDA&vast_version=2&app_name=$channelName&device_make=ROKU&device_category=5&app_store_url=$appStoreUrl&ua=$userAgent";
    } else {
        $adMacros = $adUrl . "?width=1920&height=1080&cb=$cb&" . (!$isLocalHost ? "uip=$userIP&" : '') . "device_id=RIDA&vast_version=2&app_name=$channelName&device_make=ROKU&device_category=5&app_store_url=$appStoreUrl&ua=$userAgent";
    }
    $adMacros .= "&duration={$arrSlctItemData['stream_duration_second']}&app_code=" . env('APP_CODE') . '&user_code=' . session('USER_DETAILS.USER_CODE') . '&stream_code=' . $streamGuid;
    $dataVast = "data-vast='$adMacros'";

    if ($isMobileBrowser == 1 || $adUrl == '') {
        $dataVast = '';
    }

    $stream_ad_url = $arrSlctItemData['stream_ad_url'];
    if (parse_url($stream_ad_url, PHP_URL_QUERY)) {
        $stream_ad_url = $stream_ad_url . "&duration={$arrSlctItemData['stream_duration_second']}&app_code=" . env('APP_CODE') . '&user_code=' . session('USER_DETAILS.USER_CODE') . '&stream_code=' . $streamGuid;
    } else {
        $stream_ad_url = $stream_ad_url . "?duration={$arrSlctItemData['stream_duration_second']}&app_code=" . env('APP_CODE') . '&user_code=' . session('USER_DETAILS.USER_CODE') . '&stream_code=' . $streamGuid;
    }
    $dataVast2 = $arrSlctItemData['stream_ad_url'] ? 'data-vast="' . $stream_ad_url . '"' : null;

    if (!$arrSlctItemData['has_global_ads']) {
        $dataVast = '';
    }

    if (!$arrSlctItemData['has_individual_ads']) {
        $dataVast2 = '';
    }

    if (!$arrSlctItemData['has_ads']) {
        $dataVast = '';
        $dataVast2 = '';
    }

    $watermark = $arrSlctItemData['watermark'] ?? null;

    ?>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mvp.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <script src="{{ asset('assets/js/new.js') }}"></script>
    <script src="{{ asset('assets/js/vast.js') }}"></script>
    <script src="{{ asset('assets/js/share_manager.js') }}"></script>
    <script src="{{ asset('assets/js/cache.js') }}"></script>
    <script src="{{ asset('assets/js/ima.js') }}"></script>
    <script src="{{ asset('assets/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/playlist_navigation.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function detectMob() {
            const toMatch = [
                /Android/i,
                /webOS/i,
                /iPhone/i,
                /iPad/i,
                /iPod/i,
                /BlackBerry/i,
                /Windows Phone/i
            ];

            return toMatch.some((toMatchItem) => {
                return navigator.userAgent.match(toMatchItem);
            });
        }
        //alert(detectMob());
    </script>

    <style>
        .loader {
            width: 18px;
            height: 18px;
            border: 2px solid #FFF;
            border-bottom-color: transparent;
            border-radius: 50%;
            display: inline-block;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .videocentalize {
            position: relative;
        }

        .watermark {
            position: absolute;
            z-index: 100;
            user-select: none;
        }

        .live-video {
            position: absolute;
            z-index: 500;
            user-select: none;
        }

        .live-video {
            position: absolute;
            z-index: 500;
            user-select: none;
        }

        .watermark.center {
            right: 0;
            width: fit-content;
            left: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            height: fit-content;
        }

        .watermark.top-left {
            top: 1em;
            width: fit-content;
            left: 1em;
        }

        .watermark.top-center {
            top: 1em;
            width: fit-content;
            margin: auto;
            left: 0;
            right: 0;
        }

        .watermark.top-right {
            top: 1em;
            width: fit-content;
            right: 1em;
        }

        .live-video.top-right {
            top: 1em;
            width: fit-content;
            right: 1em;
        }

        .watermark.bottom-center {
            bottom: 1em;
            width: fit-content;
            margin: auto;
            left: 0;
            right: 0;
        }

        .watermark.bottom-left {
            bottom: 1em;
            width: fit-content;
            left: 1em;
        }

        .watermark.bottom-right {
            bottom: 1em;
            width: fit-content;
            right: 1em;
        }

        .watermark.left-center {
            left: 1em;
            width: fit-content;
            margin: auto;
            top: 50%;
            transform: translateY(-50%);
        }

        .watermark.left-top {
            left: 1em;
            width: fit-content;
            top: 1em;
        }

        .watermark.left-bottom {
            left: 1em;
            width: fit-content;
            bottom: 1em;
        }

        .watermark.right-center {
            right: 1em;
            width: fit-content;
            margin: auto;
            top: 50%;
            transform: translateY(-50%);
        }

        .watermark.right-top {
            right: 1em;
            width: fit-content;
            top: 1em;
        }

        .watermark.right-bottom {
            right: 1em;
            width: fit-content;
            bottom: 1em;
        }

        .watermark.left.rotate {
            transform: rotate(-90deg);
        }

        .watermark.right.rotate {
            transform: rotate(90deg);
        }

        .watermark.text {
            color: rgba(255, 255, 255, {{ $watermark ? $watermark['opacity'] : '0.4' }});
            font-size: {{ $watermark ? $watermark['size'] . 'px' : '3rem' }};
            font-weight: 900;
        }

        .live-video.text {
            color: rgba(255, 255, 255, 1);
            font-size: 3rem;
            font-weight: 900;
            z-index: 3;
            right: 15px;
        }

        .watermark img {
            max-height: {{ $watermark ? $watermark['size'] . 'px' : '112px' }};
            height: {{ $watermark ? $watermark['size'] . 'px' : '112px' }};
            opacity: {{ $watermark ? $watermark['opacity'] : 0 }};
            -webkit-user-drag: none;
            user-select: none;
        }

        /* Styles for BuyNow redirect message */
        .buynow-redirect-message {
            background-color: #353b49;
            color: var(--themePrimaryTxtColor);
            max-width: 1000.89px;
            width: fit-content;
            padding: .8rem 1.2rem;
            font-weight: 600;
            border-radius: 2px;
            position: absolute;
            z-index: 1000;
            bottom: 68px;
            height: fit-content;
            left: 18px;
            user-select: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            transition: all 0.5s ease-in-out;
            transform: translateX(-400px);
            opacity: 0;
            visibility: hidden;
        }

        .show-player-popup {
            visibility: visible;
            opacity: 1;
            transform: translateX(0);
            cursor: pointer;
        }



        @if ($redirectUrl)
            .mvp-input-progress,
            .mvp-skip-backward-toggle,
            .mvp-skip-forward-toggle,
            .mvp-rewind-toggle {
                cursor: not-allowed !important;
            }

        @endif
    </style>

    <?php if(session("GLOBAL_PASS") == 1){ ?>
    <section class="credential_form signForm">
        <div>
        </div>
        <div class="login_page main_pg">

            <div class="inner-cred">
                <h4>Enter Password</h4>
                <center>
                    <p style="color:red"></p>
                </center>
                <form method="POST" action="{{ route('playerscreen.checkScreenpassword') }}" class="cred_form">
                    @csrf
                    <input type="hidden" name="stream_guid" value="{{ $arrSlctItemData['stream_guid'] }}">
                    <input type="hidden" name="key"
                        value="{{ \Illuminate\Support\Facades\Crypt::encryptString($globalPass) }}">
                    <input type="hidden" name="shortUrl" value="{{ $shortUrl }}">
                    <input type="hidden" name="fullUrl" value="{{ $fullUrl }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="inner-div dv2">
                                <div class="input_groupbox">
                                    <label class="contact-label">
                                        <div class="vertLine"></div>
                                        <input id="password" type="password" class="form-control" name="password"
                                            placeholder="Password" aria-autocomplete="list">
                                        <img src="{{ asset('assets/images/lock.png') }}" class="icn">
                                        <span id="eye_password" toggle="#password"
                                            class="far fa-light fa-eye field-icon toggle-password"
                                            style="display:none;"></span>
                                    </label>
                                    <?php if (session('error')): ?>
                                    <span class="error_box" id="span_password">{{ session('error') }}</span>
                                    <?php session()->forget('error'); endif; ?>
                                </div>
                                <div class="form-group">
                                    <button class="btn" name="checkScreenerPassword" value="true">SUBMIT</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <?php }else { ?>
    <div>

        <div class="container-fluid containinax">
            <div class="row">
                <div class="col-md-12">
                    <?php if (isset($arrSlctItemData['password']) && (session('protectedContentAccess') === null || !in_array($arrSlctItemData['stream_guid'], session('protectedContentAccess')))): ?>
                    <section class="credential_form signForm">
                        <div>
                        </div>
                        <div class="login_page main_pg">

                            <div class="inner-cred">
                                <h4>Enter Password</h4>
                                <center>
                                    <p style="color:red"></p>
                                </center>
                                <form method="POST" action="{{ route('playerscreen.checkpassword') }}" class="cred_form">
                                    @csrf
                                    <input type="hidden" name="stream_guid" value="{{ $arrSlctItemData['stream_guid'] }}">
                                    <input type="hidden" name="key"
                                        value="{{ \Illuminate\Support\Facades\Crypt::encryptString($arrSlctItemData['password']) }}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="inner-div dv2">
                                                <div class="input_groupbox">
                                                    <label class="contact-label">
                                                        <div class="vertLine"></div>
                                                        <input id="password" type="password" class="form-control"
                                                            name="password" placeholder="Password" aria-autocomplete="list">
                                                        <img src="{{ asset('assets/images/lock.png') }}" class="icn">
                                                        <span id="eye_password" toggle="#password"
                                                            class="far fa-light fa-eye field-icon toggle-password"
                                                            style="display:none;"></span>
                                                    </label>
                                                    <?php if (session()->has('error')): ?>
                                                    <span class="error_box"
                                                        id="span_password">{{ session('error') }}</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn" name="checkPassword"
                                                        value="true">SUBMIT</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                    <?php else: ?>

                    <div class="videocentalize">
                        @if ($watermark)
                            <div class="watermark {{ $watermark['position'] }} {{ $watermark['type'] }}"
                                style="display: none;">
                                @if ($watermark['type'] === 'text')
                                    {{ $watermark['text'] }}
                                @else
                                    <img src="{{ $watermark['image'] }}" alt="watermark">
                                @endif
                            </div>
                        @endif
                        @if (strpos($streamUrl, 'https://stream.live.gumlet.io') !== false)
                            <div class="live-video top-right text" style="display: block;">
                                <img src="{{ asset('assets/images/live-video.png') }}" height="30" alt="watermark">
                            </div>
                        @endif
                        <div id="wrapper">
                            <div class="trail-redirect-message">You will be redirected to login in <span class="time">45
                                    second</span></div>
                            <div class="buynow-redirect-message">
                                name here <span class="time">10 second</span>
                            </div>
                            @if ($arrSlctItemData['overlay_ad'] ?? null)
                                <div class="overlay-ad d-none">
                                    <button class="btn-close-ad" onclick="closeOverlayAd()"><i
                                            class="bi bi-x-lg"></i></button>
                                    @if ($arrSlctItemData['overlay_ad']['target_url'])
                                        <a href="{{ $arrSlctItemData['overlay_ad']['target_url'] }}" target="_blank"
                                            onclick="overlayAdClick()">
                                            <img src="{{ $arrSlctItemData['overlay_ad']['image_url'] }}"
                                                class="overlay-height-img" alt="overlay ad" />
                                        </a>
                                    @else
                                        <img src="{{ $arrSlctItemData['overlay_ad']['image_url'] }}" alt="overlay ad" />
                                    @endif
                                </div>
                            @endif
                        </div>
                        <!-- LIST OF PLAYLISTS -->
                        <div id="mvp-playlist-list">
                            <div class="mvp-global-playlist-data"></div>
                            <div class="playlist-video">

                                <div class="mvp-playlist-item"
                                    @php
$mType = strpos($streamUrl, "https://stream.live.gumlet.io")? 'hls': $mType; @endphp
                                    data-type="{{ Str::endsWith($streamUrl, ['.mp3', '.wav']) ? 'audio' : $mType }}"
                                    data-path="{{ $streamUrl }}"
                                    data-poster="{{ $arrSlctItemData['stream_poster'] }}"
                                    data-thumb="{{ $arrSlctItemData['stream_poster'] }}"
                                    data-title="{{ $arrSlctItemData['stream_title'] }}"
                                    data-description="{{ $arrSlctItemData['stream_description'] }}"
                                    {!! $dataVast2 ? $dataVast2 : $dataVast !!}>

                                    <div class="mvp-annotation-section">
                                        @if ($arrSlctItemData['start_duration'])
                                            <div class="mvp-popup" data-show="{{ $arrSlctItemData['start_duration'] }}">                        
                                                <div class="continue-confirmation-popup">
                                                    <button class="btn" onclick="window.resumeMedia()">
                                                        <svg aria-hidden="true" width="20px" height="20px" style="margin-left: -14px;" focusable="false" role="img" viewBox="0 0 373.008 373.008"><path d="M61.792,2.588C64.771,0.864,68.105,0,71.444,0c3.33,0,6.663,0.864,9.655,2.588l230.116,167.2 c5.963,3.445,9.656,9.823,9.656,16.719c0,6.895-3.683,13.272-9.656,16.713L81.099,370.427c-5.972,3.441-13.334,3.441-19.302,0 c-5.973-3.453-9.66-9.833-9.66-16.724V19.305C52.137,12.413,55.818,6.036,61.792,2.588z"></path></svg>     
                                                        Resume
                                                    </button>
                                                    <hr class="m-0 text-white bg-white">
                                                    <button class="btn" onclick="window.startOverMedia()">
                                                        <svg aria-hidden="true" width="20px" height="20px" focusable="false" role="img" viewBox="0 0 512 512"><path d="M255.545 8c-66.269.119-126.438 26.233-170.86 68.685L48.971 40.971C33.851 25.851 8 36.559 8 57.941V192c0 13.255 10.745 24 24 24h134.059c21.382 0 32.09-25.851 16.971-40.971l-41.75-41.75c30.864-28.899 70.801-44.907 113.23-45.273 92.398-.798 170.283 73.977 169.484 169.442C423.236 348.009 349.816 424 256 424c-41.127 0-79.997-14.678-110.63-41.556-4.743-4.161-11.906-3.908-16.368.553L89.34 422.659c-4.872 4.872-4.631 12.815.482 17.433C133.798 479.813 192.074 504 256 504c136.966 0 247.999-111.033 248-247.998C504.001 119.193 392.354 7.755 255.545 8z"></path></svg>
                                                        Start Over
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                                <?php
                    $arrCatData = $ARR_FEED_DATA['arrCategoriesData'];
                    $dataVast3 = null;
                    foreach ($arrCatData['streams'] as $arrStreamsData)
                    {
                      $poster = $arrStreamsData['stream_poster'];
                      $videoUrl = $arrStreamsData['stream_url'];
                      $quality = 'video';
                      if (strpos($videoUrl, '.m3u8'))
                      {
                          $quality = "hls";
                      }

                      $adParam = "videoId=".$arrStreamsData['stream_guid'].'&title='.$arrStreamsData['stream_title'];
                      $dataVast = 'data-vast="'.url('/get-ad?'.$adParam).'"';
                      $dataVast = "data-vast='$adMacros'";
                      $dataVast3 = url('/get-ad?'.$adParam);
                      if ($isMobileBrowser == 1)
                      {
                      //  $dataVast = '';
                      }
                     ?>
                                <div class="mvp-playlist-item" data-type="{{ $quality }}"
                                    data-path="{{ $videoUrl }}" {!! $dataVast2 ? $dataVast2 : $dataVast !!}
                                    data-poster="{{ $poster }}" data-thumb="{{ $poster }}"
                                    data-title="{{ $arrStreamsData['stream_title'] }}"
                                    data-description="{{ $arrStreamsData['stream_description'] }}"></div>
                                <?php
                            }
                            ?>
                            </div>
                        </div>
                        @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'])
                            @if (!empty($arrSlctItemData['is_download']) && $arrSlctItemData['is_download'] == 1)
                                <div class="float-end">
                                    <form action="{{ route('video.convert') }}" method="POST">
                                        @csrf
                                        @if (session('message'))
                                            <span id="success-message" class="text-success">
                                                {{ session('message') }}</span>
                                        @endif
                                        <span id="error-message" class="text-danger"></span>
                                        <input type="hidden" name="stream_url"
                                            value="{{ $arrStreamsData['stream_url'] }}">
                                        <input type="hidden" name="stream_description"
                                            value="{{ $arrStreamsData['stream_description'] }}">
                                        <input type="hidden" name="stream_title"
                                            value="{{ $arrSlctItemData['stream_title'] }}">
                                        <button type="submit" class="auth app-secondary-btn rounded"><span
                                                class="px-1"><i class="ri-arrow-down-line"></i></span>Download</button>
                                    </form>
                                </div>
                            @endif
                        @endif
                        <a href=""></a>
                    </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>


    </div>
    <?php } ?>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered sharing-madal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Share</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="share_list d-flex justify-content-between">
                        @if ($arrSlctItemData['is_embed'] || $is_embed)
                            <li data-bs-toggle="modal" data-bs-target="#exampleModalCenter2">
                                <a data-toggle="tooltip" data-placement="top" title="embed" href="javascript:void(0)">
                                    <i class="fa-solid fa-code fa-xs"></i>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a data-toggle="tooltip" data-placement="top" title="facebook"
                                href="https://www.facebook.com/sharer/sharer.php?u={{ $sharingURL }}" target="_blank">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tooltip" data-placement="top" title="whatsapp"
                                href="https://wa.me/?text={{ $sharingURL }}" target="_blank">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tooltip" data-placement="top" title="twitter"
                                href="https://twitter.com/intent/tweet?text={{ $sharingURL }}" target="_blank">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tooltip" data-placement="top" title="telegram"
                                href="https://t.me/share/url?url={{ $sharingURL }}&text={{ $arrSlctItemData['stream_title'] }}"
                                target="_blank">
                                <i class="fa-brands fa-telegram"></i>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tooltip" data-placement="top" title="linkedin"
                                href="https://www.linkedin.com/shareArticle?mini=true&url={{ $sharingURL }}"
                                target="_blank">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                        </li>
                    </ul>

                    <form class="form-inline d-flex mt-3">
                        <input type="text" class="share_formbox" id="sharingURL" value="{{ $sharingURL }}"
                            readonly>
                        <input type="button" class="submit_btn share_btnbox" value="Copy">
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- stream embed Modal -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenter2Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Embed stream "{{ $arrSlctItemData['stream_title'] }}"
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="border pt-4 p-3 rounded-2 position-relative">
                        <!-- Copy Button -->
                        <button onclick="copyText(this)" id="copy-btn"
                            class="btn btn-sm btn-outline-secondary rounded-3" type="button" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Copy to Clipboard"
                            style="position: absolute; top: 10px; right: 10px; padding: 5px 10px;">
                            Copy
                        </button>

                        <code id="copy-code"></code>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var videoSrc = '{{ $streamUrl }}'; // Media URL
        var copyCodeElement = document.getElementById("copy-code");

        function getMediaType(url) {
            const cleanUrl = url.split('?')[0];
            const extension = cleanUrl.split('.').pop().toLowerCase();
            return extension;
        }

        const mediaType = getMediaType(videoSrc); // Get media type (m3u8, mp3, mp4)

        let embedCode = ""; // This will hold the final embed code

        if (mediaType === 'm3u8') {
            // Generate code for HLS video (M3U8)
            embedCode = `&lt;script src="https://cdn.jsdelivr.net/npm/hls.js@1"&gt;&lt;/script&gt;
                        &lt;video id="video" controls width="720" height="420"&gt;&lt;/video&gt;
                        &lt;script&gt;
                        var video = document.getElementById('video');
                        if (Hls.isSupported()) {
                            var hls = new Hls();
                            hls.loadSource('${videoSrc}');
                            hls.attachMedia(video);
                        }
                        &lt;/script&gt;`;
        } else if (mediaType === 'mp3') {
            // Generate code for MP3 audio
            embedCode = `&lt;audio controls&gt;
                        &lt;source src="${videoSrc}" type="audio/mpeg"&gt;
                        Your browser does not support the audio element.
                        &lt;/audio&gt;`;
        } else if (mediaType === 'mp4') {
            // Generate code for MP4 video
            embedCode = `&lt;video id="video" controls width="720" height="420"&gt;
                        &lt;source src="${videoSrc}" type="video/mp4"&gt;
                        Your browser does not support the video element.
                        &lt;/video&gt;`;
        } else {
            embedCode = "Unsupported media format.";
        }

        // Insert the generated code into the code element
        copyCodeElement.innerHTML = embedCode.replace(/</g, "&lt;").replace(/>/g, "&gt;");

        // Copy button functionality
        document.getElementById("copy-btn").onclick = function() {
            navigator.clipboard.writeText(copyCodeElement.textContent);
            this.textContent = "Copied!";
            this.classList.remove("btn-outline-secondary");
            this.classList.add("btn-success");

            setTimeout(() => {
                this.textContent = "Copy";
                this.classList.remove("btn-success");
                this.classList.add("btn-outline-secondary");
            }, 2000);
        };
    </script>


    <!-- Report Modal -->
    <div class="modal fade" id="reportModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="reportModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <h5 class="modal-title " id="reportModalLabel">Want to report this content?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body ">
                    <form class="p-3 d-flex flex-column justify-content-center w-100 mb-4" id="reportForm">
                        @csrf
                        <label class="px-3 alert alert-warning mb-3" id="radio-error" style="display: none;"></label>
                        <label class="report-label alert alert-light p-2">
                            <input type="radio" name="code" value="1" class="mx-2 report-radio small"
                                required>
                            Inappropriate Content
                        </label>
                        <label class="report-label alert alert-light p-2">
                            <input type="radio" name="code" value="2" class="mx-2 report-radio small"
                                required>
                            Misinformation
                        </label>
                        <label class="report-label alert alert-light p-2">
                            <input type="radio" name="code" value="3" class="mx-2 report-radio small"
                                required>
                            Copyright Violation
                        </label>
                        <label class="report-label alert alert-light p-2">
                            <input type="radio" name="code" value="4" class="mx-2 report-radio small"
                                required>
                            Privacy Violation
                        </label>
                        <label class="report-label alert alert-light p-2">
                            <input type="radio" name="code" value="5" class="mx-2 report-radio small"
                                required>
                            Harmful or Dangerous Acts
                        </label>
                        <label class="report-label alert alert-light p-2">
                            <input type="radio" name="code" value="6" class="mx-2 report-radio small"
                                required>
                            Hateful or Discriminatory Content
                        </label>
                        <label class="report-label alert alert-light p-2">
                            <input type="radio" name="code" value="7" class="mx-2 report-radio small"
                                required>
                            Spam or Scams
                        </label>
                        <input type="hidden" name="user_code" value="{{ session('USER_DETAILS')['USER_CODE'] ?? '' }}">
                        <input type="hidden" name="stream_code" value="{{ $streamGuid }}">
                        <input type="hidden" name="app_code" value="{{ env('APP_CODE') }}">
                        <button type="submit" id="reportSubmit"
                            class="share_btnbox d-flex align-items-center justify-content-center">Submit <span
                                class="loader mx-2" style="display: none;" id="loader"></span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="sec-device content-wrapper px-2 px-md-3 mt-3">
        <div class="tab-btns d-flex gap-3 gap-sm-3 gap-md-4 gap-lg-5">
            <div class="tab active" data-tab="overview"><span>Overview</span></div>
            <?php
            $arrCatData = $ARR_FEED_DATA['arrCategoriesData'];
            if (!empty($arrCatData)) {
                $catTitle = $arrCatData['title'];
            }
            ?>
            <div class="tab " data-tab="like"><span>{{ $catTitle }}</span></div>
            <!--End of season section-->
            @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !empty($arrSlctItemData['images']))
                <div class="tab" data-tab="images"><span>Images</span></div>
            @endif
            @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !empty($arrSlctItemData['pdfs']))
                <div class="tab" data-tab="pdf"><span>PDF</span></div>
            @endif
            @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !empty($arrSlctItemData['videos']))
                <div class="tab" data-tab="video"><span>Videos</span></div>
            @endif
        </div>
    </div>
    <div class="tab-content">
        <div id="overview" class="content">
            <div class="product_bindfullbox">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="product_detailbox">
                                @if (isset($arrSlctItemData['title_logo']) && $arrSlctItemData['title_logo'])
                                    <div class="title_logo mb-1">
                                        <img class="img-fluid" src="{{ $arrSlctItemData['title_logo'] }}"
                                            alt="{{ $arrSlctItemData['stream_title'] ?? 'Logo' }}">
                                    </div>
                                @else
                                    <h1 class="content-heading">{{ $arrSlctItemData['stream_title'] }}</h1>
                                @endif
                                <div class="content-timing">
                                    @if ($arrSlctItemData['released_year'])
                                        <a href="{{ route('year', $arrSlctItemData['released_year']) }}"
                                            class="text-decoration-none">
                                            <span class="year">{{ $arrSlctItemData['released_year'] }}</span>
                                        </a>
                                        <span class="dot-sep"></span>
                                    @endif
                                    @if ($arrSlctItemData['stream_duration'] && $arrSlctItemData['stream_duration'] !== '0')
                                        <span>{{ \App\Helpers\GeneralHelper::showDurationInHourAndMins($arrSlctItemData['stream_duration']) }}</span>
                                        <span class="dot-sep"></span>
                                    @endif
                                    {{-- <span class="movie_type">{{ $arrSlctItemData['cat_title'] }}</span> --}}
                                    <span class="movie_type">
                                        @foreach ($arrSlctItemData['genre'] ?? [] as $item)
                                            <a href="{{ route('category', $item['code']) }}?type=genre"
                                                class="px-0">{{ $item['title'] }}</a>{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </span>
                                    <?php
                            if ($streamType == 'S')
                            {
                                ?>
                                    <span
                                        class="movie_type">{{ $arrSlctItemData['stream_episode_title'] && $arrSlctItemData['stream_episode_title'] !== 'NULL' ? $arrSlctItemData['stream_episode_title'] : '' }}</span>
                                    <span class="movie_type">{{ $arrSlctItemData['show_name'] ?? '' }}</span>
                                    <?php
                            }
    ?>
                                    <?php
                  if ($arrSlctItemData['content_qlt'] != '')
                  {
    ?>
                                    <span class="content_screen">
                                        @php
                                            $content_qlt_arr = explode(',', $arrSlctItemData['content_qlt']);
                                            $content_qlt_codes_arr = explode(
                                                ',',
                                                $arrSlctItemData['content_qlt_codes'],
                                            );
                                        @endphp
                                        @foreach ($content_qlt_arr as $i => $item)
                                            <a
                                                href="{{ route('quality', trim($content_qlt_codes_arr[$i])) }}">{{ $item }}</a>
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </span>
                                    <?php
                  }
    ?>
                                    <?php
                      if ($arrSlctItemData['content_rating'] != '')
                      {
                        ?>
                                    <span class="content_screen">
                                        @php
                                            $content_rating_arr = explode(',', $arrSlctItemData['content_rating']);
                                            $content_rating_codes_arr = explode(
                                                ',',
                                                $arrSlctItemData['content_rating_codes'],
                                            );
                                        @endphp
                                        @foreach ($content_rating_arr as $i => $item)
                                            <a
                                                href="{{ route('rating', trim($content_rating_codes_arr[$i])) }}">{{ $item }}</a>
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </span>
                                    <?php
                      }
                      ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 sharesinbos mb-2">
                            <?php
                if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'])
                {
                  $signStr = "+";
                  $cls = 'fa fa-plus';
                  if ($arrSlctItemData['stream_is_stream_added_in_wish_list'] == 'Y')
                  {
                    $cls = 'fa fa-minus';
                    $signStr = "-";
                  }
                 ?>
                            <div class="share_circle addWtchBtn">
                                <a href="javascript:void(0);" onClick="javascript:manageFavItem();"><i id="btnicon-fav"
                                        class="{{ $cls }}"></i></a>
                                <input type="hidden" id="myWishListSign" value='{{ $signStr }}' />
                                <input type="hidden" id="strQueryParm" value='{{ $strQueryParm }}' />
                                <input type="hidden" id="reqUrl" value='{{ route('wishlist.toggle') }}' />
                                @csrf
                            </div>
                            <?php
                }
               ?>
                            <div class="share_circle addWtchBtn" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter">
                                <a href="javascript:void(0);"><i class="fa fa-share"></i></a>
                            </div>
                            @if (isset(\App\Services\AppConfig::get()->app->app_info->report) &&
                                    \App\Services\AppConfig::get()->app->app_info->report === 1)
                                <div class="share_circle addWtchBtn" data-bs-toggle="modal"
                                    data-bs-target="#reportModalCenter">
                                    @if (session('USER_DETAILS') && isset(session('USER_DETAILS')['USER_CODE']))
                                        <a href="javascript:void(0);"><i class="fa fa-triangle-exclamation"></i></a>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>
                    <div class="row">
                        <div class="slider_title_box slidessbwh" style="padding: 0px 45px;">
                            <div class="about_fulltxt">{{ $arrSlctItemData['stream_description'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="like" class="content d-none">
            <?php
$arrCatData = $ARR_FEED_DATA['arrCategoriesData'];
$nextVideoPath = '';
if (!empty($arrCatData))
{
?>

            <!--Start of thumbnail slider section-->
            <section class="sliders">
                <div class="slider-container">
                    <!-- Start shows -->
                    <?php
                    $strKey = 'title';
                    $catTitle = $arrCatData[$strKey];
                    ?>
                    <div class="listing_box">
                        <div class="slider_title_box">
                            <div class="list_heading">
                                <h1>{{ $catTitle }}</h1>
                            </div>
                        </div>
                        <div class="landscape_slider slider slick-slider">
                            <?php
                foreach ($arrCatData['streams'] as $arrStreamsData)
                {
                    if ($arrStreamsData['stream_guid'] === $arrSlctItemData['stream_guid'])
                        continue;

                    $vidPath = url("/playerscreen/".$arrStreamsData['stream_guid']);
                    if ($nextVideoPath == "Y")
                    {
                      $nextVideoPath = $vidPath;

                    }

                    if ($streamGuid == $arrStreamsData['stream_guid'])
                    {
                      $nextVideoPath = "Y";
                      //die;
                    }
                    $randomVideoPath = $vidPath;
                    $strBrige = "";
                    if ($arrStreamsData['monetization_type'] == 'F')
                    {
                      $strBrige = "style='display: none;'";
                    }

                    ?>
                            <div>
                                <a href="{{ url('/playerscreen/' . $arrStreamsData['stream_guid']) }}">
                                    <div class="thumbnail_img">
                                        <div class="trending_icon_box" {!! $strBrige !!}><img
                                                src="{{ asset('/assets/images/trending_icon.png') }}"
                                                alt="{{ $arrStreamsData['stream_title'] }}"></div>
                                        @if (($arrStreamsData['is_newly_added'] ?? 'N') === 'Y')
                                            <div class="newly-added-label">
                                                <span>New Episode</span>
                                            </div>
                                        @endif
                                        <img src="{{ $arrStreamsData['stream_poster'] }}"
                                            alt="{{ $arrStreamsData['stream_title'] }}">
                                        <div class="detail_box_hide">
                                            <div class="detailbox_time">
                                                {{ $arrStreamsData['stream_duration_timeformat'] }}</div>
                                            <div class="deta_box">
                                                <div class="season_title">
                                                    {{ $arrStreamsData['stream_episode_title'] && $arrStreamsData['stream_episode_title'] !== 'NULL' ? $arrStreamsData['stream_episode_title'] : '' }}
                                                </div>
                                                <!-- <div class="play_icon"><a href="/details/21"><i class="fa fa-play" aria-hidden="true"></i></a>
                                                                                                                                                                                                                                                              </div> -->
                                                <div class="content_title">{{ $arrStreamsData['stream_title'] }}</div>
                                                <div class="content_description">
                                                    {{ $arrStreamsData['stream_description'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                }
                ?>
                        </div>
                    </div>
                    <!-- End Shows -->
                </div>
            </section>
            <?php
}
?>
        </div>

        @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !empty($arrSlctItemData['images']))
            <div id="images" class="content d-none">
                <div class="container">
                    <div class="custom-gallery row custom-border p-4 rounded">

                        <!-- Featured Image -->
                        <div class="custom-placeholder col-md-7 mb-4" id="custom-featured">
                            <img src="{{ $arrSlctItemData['images'][0]['video_url_local'] }}" class="img-fluid p-2"
                                style="width: 100%; height: auto; object-fit: cover;">
                        </div>

                        <!-- Thumbnail Images -->
                        <div class="custom-gallery-images col-md-5 ">
                            <div class="row">
                                @foreach ($arrSlctItemData['images'] as $image)
                                    <div class="custom-image col-4 mb-2">
                                        <img src="{{ $image['video_url_local'] }}" data-id="{{ $loop->index }}"
                                            class="img-fluid custom-border rounded p-2"
                                            style="width: 100%; height: 80%; object-fit: cover; cursor: pointer;">
                                        <div class="image-name rounded">
                                            {{ $image['name'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif
        @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !empty($arrSlctItemData['pdfs']))
            <div id="pdf" class="content d-none">
                <div class="row">
                    @foreach ($arrSlctItemData['pdfs'] as $pdf)
                        <div class="col-md-3 mb-4 d-flex justify-content-center">
                            <a href="{{ $pdf['video_url_local'] }}" target="_blank"
                                class="d-block text-center custom-link">
                                @if (Str::endsWith($pdf['video_url_local'], ['.pdf']))
                                    <i class="fas fa-file-pdf custom-icon pdf-icon"></i>
                                @elseif (Str::endsWith($pdf['video_url_local'], ['.doc', '.docx']))
                                    <i class="fas fa-file-word custom-icon word-icon"></i>
                                @else
                                    <i class="fas fa-file-alt custom-icon other-icon"></i>
                                @endif
                                <p class="mt-2 custom-text">{{ $pdf['name'] }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !empty($arrSlctItemData['videos']))
            <!-- Video Section -->
            <div id="video" class="content d-none">
                <section class="sliders">
                    <div class="slider-container">
                        <div class="listing_box">
                            <div class="slider_title_box">
                            </div>

                            <!-- Slick Slider for Thumbnails -->
                            <div class="landscape_slider slider slick-slider">
                                @foreach ($arrSlctItemData['videos'] as $video)
                                    <div>
                                        <div class="thumbnail_img" id="thumbnail_img_video" style="cursor: pointer;"
                                            data-url="{{ $video['playback_url'] }}"
                                            data-thumbnail="{{ $video['thumbnail_url'] }}"
                                            data-title="{{ $video['name'] }}"
                                            data-description="{{ $video['description'] }}">
                                            <img src="{{ $video['thumbnail_url'] }}" alt="{{ $video['name'] }}">
                                            <div class="detail_box_hide">
                                                <div class="deta_box">
                                                    <div class="content_title">{{ $video['name'] }}</div>
                                                    <div class="content_description">{{ $video['description'] }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        @endif
    </div>
    {{--  status modal  --}}
    <div id="statusModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title-delete">Confirmation</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Are you Still Watching?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="confirm_status" id="confirm_status" class="btn btn-danger">yes</button>
                    <button type="button" id="closemybt" class="btn btn-secondary" data-bs-dismiss="modal">no</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            var isshowlist = true
            var pListPostion = 'vrb';
            if (detectMob()) {
                var pListPostion = 'hb';
            }
            var settings = {

                skin: 'sirius', //aviva, polux, sirius
                playlistPosition: pListPostion, //vrb, vb, hb, no-playlist, outer, wall


                sourcePath: "",
                activeItem: 0, //active video to start with
                activePlaylist: ".playlist-video",
                playlistList: "#mvp-playlist-list",
                instanceName: "player1",
                hidePlaylistOnMinimize: true,
                volume: 0.75,
                useShare: true,
                autoPlay: true,
                crossorigin: "link",
                playlistOpened: false,
                randomPlay: false,
                usePlaylistToggle: isshowlist,
                useEmbed: true,
                useTime: true,
                usePip: true, //picture in picture
                useCc: true, //caption toggle
                useAirPlay: true,
                usePlaybackRate: true,
                useNext: true,
                usePrevious: true,
                useRewind: true,
                useSkipBackward: true,
                useSkipForward: true,
                showPrevNextVideoThumb: true,
                rememberPlaybackPosition: 'all', //remember last video position (false, 1, all)
                useQuality: true,
                useImaLoader: true,
                useTheaterMode: true,
                focusVideoInTheater: true,
                focusVideoInTheater: true,
                hidePlaylistOnTheaterEnter: true,
                useSubtitle: true,
                useTranscript: false,
                useChapterToggle: false,
                useCasting: true,
                comingNextHeader: "Coming Next",
                comingNextCancelBtnText: "CANCEL",
                mediaEndAction: 'comingnext',
                comingnextTime: 10,
                disableVideoSkip: false,
                useAdSeekbar: true,
                useAdControls: true,
                useGlobalPopupCloseBtn: true,
                showPopupsOnlyOnce: true,
                playbackRateArr: [{
                        value: 2,
                        menu_title: '2x'
                    },
                    {
                        value: 1.5,
                        menu_title: '1.5x'
                    },
                    {
                        value: 1.25,
                        menu_title: '1.25x'
                    },
                    {
                        value: 1,
                        menu_title: '1x (Normal)'
                    },
                    {
                        value: 0.5,
                        menu_title: '0.5x'
                    },
                    {
                        value: 0.25,
                        menu_title: '0.25x'
                    }
                ],

            };

            window.player = new mvp(document.getElementById('wrapper'), settings);
            setTimeout(unmutedVoice, 2000);
            let playerstillwatch = "<?php echo $stillwatching; ?>";
            let playerstillwatchduration = "<?php echo $playerstillwatchduration; ?>";

            if (playerstillwatch && playerstillwatch == "1") {
                window.setInterval(function() {
                    pauseVideo();
                }, 5000)
            }





            counter = [];

            function pauseVideo() {
                if (isPrime(player.getActiveItemId()) && !counter.includes(player.getActiveItemId())) {
                    counter.push(player.getActiveItemId());
                    player.pauseMedia();
                    $('#statusModal').modal('show');
                }
            }
            $('#confirm_status').click(function() {
                $('#statusModal').modal('hide');
                player.playMedia();
            });
            $('#closemybt').click(function() {
                $('#statusModal').modal('hide');
                player.pauseMedia();
            });

            function isPrime(number) {
                // Check if the number is less than 2 (0 and 1 are not prime)

                if (number !== 0 && number % parseInt(playerstillwatchduration) === 0) {
                    playerstillwatchduration + playerstillwatchduration;
                    return true;
                } else {
                    return false;
                }

                // // Check for divisibility from 2 to the square root of the number
                // for (let i = 2; i <= Math.sqrt(number); i++) {
                //     if (number % i === 0) {
                //         return false; // Not a prime number
                //     }
                // }

                // return true; // Prime number
            }

            @if ($redirectUrl)
                const trial = getTrial();
                trial.onRedirect(() => {
                    player.pauseMedia();
                    player.destroyMedia();
                    window.location.href = '{{ $redirectUrl }}';
                })
            @endif

            var isFirstTIme = true
            player.addEventListener('mediaStart', function(data) {
                //called on media start, returns (instance, instanceName, counter)

                console.log(data.instanceName);
                console.log(data.counter); //active item

                //get media current time
                data.instance.getCurrentTime();

                //get media duration
                data.instance.getDuration();
                if (isFirstTIme == true) {
                    isFirstTIme = false;
                    // player.seek()
                    player.seek({{ $arrSlctItemData['start_duration'] }});
                } else {
                    sendAjaxRes4VideoDuration('getStrmDur', data.media.mediaId, '');
                }

                let liveVideo = document.querySelector('.live-video');
                if (liveVideo) {
                    liveVideo.style.display = "block";
                }

                let watermark = document.querySelector('.watermark');
                if (watermark) {
                    watermark.style.display = "block";
                }

                showOverlayAd();
            });

            @if (!empty($arrSlctItemData['buynow']))
                @php
                    $buynows = $arrSlctItemData['buynow'];
                @endphp
            @endif
            player.addEventListener("mediaPlay", function(data) {
                @if ($redirectUrl)
                    trial.start();
                    document.querySelector('.mvp-input-progress').disabled = true;
                    document.querySelector('.mvp-skip-backward-toggle').disabled = true;
                    document.querySelector('.mvp-skip-forward-toggle').disabled = true;
                    document.querySelector('.mvp-rewind-toggle').disabled = true;
                @endif

@if (!empty($arrSlctItemData['buynow']))
    @foreach ($arrSlctItemData['buynow'] as $index => $buynow)
        let timeOffset_{{ $index }} = {{ $buynow['time_offset'] * 60 }};
        let isBuyNowShown_{{ $index }} = false;

        function showBuyNowMessage_{{ $index }}() {
            let currentTime = Math.floor(data.instance.getCurrentTime());

            // Check if the current time is past the time offset
            if (currentTime >= timeOffset_{{ $index }} && !isBuyNowShown_{{ $index }}) {
                isBuyNowShown_{{ $index }} = true; // Prevent showing again

                const buyNowMessageBox = document.querySelector('.buynow-redirect-message');
                buyNowMessageBox.innerHTML = `{{ $buynow['name'] }}<span class="time"></span>`;
                buyNowMessageBox.classList.add('show-player-popup');
                buyNowMessageBox.style.display = 'block';

                let hideMessageTimeout = setTimeout(() => {
                    buyNowMessageBox.classList.remove('show-player-popup');
                    buyNowMessageBox.style.display = 'none';
                }, 10000);

                let sourceType = "{{ $buynow['source_type'] }}";
                let internalUrl = "{{ url('/getitemplayerdetail/' . $buynow['stream_url']) }}";
                let externalUrl = "{{ $buynow['external_link'] }}";

                buyNowMessageBox.onclick = () => {
                    if (sourceType === "external") {
                        window.open(externalUrl, '_blank');
                    } else if (sourceType === "internal") {
                        window.open(internalUrl, '_blank');
                    } else {
                        console.log("Invalid source type");
                    }

                    buyNowMessageBox.classList.remove('show-player-popup');
                    buyNowMessageBox.style.display = 'none';
                    clearTimeout(hideMessageTimeout);
                };
            }
        }

        // Check for the buy now message every 100 ms
        let timeCheckInterval_{{ $index }} = setInterval(showBuyNowMessage_{{ $index }}, 100);
    @endforeach
@endif


            });


            player.addEventListener("mediaPause", function(data) {
                //alert(data.instance.getCurrentTime());
                //get media duration
                //alert(data.instance.getDuration());
                //alert(data.media.mediaId);
                sendAjaxRes4VideoDuration('saveStrmDur', data.media.mediaId, data.instance
                    .getCurrentTime());

                @if ($redirectUrl)
                    trial.pause();
                @endif
            });

            player.addEventListener("mediaEnd", function(data) {

                //alert(data.instance.getCurrentTime());
                //get media duration
                //alert(data.instance.getDuration());
                //alert(data.media.mediaId);
                sendAjaxRes4VideoDuration('removeStrmDur', data.media.mediaId, '');

            });

            player.addEventListener("adPlay", function(data) {
                let liveVideo = document.querySelector('.live-video');
                if (liveVideo) {
                    liveVideo.style.display = "none";
                }

                // Hide watermark when ad is playing
                let watermark = document.querySelector('.watermark');
                if (watermark) {
                    watermark.style.display = "none";
                }

                hideOverlayAd();
            })

            
            window.resumeMedia = function () {
                player.closePopup();
                setTimeout(() => player.playMedia(), 500);
            }

            window.startOverMedia = function () {
                player.closePopup();
                player.seek(0);
                setTimeout(() => player.playMedia(), 500);
            }

        });

        document.body.addEventListener("click", function(evt) {
            //console.dir(this);
            //note evt.target can be a nested element, not the body element, resulting in misfires
            //console.log(evt.target);
            if (player.getMediaPlaying()) {
                // alert(player);
                mediaId = player.getCurrentMediaData().mediaId
                console.log(player.getCurrentMediaData());
                console.log(player.getCurrentTime());
                //  alert("body clicked");
                sendAjaxRes4VideoDuration('saveStrmDur', mediaId, player.getCurrentTime());
            }
        });

        function unmutedVoice() {
            //alert("hi");
            player.toggleMute();
            player.playMedia();
            setInterval(sendAdRequrst, 50000);
        }

        function sendAdRequrst() {
            $.get("<?php echo $dataVast3 ?? ''; ?>", function(data, status) {
                //alert("Data: " + data + "\nStatus: " + status);
            });
        }

        function showOverlayAd() {
            if (!$('.overlay-ad').hasClass('closed')) {
                $('.overlay-ad').removeClass('d-none');
            }
        }

        function hideOverlayAd() {
            $('.overlay-ad').addClass('d-none');
        }

        function closeOverlayAd() {
            $('.overlay-ad').addClass('d-none');
            $('.overlay-ad').addClass('closed');
        }

        function overlayAdClick() {
            player.pauseMedia();
        }
    </script>
    <script>
        // sendAjaxRes4VideoDuration('saveStrmDur', this.currentTime());
        // sendAjaxRes4VideoDuration('removeStrmDur', '')

        function sendAjaxRes4VideoDuration(requestAction, streamGuid, streamDuration) {
            var isVideoSatementAct = 'Y';
            if (isVideoSatementAct == 'Y') {

                var strQueryParm = '<?php echo $strQueryParm; ?>';
                strQueryParm = strQueryParm + '&requestAction=' + requestAction;
                if (streamDuration != '') strQueryParm = strQueryParm + '&strmDur=' + streamDuration;

                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.responseText);
                    }
                };
                xhttp.open("POST", "<?php echo $apiPath; ?>", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.setRequestHeader("happcode", "{{ env('APP_CODE') }}");
                xhttp.setRequestHeader("husercode", "{{ session('USER_DETAILS.USER_CODE') }}");
                xhttp.send(strQueryParm);
            }
        }
    </script>

    @if ($redirectUrl)
        <script>
            // Trial
            function getTrial() {
                let redirectCallback = () => {};

                const onRedirect = (callback) => redirectCallback = callback;

                let displayCountDown = 30;
                let countDownInterval = null;
                const startCountDown = () => {
                    const messageBox = document.querySelector('.trail-redirect-message');
                    const messageTime = messageBox.querySelector('.time');
                    messageTime.textContent = `${displayCountDown} second${displayCountDown > 1? 's': ''}`;
                    messageBox.classList.add('show-player-popup');

                    countDownInterval = setInterval(() => {
                        --displayCountDown;
                        messageTime.textContent = `${displayCountDown} second${displayCountDown > 1? 's': ''}`;

                        if (displayCountDown === 0) {
                            clearInterval(countDownInterval);
                            redirectCallback();
                        };
                    }, 1000);
                };

                let duration = {{ $watchTimeDuration }} * 60000;
                let countDownTimeout = null;
                let startTime = null;

                const start = () => {
                    startTime = new Date();
                    const countDownDelay = duration - 30000;
                    countDownTimeout = setTimeout(startCountDown, countDownDelay >= 0 ? countDownDelay : 0);
                };

                const pause = () => {
                    if (countDownTimeout) clearTimeout(countDownTimeout);
                    if (countDownInterval) clearInterval(countDownInterval);

                    const currentTime = new Date();
                    duration = duration - (currentTime.getTime() - startTime.getTime());
                };

                return {
                    start,
                    pause,
                    onRedirect,
                };
            }
        </script>
    @endif

    <script>
        $('#submit_btn').on('click', function(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById("DownloadForm"));

            $.ajax({
                type: 'POST',
                data: formData,
                url: "{{ route('video.convert') }}",
                processData: false,
                contentType: false,
                cache: false,
            }).then(function(response) {
                $('#success-message').text(response.message).fadeIn().delay(6000).fadeOut();
                /* window.location.href = response.download_url; */
            }).fail(function(response) {
                const errorMessage = response.responseJSON.message || 'An error occurred';
                $('#error-message').text(errorMessage).fadeIn().delay(6000).fadeOut();
            });
        });

        $('#reportSubmit').on('click', function(event) {
            event.preventDefault();

            if (!$("input[name='code']:checked").val()) {
                $('#radio-error').show();
                $('#radio-error').text('Please select a reason before submitting.').fadeIn().delay(5000).fadeOut();
                return;
            }
            $('#loader').show();
            $('#reportSubmit').prop('disabled', true).val('Submitting...');


            const formData = new FormData(document.getElementById("reportForm"));

            $.ajax({
                type: 'POST',
                data: formData,
                url: "{{ env('API_BASE_URL') }}/user/report",
                processData: false,
                contentType: false,
                cache: false,
            }).then(function(response) {
                const successMessage = response.app ? response.app.msg :
                    'Thank you! Your report has been submitted.';
                $('#reportForm').fadeOut(function() {
                    $(this).html('<div id="success-message" class="alert alert-light">' +
                        successMessage + '</div>');
                });

            }).fail(function(response) {
                let errorMessage = 'An error occurred';
                /* if (response.responseJSON && response.responseJSON.app && response.responseJSON.app.msg) {
                    errorMessage = response.responseJSON.app.msg;
                } else if (response.responseText) {
                    try {
                        const jsonResponse = JSON.parse(response.responseText);
                        if (jsonResponse.app && jsonResponse.app.msg) {
                            errorMessage = jsonResponse.app.msg;
                        }
                    } catch (e) {
                        errorMessage = response.responseText;
                    }
                } */

                $('#radio-error').show();
                $('#radio-error').text(errorMessage).fadeIn().delay(4000).fadeOut();
            }).always(function() {
                $('#loader').hide();
                $('#reportSubmit').prop('disabled', false).val('Submit');
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Function to initialize Slick slider only when needed
            function initializeSlider() {
                const sliderElement = $('.landscape_slider:not(.slick-initialized)');
                if (sliderElement.length) {
                    sliderElement.slick({
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true,
                        arrows: true,
                        responsive: [{
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 2,
                                }
                            },
                            {
                                breakpoint: 480,
                                settings: {
                                    slidesToShow: 1,
                                }
                            }
                        ]
                    });
                }
            }

            // Initialize slider for the first tab by default
            initializeSlider();

            // Handle tab switching
            const tabs = document.querySelectorAll('.sec-device .tab');
            const contents = document.querySelectorAll('.tab-content .content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs and hide all content
                    tabs.forEach(t => t.classList.remove('active'));
                    contents.forEach(c => c.classList.add('d-none'));

                    // Add active class to the clicked tab and show the corresponding content
                    this.classList.add('active');
                    const activeContent = document.getElementById(this.getAttribute('data-tab'));
                    if (activeContent) {
                        activeContent.classList.remove('d-none');

                        // If the active content contains the slider, initialize or update it
                        if (activeContent.querySelector('.landscape_slider')) {
                            initializeSlider();
                            $('.landscape_slider').slick('setPosition');
                        }
                    }
                });
            });

            // Handle thumbnail click to open the new page
            $('#thumbnail_img_video').on('click', function() {
                var playbackUrl = $(this).data('url'); // Get playback URL from clicked thumbnail
                var thumbnail = $(this).data('thumbnail'); // Get thumbnail URL
                var title = $(this).data('title'); // Get video title
                var description = $(this).data('description'); // Get video description

                // Create a hidden form to pass data in the request
                var form = $('<form>', {
                    action: "{{ route('extra-video') }}",
                    method: 'POST',
                    target: '_blank' // Open in a new tab
                });

                // Add CSRF token for security
                form.append($('<input>', {
                    type: 'hidden',
                    name: '_token',
                    value: '{{ csrf_token() }}'
                }));

                // Add form fields to pass the video data
                form.append($('<input>', {
                    type: 'hidden',
                    name: 'playback_url',
                    value: playbackUrl
                }));

                form.append($('<input>', {
                    type: 'hidden',
                    name: 'thumbnail',
                    value: thumbnail
                }));

                form.append($('<input>', {
                    type: 'hidden',
                    name: 'title',
                    value: title
                }));

                form.append($('<input>', {
                    type: 'hidden',
                    name: 'description',
                    value: description
                }));

                // Append form to body and submit
                form.appendTo('body').submit();
            });

            // Image Gallery Script (no changes)
            $('#images .custom-image img').on('click', function() {
                var src = $(this).attr('src');
                var img = $('#images #custom-featured img');

                img.fadeOut('fast', function() {
                    $(this).attr('src', src).fadeIn('fast');
                });
            });
        });
    </script>












@endpush
