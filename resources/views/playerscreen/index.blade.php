@extends('layouts.app')
@section('head')
    {{-- Custom Css --}}

    <!-- Include Video.js Library -->
    <link rel="stylesheet" href="{{ asset('assets/css/details-screen-styling.css') }}">
    {{-- <link href="{{ asset('assets/css/videojs-7.15.4.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/video-7.20.3.min.js') }}"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/cards-item.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/global-rating-on-video.css') }}" />
@endsection
@section('content')
    <?php
    // Config
    $appConfig = \App\Services\AppConfig::get();
    $IS_SIGNIN_BYPASS = $appConfig->app->app_info->is_bypass_login;
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
    if ($streamUrl) {
        $isShortYouTube = preg_match('/youtu\.be\/([^?&]+)/', $streamUrl, $shortYouTubeMatches);
        $isSingleVideo = preg_match('/[?&]v=([^&]+)/', $streamUrl, $videoMatches);
        $isVimeo = preg_match('/vimeo\.com\/(\d+)/', $streamUrl, $vimeoMatches);
        if ($isShortYouTube) {
            $streamUrl = $shortYouTubeMatches[1]; // Extract only the video ID
            $mType = 'youtube_single';
        } elseif ($isSingleVideo) {
            $streamUrl = $videoMatches[1]; // Extract only the video ID
            $mType = 'youtube_single';
        } elseif ($isVimeo) {
            $streamUrl = $vimeoMatches[1]; // Extract only the Vimeo ID
            $mType = 'vimeo_single';
        }
    }
    $adParam = 'videoId=' . $streamGuid . '&title=' . $arrSlctItemData['stream_title'];
    // Login requried

    if ($IS_SIGNIN_BYPASS == 'N' && !session('USER_DETAILS')) {
        session(['REDIRECT_TO_SCREEN' => route('playerscreen', $streamGuid)]);
        session()->save();
        \App\Helpers\GeneralHelper::headerRedirect(url('/login'));
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

    $mType = isset($mType) ? $mType : 'video';
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
    $stillwatching = $appConfig->app->app_info->still_watching;
    $is_embed = $appConfig->app->is_embed ?? null;
    $playerstillwatchduration = $appConfig->app->app_info->still_watching_duration;
    $status = $arrRes4VideoState['app']['status'];
    if ($status == 1) {
        $streamDurationInSec = $arrRes4VideoState['app']['data']['stream_duration'];
        $seekFunStr = "this.currentTime($streamDurationInSec);";
    }

    // Here Set Ad URL in Session
    $adUrl = $appConfig->app->colors_assets_for_branding->web_site_ad_url;
    if (!session('ADS_INFO')) {
        session([
            'ADS_INFO' => [
                'adUrl' => $appConfig->app->colors_assets_for_branding->web_site_ad_url,
                'channelName' => $appConfig->app->app_info->app_name,
                'domain_name' => $appConfig->app->colors_assets_for_branding->domain_name,
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
    $channelName = urlencode($appConfig->app->app_info->app_name);

    $isLocalHost = false;
    $host = parse_url(url()->current())['host'];
    if (in_array($host, ['localhost', '127.0.0.1'])) {
        $isLocalHost = true;
    }

    //&app_bundle=669112
    //
    $appStoreUrl = urlencode($appConfig->app->colors_assets_for_branding->roku_app_store_url);
    // Use base URL without query (strip e.g. ?hplatform=web); hplatform=web is reattached in JS
    $adUrlBase = preg_replace('/\?.*$/', '', $adUrl);
    $adMacros = $adUrlBase . "?width=1920&height=1080&cb=$cb&" . (!$isLocalHost ? "uip=$userIP&" : '') . "device_id=RIDA&vast_version=2&app_name=$channelName&device_make=ROKU&device_category=5&app_store_url=$appStoreUrl&ua=$userAgent";
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
    $content_rating = $arrSlctItemData['content_rating'] ?? null;
    $advisories = $arrSlctItemData['advisories'] ? implode(', ', array_column($arrSlctItemData['advisories'], 'title')) : null;

    ?>

    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mvp.css') }}" /> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mvp/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mvp/mvp.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    {{-- <script src="{{ asset('assets/js/new.js') }}"></script>
    <script src="{{ asset('assets/js/vast.js') }}"></script>
    <script src="{{ asset('assets/js/share_manager.js') }}"></script>
    <script src="{{ asset('assets/js/cache.js') }}"></script>
    <script src="{{ asset('assets/js/ima.js') }}"></script>
    <script src="{{ asset('assets/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/playlist_navigation.js') }}"></script>
    <script src="{{ asset('assets/js/youtubeLoader.js') }}"></script>
    <script src="{{ asset('assets/js/vimeoLoader.js') }}"></script> --}}
    <script src="{{ asset('assets/js/mvp/new.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/vast.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/share_manager.js') }}"></script>
    <script src="{{ asset('assets/js/cache.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/ima.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/playlist_navigation.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/youtubeLoader.js') }}"></script>
    <script src="{{ asset('assets/js/mvp/vimeoLoader.js') }}"></script>
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
        .content_screen {
            border: 1px var(--themePrimaryTxtColor) solid !important;
        }

        /* Force content-timing to use flexbox for proper wrapping */
        .content-timing {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center;
            gap: 4px;
        }

        /* Safari: Force text to wrap to next line instead of showing ellipsis */
        @supports (-webkit-appearance: none) {
            .content-timing {
                overflow: visible !important;
                text-overflow: clip !important;
                display: flex !important;
                flex-wrap: wrap !important;
                -webkit-line-clamp: unset !important;
                -webkit-box-orient: unset !important;
                gap: 3px !important;
            }

            .content-timing .content_screen,
            .content_screen {
                white-space: normal !important;
                word-break: break-word;
                overflow: visible !important;
                text-overflow: clip !important;
                word-wrap: break-word;
                /* Prevent text cutting at bottom in Safari */
                line-height: 1.5 !important;
                padding-top: 4px !important;
                padding-bottom: 4px !important;
                min-height: auto !important;
                /* Add spacing between elements */
                margin-left: 3px !important;
                /* Ensure border is visible - use same as main style to prevent double border */
                border: 1px var(--themePrimaryTxtColor) solid !important;
            }

            .content-timing .content_screen:first-child,
            .content-timing .content_screen:first-of-type,
            .content_screen:first-child {
                margin-left: 0 !important;
            }
        }

        /* Safari-specific: Force wrapping on next line */
        @media screen and (-webkit-min-device-pixel-ratio: 0) {
            .content-timing {
                overflow: visible !important;
                text-overflow: clip !important;
                display: flex !important;
                flex-wrap: wrap !important;
                -webkit-line-clamp: unset !important;
                -webkit-box-orient: unset !important;
                gap: 3px !important;
            }

            .content-timing .content_screen,
            .content_screen {
                white-space: normal !important;
                word-wrap: break-word;
                overflow: visible !important;
                text-overflow: clip !important;
                /* Prevent text cutting at bottom in Safari */
                line-height: 1.5 !important;
                padding-top: 4px !important;
                padding-bottom: 4px !important;
                min-height: auto !important;
                /* Add spacing between elements */
                margin-left: 3px !important;
                /* Ensure border is visible - use same as main style to prevent double border */
                border: 1px var(--themePrimaryTxtColor) solid !important;
            }

            .content-timing .content_screen:first-child,
            .content-timing .content_screen:first-of-type,
            .content_screen:first-child {
                margin-left: 0 !important;
            }
        }

        /* On small screens, force views to wrap */
        @media (max-width: 768px) {
            .content-timing .content_screen {
                white-space: normal !important;
            }
        }

        .dot-sep:before {
            color: var(--themePrimaryTxtColor) !important;
        }

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
            z-index: 99999999999;
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
        /* .buynow-redirect-message {                                                                                                                                                                                 } */
        .buynow-redirect-message {
            background-color: var(--themeActiveColor);
            color: var(--themePrimaryTxtColor);
            max-width: 1000.89px;
            width: fit-content;
            padding: 0.8rem 1.2rem;
            font-weight: 600;
            border-radius: 2px;
            position: absolute;
            z-index: 1000;
            bottom: 10%;
            height: fit-content;
            left: 7%;
            user-select: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out, visibility 0.5s;
            transform: translateX(-400px);
            opacity: 0;
            visibility: hidden;
        }

        .buy-now-marker {
            position: absolute;
            top: 48%;
            height: 5%;
            width: 4px;
            background-color: #d9ff40;
            transform: translateX(-50%);
            display: block;
            /* Ensure it's shown */
            z-index: 2;
            transition: left 0.2s ease-in-out;
        }

        .buynow-image {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
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
                    <div class="video-player-skeleton"
                        style="background-color: #000; width: 100%; max-width: 1000px; margin: 0 auto; position: relative; overflow: hidden;">
                        <div class="costum-spinner "
                            style="position: absolute; top: 40%; left: 46%; transform: translate(-50%, -50%);"></div>
                        <div style="padding-top: 50%;"></div> <!-- 16:9 aspect ratio -->
                    </div>
                    <div class="videocentalize">
                        @if (strpos($streamUrl, 'https://stream.live.gumlet.io') !== false)
                            <div class="live-video top-right text" style="display: block;">
                                <img src="{{ asset('assets/images/live-video.png') }}" height="30" alt="watermark">
                            </div>
                        @endif
                        <div id="wrapper">
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
                            @if (isset($appConfig->app->global_rating_on_video) &&
                                    $appConfig->app->global_rating_on_video === 1 &&
                                    ($content_rating || $advisories))
                                <div class="advisor-widget global-rating" style="display: none;">
                                    @if ($content_rating)
                                        <p class="advisor-line">RATED {{ $content_rating }}</p>
                                    @endif
                                    @if ($advisories)
                                        <p class="advisor-line">{{ $advisories }}</p>
                                    @endif
                                </div>
                            @endif
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
                                    data-path="{{ $streamUrl }}" data-noapi
                                    data-poster="{{ $arrSlctItemData['stream_poster'] }}"
                                    data-thumb="{{ $arrSlctItemData['stream_poster'] }}"
                                    data-title="{{ $arrSlctItemData['stream_title'] }}"
                                    data-description="{{ $arrSlctItemData['stream_description'] }}"
                                    data-chapters="{{ $arrSlctItemData['chapter'] ?? null }}" {!! $dataVast2 ? $dataVast2 : $dataVast !!}>

                                    @if (count($arrSlctItemData['subtitles'] ?? []))
                                        <div class="mvp-subtitles">
                                            @foreach ($arrSlctItemData['subtitles'] ?? [] as $subtitle)
                                                <div data-label="{{ $subtitle['name'] }}"
                                                    data-src="{{ $subtitle['file_url'] }}"
                                                    @if ($loop->first) data-default @endif></div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="mvp-annotation-section">
                                        @if ($arrSlctItemData['start_duration'])
                                            <div class="mvp-popup" data-show="{{ $arrSlctItemData['start_duration'] }}">
                                                <div class="continue-confirmation-popup">
                                                    <button class="btn" onclick="window.resumeMedia()">
                                                        <svg aria-hidden="true" width="20px" height="20px"
                                                            style="margin-left: -14px;" focusable="false" role="img"
                                                            viewBox="0 0 373.008 373.008">
                                                            <path
                                                                d="M61.792,2.588C64.771,0.864,68.105,0,71.444,0c3.33,0,6.663,0.864,9.655,2.588l230.116,167.2 c5.963,3.445,9.656,9.823,9.656,16.719c0,6.895-3.683,13.272-9.656,16.713L81.099,370.427c-5.972,3.441-13.334,3.441-19.302,0 c-5.973-3.453-9.66-9.833-9.66-16.724V19.305C52.137,12.413,55.818,6.036,61.792,2.588z">
                                                            </path>
                                                        </svg>
                                                        Resume
                                                    </button>
                                                    <hr class="m-0 text-white bg-white">
                                                    <button class="btn" onclick="window.startOverMedia()">
                                                        <svg aria-hidden="true" width="20px" height="20px"
                                                            focusable="false" role="img" viewBox="0 0 512 512">
                                                            <path
                                                                d="M255.545 8c-66.269.119-126.438 26.233-170.86 68.685L48.971 40.971C33.851 25.851 8 36.559 8 57.941V192c0 13.255 10.745 24 24 24h134.059c21.382 0 32.09-25.851 16.971-40.971l-41.75-41.75c30.864-28.899 70.801-44.907 113.23-45.273 92.398-.798 170.283 73.977 169.484 169.442C423.236 348.009 349.816 424 256 424c-41.127 0-79.997-14.678-110.63-41.556-4.743-4.161-11.906-3.908-16.368.553L89.34 422.659c-4.872 4.872-4.631 12.815.482 17.433C133.798 479.813 192.074 504 256 504c136.966 0 247.999-111.033 248-247.998C504.001 119.193 392.354 7.755 255.545 8z">
                                                            </path>
                                                        </svg>
                                                        Start Over
                                                    </button>
                                                </div>
                                            </div>
                                        @endif

                                        @include('playerscreen.includes.call-to-actions', [
                                            'callToActions' => $arrSlctItemData['call_to_actions'],
                                        ])
                                    </div>

                                </div>

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
                        @if ((isset($arrSlctItemData['is_embed']) && $arrSlctItemData['is_embed'] == 1) || $is_embed == 1)
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
                        @if (isset($appConfig->app->content_report) && !empty($appConfig->app->content_report))
                            @foreach ($appConfig->app->content_report as $report)
                                <label class="report-label alert alert-light p-2">
                                    <input type="radio" name="code" value="{{ $report->id }}"
                                        class="mx-2 report-radio small" required>
                                    {{ $report->content_report }}
                                </label>
                            @endforeach
                        @else
                            <div class="alert alert-light">✨ "Oops! No content message available yet. Stay tuned!" ✨</div>
                        @endif

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
            @if (isset($streamratingstatus) && $streamratingstatus == 1)
                <div class="tab" data-tab="reviews"><span>Reviews</span></div>
            @endif
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
                                @if (isset($arrSlctItemData['title_logo'], $arrSlctItemData['show_title_logo']) &&
                                        $arrSlctItemData['title_logo'] &&
                                        $arrSlctItemData['show_title_logo'] == 1)
                                    <div class="title_logo mb-1">
                                        <img class="img-fluid" src="{{ $arrSlctItemData['title_logo'] }}"
                                            alt="{{ $arrSlctItemData['stream_title'] ?? 'Logo' }}">
                                    </div>
                                @else
                                    <h1 class="content-heading themePrimaryTxtColr">{{ $arrSlctItemData['stream_title'] }}
                                    </h1>
                                @endif
                                <div class="content-timing themePrimaryTxtColr">
                                    @if ($arrSlctItemData['released_year'])
                                        <a href="{{ route('year', $arrSlctItemData['released_year']) }}"
                                            class="text-decoration-none">
                                            <span
                                                class="year themePrimaryTxtColr">{{ $arrSlctItemData['released_year'] }}</span>
                                        </a>
                                        <span class="dot-sep themePrimaryTxtColr"></span>
                                    @endif
                                    @if ($arrSlctItemData['stream_duration'] && $arrSlctItemData['stream_duration'] !== '0')
                                        <span
                                            class="themePrimaryTxtColr">{{ \App\Helpers\GeneralHelper::showDurationInHourAndMins($arrSlctItemData['stream_duration']) }}</span>
                                        <span class="dot-sep themePrimaryTxtColr"></span>
                                    @endif
                                    @if ($streamType == 'S')
                                        @if ($arrSlctItemData['show_name'])
                                            <a class="text-decoration-none"
                                                href="{{ route('series', $arrSlctItemData['show_guid']) }}">
                                                <span class="movie_type">{{ $arrSlctItemData['show_name'] }}</span>
                                            </a>
                                        @endif
                                        @if ($arrSlctItemData['stream_episode_title'])
                                            <span
                                                class="movie_type">{{ $arrSlctItemData['stream_episode_title'] && $arrSlctItemData['stream_episode_title'] !== 'NULL' ? $arrSlctItemData['stream_episode_title'] : '' }}</span>
                                        @endif
                                    @endif
                                    {{-- <span class="movie_type">{{ $arrSlctItemData['cat_title'] }}</span> --}}
                                    @if ($arrSlctItemData['genre'])
                                        <span class="movie_type themePrimaryTxtColr">
                                            @foreach ($arrSlctItemData['genre'] ?? [] as $item)
                                                <a href="{{ route('category', $item['code']) }}?type=genre"
                                                    class="px-0 themePrimaryTxtColr">{{ $item['title'] }}</a>{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        </span>
                                    @endif
                                    @if ($arrSlctItemData['content_qlt'] != '')
                                        <span class="content_screen themePrimaryTxtColr">
                                            @php
                                                $content_qlt_arr = explode(',', $arrSlctItemData['content_qlt']);
                                                $content_qlt_codes_arr = explode(
                                                    ',',
                                                    $arrSlctItemData['content_qlt_codes'],
                                                );
                                            @endphp
                                            @foreach ($content_qlt_arr as $i => $item)
                                                <a class="themePrimaryTxtColr"
                                                    href="{{ route('quality', trim($content_qlt_codes_arr[$i])) }}">{{ $item }}</a>
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </span>
                                    @endif
                                    @if ($arrSlctItemData['content_rating'] != '')
                                        <span class="content_screen themePrimaryTxtColr">
                                            @php
                                                $content_rating_arr = explode(',', $arrSlctItemData['content_rating']);
                                                $content_rating_codes_arr = explode(
                                                    ',',
                                                    $arrSlctItemData['content_rating_codes'],
                                                );
                                            @endphp
                                            @foreach ($content_rating_arr as $i => $item)
                                                <a class="themePrimaryTxtColr"
                                                    href="{{ route('rating', trim($content_rating_codes_arr[$i])) }}">{{ $item }}</a>
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </span>
                                    @endif
                                    @php
                                        $views =
                                            $arrSlctItemData['views'] ??
                                            ($arrSlctItemData['total_views'] ??
                                                ($arrSlctItemData['view_count'] ??
                                                    ($arrRes['app']['stream_details']['views'] ??
                                                        ($arrRes['app']['stream_details']['total_views'] ??
                                                            ($arrRes['app']['stream_details']['view_count'] ?? 0)))));
                                    @endphp
                                    @if ($views > 0)
                                        <span class="content_screen themePrimaryTxtColr">
                                            <i class="bi bi-eye" style="margin-right: 4px;"></i>
                                            {{ \App\Helpers\GeneralHelper::formatViews($views) }}
                                        </span>
                                    @endif
                                    @if ($ratingsCount > 0)
                                        @if (isset($streamratingtype, $streamratingstatus) && $streamratingtype === 'stars' && $streamratingstatus == 1)
                                            <span class="content_screen themePrimaryTxtColr">
                                                <div class="star active" style="display: inline-flex;">
                                                    <svg fill="#ffffff" width="15px" height="15px"
                                                        viewBox="0 0 32 32" version="1.1"
                                                        xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
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
                                                {{ $averageRating ?? 0 }}
                                            </span>
                                        @elseif(isset($streamratingtype, $streamratingstatus) && $streamratingtype === 'hearts' && $streamratingstatus == 1)
                                            <span class="content_screen themePrimaryTxtColr">
                                                <div class="star active" style="display: inline-flex;">
                                                    <svg fill="#ffffff" width="15px" height="15px"
                                                        viewBox="0 0 32 32" version="1.1"
                                                        xmlns="http://www.w3.org/2000/svg" stroke="#545454">
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
                                                {{ $averageRating ?? 0 }}
                                            </span>
                                        @elseif(isset($streamratingtype, $streamratingstatus) && $streamratingtype === 'thumbs' && $streamratingstatus == 1)
                                            <span class="content_screen themePrimaryTxtColr">
                                                <div class="star active" style="display: inline-flex; rotate: 180deg">
                                                    <svg fill="#6e6e6e" width="15px" height="15px" version="1.1"
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
                                                {{ $averageRating ?? 0 }}
                                            </span>
                                        @elseif (isset($appConfig->app->app_info->global_rating_enable, $appConfig->app->app_info->global_rating_type) &&
                                                $appConfig->app->app_info->global_rating_enable == 1 &&
                                                $appConfig->app->app_info->global_rating_type === 'stars')
                                            <span class="content_screen themePrimaryTxtColr">
                                                <div class="star active" style="display: inline-flex;">
                                                    <svg fill="#ffffff" width="15px" height="15px"
                                                        viewBox="0 0 32 32" version="1.1"
                                                        xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
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
                                                {{ $averageRating ?? 0 }}
                                            </span>
                                        @elseif (isset($appConfig->app->app_info->global_rating_enable, $appConfig->app->app_info->global_rating_type) &&
                                                $appConfig->app->app_info->global_rating_enable == 1 &&
                                                $appConfig->app->app_info->global_rating_type === 'hearts')
                                            <span class="content_screen themePrimaryTxtColr">
                                                <div class="star active" style="display: inline-flex;">
                                                    <svg fill="#ffffff" width="15px" height="15px"
                                                        viewBox="0 0 32 32" version="1.1"
                                                        xmlns="http://www.w3.org/2000/svg" stroke="#545454">
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
                                                {{ $averageRating ?? 0 }}
                                            </span>
                                        @else
                                            {{-- Thumbs  --}}
                                            <span class="content_screen themePrimaryTxtColr">
                                                <div class="star active" style="display: inline-flex; rotate: 180deg"
                                                    onclick="handleStarRating(this)">
                                                    <svg fill="#6e6e6e" width="15px" height="15px" version="1.1"
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
                                                {{ $averageRating ?? 0 }}
                                            </span>
                                        @endif
                                    @endif
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
                                        class="{{ $cls }} theme-active-color"></i></a>
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
                                <a href="javascript:void(0);"><i class="fa fa-share theme-active-color"></i></a>
                            </div>
                            @if (isset($appConfig->app->app_info->report) && $appConfig->app->app_info->report === 1)
                                <div class="share_circle addWtchBtn" data-bs-toggle="modal"
                                    data-bs-target="#reportModalCenter">
                                    @if (session('USER_DETAILS') && isset(session('USER_DETAILS')['USER_CODE']))
                                        <a href="javascript:void(0);"><i
                                                class="fa fa-triangle-exclamation theme-active-color"></i></a>
                                    @endif
                                </div>
                            @endif
                            @if (isset($appConfig->app->badge_status) && $appConfig->app->badge_status === 1)
                                @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'])
                                    @if (isset($arrSlctItemData['gamified_content']) && $arrSlctItemData['gamified_content'] == 1)
                                        <div class="share_circle addWtchBtn">
                                            <a href="{{ route('user.badge') }}" data-bs-toggle="tooltip"
                                                title="Gamified Content">
                                                <i class="fa-solid fa-award theme-active-color"></i>
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            @endif
                            @if (session('USER_DETAILS') &&
                                    session('USER_DETAILS')['USER_CODE'] &&
                                    isset($appConfig->app->frnd_option_status) &&
                                    $appConfig->app->frnd_option_status === 1)
                                <div class="share_circle addWtchBtn" data-bs-toggle="modal"
                                    data-bs-target="#recommendation">
                                    <a href="javascript:void(0);" role="button" data-bs-toggle="tooltip"
                                        title="Recommendations">
                                        <i class="fa-solid fa-film theme-active-color"></i>
                                    </a>
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
            <div class="like-tab-slider-container" data-stream-guid="{{ $arrSlctItemData['stream_guid'] ?? '' }}">
                @include('detailscreen.partials.skeleton-slider')
            </div>
        </div>
        @if (isset($streamratingstatus) && $streamratingstatus == 1)
            <div id="reviews" class="content d-none"><!--Start of Ratings section-->
                <div class="item-ratings">
                    <h1 class="section-title" style="display: flex; align-items: center; gap: 10px;">
                        Reviews:
                        <div id="rating-icon-playerscreen">
                            @include('playerscreen.includes.rating-icon', [
                                'ratingsCount' => $ratingsCount,
                            ])
                        </div>
                        <span class="average-rating">{{ $averageRating ?? '' }} </span>
                    </h1>
                    @php
                        // Ensure $streamrating is an array before using it
                        $ratings = !empty($streamrating) && is_array($streamrating) ? $streamrating : [];

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
                                break; // Exit loop early if found
                            }
                        }
                    @endphp
                    {{--  @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null && !$userDidComment && !$userDidComment)  --}}

                    @if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE'] !== null)
                        {{-- Stars  --}}
                        @if (isset($streamratingtype, $streamratingstatus) && $streamratingtype === 'stars' && $streamratingstatus == 1)
                            <div class="review-rating user-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="star" data-rating="{{ $i }}"
                                        onclick="handleStarRating(this)">
                                        <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
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
                                @endfor
                            </div>
                        @elseif(isset($streamratingtype, $streamratingstatus) && $streamratingtype === 'hearts' && $streamratingstatus == 1)
                            {{-- Hearts  --}}
                            <div class="review-rating user-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="star" data-rating="{{ $i }}"
                                        onclick="handleStarRating(this)">
                                        <svg fill="#ffffff" width="27px" height="27px" viewBox="0 0 32 32"
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
                                @endfor
                            </div>
                        @elseif(isset($streamratingtype, $streamratingstatus) && $streamratingtype === 'thumbs' && $streamratingstatus == 1)
                            {{-- Thumbs  --}}
                            <div class="review-rating user-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="star" data-rating="{{ $i }}" style="rotate: 180deg"
                                        onclick="handleStarRating(this)">
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
                                @endfor
                            </div>
                        @else
                            {{-- Thumbs  --}}
                            <div class="review-rating user-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="star" data-rating="{{ $i }}" style="rotate: 180deg"
                                        onclick="handleStarRating(this)">
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
                                @endfor
                            </div>
                        @endif

                        <span class="text-danger">
                            @error('rating')
                                {{ $message }}
                            @enderror
                        </span>
                        <div id="messageContainer" style="display: none;"></div>
                        <form id="ratingForm" action="{{ route('addrating.playerscreen') }}" method="POST">
                            @csrf
                            <textarea name="comment" cols="30" rows="10" placeholder="Let others know what you think..."></textarea>
                            <input type="hidden" name="rating" id="hiddenRating">
                            <input type="hidden" name="stream_code" value="{{ $arrSlctItemData['stream_guid'] }}">
                            <input type="hidden" name="type" value="stream">
                            {{-- <input class="rounded" type="submit" id="submitButton" value="Submit"> --}}
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
                        @include('playerscreen.includes.review', ['reviews' => $streamrating])

                    </div>
                </div>

            </div>
        @endif




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
    {{-- coupon modal --}}
    @if (
        !empty($arrSlctItemData['coupon_code']) &&
            isset($appConfig->app->badge_status) &&
            $appConfig->app->badge_status === 1)
        <div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="centeredModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered"> <!-- Centering class -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="centeredModalLabel">
                            {{ $arrSlctItemData['coupon_code'][0]['title'] }}
                            <small class="text-muted" style="font-size: 0.8rem;">
                                (Disappears in <span id="countdown"></span>s)
                            </small>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="couponForm">
                            @csrf
                            <input type="hidden" id="stream_code"
                                value="{{ $arrSlctItemData['coupon_code'][0]['stream_code'] }}">
                            <input type="hidden" id="coupon_id"
                                value="{{ $arrSlctItemData['coupon_code'][0]['code'] }}">
                            <div class="mb-3">
                                <label for="couponCode" class="form-label">Enter Code</label>
                                <input type="text" class="form-control bg-white text-dark" id="couponCode"
                                    placeholder="Enter your coupon code">
                                <div id="coupon_code_error" class="text-danger mt-1" style="font-size: 0.875rem;"></div>
                            </div>
                            <div class="d-grid">
                                <button type="button" class="btn btn-primary" id="applyCouponBtn">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
    {{-- Recommendation Modal --}}
    <div class="modal fade" id="recommendation" tabindex="-1" aria-labelledby="recommendationLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add to Friends Recommendation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="recommendationForm">
                        @csrf
                        @if (isset($arrRes['app']['fav_freinds']) && !empty($arrRes['app']['fav_freinds']))
                            <div class="col-lg-12">
                                <input type="hidden" name="stream_code" value="{{ $arrSlctItemData['stream_guid'] }}">
                                <input type="hidden" name="type" value="M">
                                <label for="text" class="form-label">Select Favorite Friends:</label>
                                <select name="fav_friends[]" id="fav_friends" class="select2-multiple"
                                    multiple="multiple">
                                    <option disabled>{{ __('Select') }}</option>
                                    @foreach ($arrRes['app']['fav_freinds'] as $friend)
                                        <option value="{{ $friend['code'] }}">{{ $friend['name'] }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger d-none" id="fav_friends_error"></span>
                            </div>
                            <button type="submit" id="submitRecommendation" class="app-primary-btn rounded my-2">
                                <span class="button-text">Send</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        @else
                            <h6 class="title">No Favorite Friend Found!</h6>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (($appConfig->app->adblock_protection ?? 'N') === 'Y')
        <script>
            document.addEventListener('DOMContentLoaded', async () => {
                async function isAdBlocked() {
                    try {
                        // Try fetching a known ad resource (something ad blockers would normally block)
                        const res = await fetch(
                            'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js', {
                                method: 'HEAD',
                                mode: 'no-cors',
                            });
                        // If fetch resolves, blocker allowed it (rare); if rejected → blocked
                        return false;
                    } catch (err) {
                        return true;
                    }
                }

                const blocked = await isAdBlocked();
                if (blocked) {
                    const player = document.getElementById('mvp_player_container');
                    if (player) {
                        player.style.pointerEvents = 'none';
                        player.style.opacity = '0.3';
                    }
                    Swal.fire({
                        title: '🚫  Ad Blocker Detected',
                        html: `<p style="font-size:16px;">It looks like your browser is blocking our ad requests. Please disable your ad blocker and refresh the page to continue watching.</p>`,
                        icon: 'warning',
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#e74c3c',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        background: '#1e1e1e',
                        color: '#fff'
                    }).then(() => location.reload());
                }
            });
        </script>
    @endif
    <script>
        let is_active = true;
        let global_rating_active = true; // Reflecting your disabled global rating
        let global_rating_duration = "{{ \App\Services\AppConfig::get()->app->global_rating_on_video_duration ?? 5 }}";
        document.addEventListener("DOMContentLoaded", async function(event) {
            const widget = document.querySelector(".advisor-widget");
            if (widget) {
                const isTopLeft =
                    "{{ isset($watermark['position']) && $watermark['position'] == 'top-left' ? 'true' : 'false' }}";
                if (isTopLeft === 'true') {
                    const screenWidth = window.innerWidth;
                    if (screenWidth < 600) {
                        widget.style.top = "45px";
                    } else if (screenWidth >= 600 && screenWidth < 992) {
                        widget.style.top = "50px";
                    } else if (screenWidth >= 992 && screenWidth < 1200) {
                        widget.style.top = "70px";
                    } else {
                        widget.style.top = "80px";
                    }
                } else {
                    widget.style.top = "12px";
                }
            }

            await watiForPlaylistFetch();
            const playlistloader = document.querySelector('.video-player-skeleton');
            playlistloader.style.display = 'none';
            var isshowlist = true;
            var pListPostion = detectMob() ? 'hb' : 'vrb';
            var settings = {
                skin: 'sirius',
                aspectRatio: 1,
                playlistPosition: pListPostion,
                vimeoPlayerType: "chromeless",
                youtubePlayerType: "chromeless",
                sourcePath: "",
                activeItem: 0,
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
                usePip: true,
                useCc: true,
                useAirPlay: true,
                usePlaybackRate: true,
                useNext: true,
                usePrevious: true,
                useRewind: true,
                useSkipBackward: true,
                useSkipForward: true,
                showPrevNextVideoThumb: true,
                rememberPlaybackPosition: 'all',
                useQuality: true,
                useImaLoader: true,
                useTheaterMode: true,
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
                ]
            };

            window.player = new mvp(document.getElementById('wrapper'), settings);
            setTimeout(unmutedVoice, 2000);
            let playerstillwatch = "<?php echo $stillwatching; ?>";
            let playerstillwatchduration = "<?php echo $playerstillwatchduration; ?>";
            if (playerstillwatch && playerstillwatch == "1") {
                window.setInterval(function() {
                    pauseVideo();
                }, 5000);
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
                if (number !== 0 && number % parseInt(playerstillwatchduration) === 0) {
                    playerstillwatchduration + playerstillwatchduration;
                    return true;
                }
                return false;
            }

            @if ($redirectUrl)
                const trial = getTrial();
                trial.onRedirect(() => {
                    player.pauseMedia();
                    player.destroyMedia();
                    window.location.href = '{{ $redirectUrl }}';
                });
            @endif

            var isFirstTIme = true;
            player.addEventListener('mediaStart', function(data) {
                window.adplay = false;
                data.instance.getCurrentTime();
                data.instance.getDuration();
                if (isFirstTIme == true) {
                    isFirstTIme = false;
                    player.seek({{ $arrSlctItemData['start_duration'] }});
                } else {
                    sendAjaxRes4VideoDuration('getStrmDur', data.media.mediaId, '');
                }

                let liveVideo = document.querySelector('.live-video');
                if (liveVideo) {
                    liveVideo.style.display = "block";
                }

                showWatermark();
                showGlobalRating();
                showOverlayAd();
                detectPopupEvent();
                makeVolumeButtontoggable();

                if (global_rating_active == true && widget) {
                    function checkAndShowGolobalRating() {
                        let currentTime = Math.floor(player.getCurrentTime());
                        if (currentTime > global_rating_duration) {
                            hideGlobalRating();
                            global_rating_active = false;
                        } else {
                            let seconds = global_rating_duration;
                            if (currentTime === seconds) {
                                hideGlobalRating();
                                global_rating_active = false;
                            }
                        }
                    }
                    setInterval(checkAndShowGolobalRating, 1000);
                }
            });

            @if (!empty($arrSlctItemData['buynow']))
                @php
                    $buynows = $arrSlctItemData['buynow'];
                @endphp
            @endif
            window.displayedBuyNow = [];
            player.addEventListener("mediaPlay", function(data) {
                window.adplay = false;
                @if ($redirectUrl)
                    trial.start();
                    document.querySelector('.mvp-input-progress').disabled = true;
                    document.querySelector('.mvp-skip-backward-toggle').disabled = true;
                    document.querySelector('.mvp-skip-forward-toggle').disabled = true;
                    document.querySelector('.mvp-rewind-toggle').disabled = true;
                @endif

                showWatermark();
                showOverlayAd();
                showGlobalRating();

                @if (!empty($arrSlctItemData['buynow']))
                    let buyNowData = @json($arrSlctItemData['buynow']);

                    function checkAndShowBuyNowMessage() {
                        let currentTime = Math.floor(data.instance.getCurrentTime());
                        buyNowData.forEach((buynow, index) => {
                            const timeOffsetStr = String(buynow.time_offset);
                            const timeParts = timeOffsetStr.split('.');
                            const hours = parseInt(timeParts[0], 10) || 0;
                            const minutes = parseInt(timeParts[1], 10) || 0;
                            const seconds = parseInt(timeParts[2], 10) || 0;
                            const milliseconds = parseInt(timeParts[3], 10) || 0;
                            let timeOffset = (hours * 3600) + (minutes * 60) + seconds;
                            if (currentTime >= timeOffset && !displayedBuyNow.includes(index)) {
                                const buyNowMessageBox = document.querySelector(
                                    '.buynow-redirect-message');
                                if (buynow.name) {
                                    buyNowMessageBox.innerHTML =
                                        `${buynow.name}<span class="time"></span>`;
                                } else if (buynow.img_url) {
                                    buyNowMessageBox.innerHTML =
                                        `<img src="${buynow.img_url}" alt="Buy Now" class="buynow-image" />`;
                                }
                                buyNowMessageBox.style.opacity = "1";
                                buyNowMessageBox.style.visibility = "visible";
                                buyNowMessageBox.style.transform = "translateX(0)";
                                displayedBuyNow.push(index);
                                setTimeout(() => {
                                    hideBuyNowMessage(buyNowMessageBox);
                                }, 10000);
                                buyNowMessageBox.onclick = () => {
                                    if (buynow.source_type === "external" && buynow
                                        .external_link) {
                                        window.open(buynow.external_link, '_blank');
                                    } else if (buynow.source_type === "internal" && buynow
                                        .stream_url) {
                                        let internalUrl =
                                            `{{ url('/playerscreen') }}/${buynow.stream_url}`;
                                        window.open(internalUrl, '_blank');
                                    }
                                    hideBuyNowMessage(buyNowMessageBox);
                                };
                            }
                        });
                    }

                    function hideBuyNowMessage(element) {
                        element.style.opacity = "0";
                        element.style.visibility = "hidden";
                        element.style.transform = "translateX(-400px)";
                    }
                    setInterval(checkAndShowBuyNowMessage, 1000);
                @endif

                if (is_active == true) {
                    @if (!empty($arrSlctItemData['coupon_code']))
                        let couponData = @json($arrSlctItemData['coupon_code']);
                        const couponModalEl = document.getElementById('couponModal');
                        const couponModal = new bootstrap.Modal(couponModalEl);
                        let couponDisplayed = false;

                        function checkAndShowCouponCode() {
                            if (couponDisplayed || couponData.length === 0) return;
                            let currentTime = Math.floor(player.getCurrentTime());
                            let showAt = timeStringToSeconds(couponData[0].load_time);
                            if (currentTime === showAt) {
                                couponModal.show();
                                couponDisplayed = true;
                                let seconds = 15;
                                $('#countdown').text(seconds);
                                let countdownInterval = setInterval(() => {
                                    seconds--;
                                    $('#countdown').text(seconds);
                                    if (seconds <= 0) {
                                        clearInterval(countdownInterval);
                                        is_active = false;
                                        couponModal.hide();
                                    }
                                }, 1000);
                            }
                        }
                        setInterval(checkAndShowCouponCode, 1000);
                    @endif
                }
                if (global_rating_active == true && widget) {
                    function checkAndShowGolobalRating() {
                        let currentTime = Math.floor(player.getCurrentTime());
                        if (currentTime > global_rating_duration) {
                            hideGlobalRating();
                            global_rating_active = false;
                        } else {
                            let seconds = global_rating_duration;
                            if (currentTime === seconds) {
                                hideGlobalRating();
                                global_rating_active = false;
                            }
                        }
                    }
                    setInterval(checkAndShowGolobalRating, 1000);
                }
            });

            function timeStringToSeconds(timeStr) {
                const parts = timeStr.split(':').map(Number);
                let seconds = 0;
                if (parts.length === 3) {
                    seconds = parts[0] * 3600 + parts[1] * 60 + parts[2];
                } else if (parts.length === 2) {
                    seconds = parts[0] * 60 + parts[1];
                } else if (parts.length === 1) {
                    seconds = parts[0];
                }
                return seconds;
            }

            player.addEventListener("mediaPause", function(data) {
                sendAjaxRes4VideoDuration('saveStrmDur', data.media.mediaId, data.instance
                    .getCurrentTime());
                @if ($redirectUrl)
                    trial.pause();
                @endif
            });

            player.addEventListener("mediaEnd", function(data) {
                sendAjaxRes4VideoDuration('removeStrmDur', data.media.mediaId, '');
            });

            player.addEventListener("adPlay", function(data) {
                window.adplay = true;
                let liveVideo = document.querySelector('.live-video');
                if (liveVideo) {
                    liveVideo.style.display = "none";
                }
                hideWatermark();
                hideGlobalRating();
                hideOverlayAd();
                if (player.getMediaPlaying()) {
                    player.pauseMedia();
                }
            });

            window.resumeMedia = function() {
                player.closePopup();
                setTimeout(() => player.playMedia(), 500);
            }

            window.startOverMedia = function() {
                player.closePopup();
                player.seek(0);
                setTimeout(() => player.playMedia(), 500);
            }

        });

        document.body.addEventListener("click", function(evt) {
            if (window.player && player.getMediaPlaying()) {
                mediaId = player.getCurrentMediaData().mediaId;
                sendAjaxRes4VideoDuration('saveStrmDur', mediaId, player.getCurrentTime());
            }
        });

        function unmutedVoice() {
            player.toggleMute();
            player.playMedia();
            setInterval(sendAdRequrst, 50000);
        }

        function sendAdRequrst() {
            $.get("<?php echo $dataVast3 ?? ''; ?>", function(data, status) {});
        }

        function showOverlayAd() {
            if (!$('.overlay-ad').hasClass('closed') && window.adplay == false) {
                $('.overlay-ad').removeClass('d-none');
                console.log('[DEBUG] showOverlayAd: adplay=', window.adplay);
            }
        }

        function hideOverlayAd() {
            $('.overlay-ad').addClass('d-none');
            console.log('[DEBUG] hideOverlayAd: adplay=', window.adplay);
        }

        function closeOverlayAd() {
            $('.overlay-ad').addClass('d-none');
            $('.overlay-ad').addClass('closed');
        }

        function overlayAdClick() {
            player.pauseMedia();
        }

        function showWatermark() {
            if (window.adplay == false) {
                let watermark = document.querySelector('.watermark');
                if (watermark) {
                    watermark.style.display = "block";
                    console.log('[DEBUG] showWatermark: Showing watermark, adplay=', window.adplay);
                }
            }
        }

        function hideWatermark() {
            let watermark = document.querySelector('.watermark');
            if (watermark) {
                watermark.style.display = "none";
                console.log('[DEBUG] hideWatermark: Hiding watermark');
            }
        }

        function showGlobalRating() {
            if (window.adplay == false) {
                let globalRating = document.querySelector('.global-rating');
                if (globalRating) {
                    globalRating.style.display = "block";
                    console.log('[DEBUG] showGlobalRating: Showing global-rating, adplay=', window.adplay);
                }
            }
        }

        function hideGlobalRating() {
            let globalRating = document.querySelector('.global-rating');
            if (globalRating) {
                globalRating.style.display = "none";
                console.log('[DEBUG] hideGlobalRating: Hiding global-rating');
            }
        }

        function detectPopupEvent() {
            let eventHappening = false;
            let startTime = 0;
            setInterval(() => {
                ++startTime;
                if ($('.mvp-popup-holder .mvp-popup').hasClass('mvp-popup-visible') && $(
                        '.mvp-popup-holder .mvp-popup-visible').find('.continue-confirmation-popup')
                    .length === 0) {
                    if (eventHappening === false) {
                        blockPopup(startTime);
                        hideOverlayAd();
                        hideWatermark();
                        hideGlobalRating();
                        eventHappening = true;
                    }
                } else {
                    if (eventHappening === true) {
                        showOverlayAd();
                        showWatermark();
                        showGlobalRating();
                        eventHappening = false;
                    }
                }
            }, 500);
        }

        function blockPopup(startTime) {
            if (startTime > 30) return;
            let isPopupPaused = $('.mvp-popup-holder .mvp-popup-visible').data('show') === 'pause';
            player.closePopup();
            setTimeout(() => {
                if (!isPopupPaused) {
                    player.playMedia();
                }
            }, 500);
        }

        function makeVolumeButtontoggable() {
            $('.mvp-volume-toggle').addClass('mvp-volume-toggable');
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
                    if (this.readyState == 4 && this.status == 200) {}
                };
                xhttp.open("POST", "<?php echo $apiPath; ?>", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.setRequestHeader("happcode", "{{ env('APP_CODE') }}");
                xhttp.setRequestHeader("husercode", "{{ session('USER_DETAILS.USER_CODE') }}");
                xhttp.setRequestHeader("hplatform", "web");
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
                headers: {
                    'happcode': '{{ env('APP_CODE') }}',
                },
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

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        var themeActiveColor = "{{ \App\Services\AppConfig::get()->app->website_colors->themeActiveColor }}";

        function handleStarRating(element) {
            let rating = element.dataset.rating;
            let starsWrapper = document.getElementsByClassName("user-rating")[0];
            let stars = starsWrapper.getElementsByClassName("star");
            let ratingField = document.getElementsByName("rating")[0];

            for (let i = 0; i < stars.length; i++) {
                if (stars[i].classList.contains("active"))
                    stars[i].classList.remove("active")
            }

            for (let i = 0; i < rating; i++) {
                if (!stars[i].classList.contains("active"))
                    stars[i].classList.add("active")
            }

            ratingField.value = parseInt(rating);
        }

        function handleHeartRating(element) {
            var heart = element.getAttribute('data-rating');
            var newRating = heart == 1 ? 0 : 1;

            if (newRating == 1) {
                element.setAttribute('data-rating', 1);
                element.querySelector('svg').style.fill = themeActiveColor; // Change to hearted color
            } else {
                element.setAttribute('data-rating', 0);
                element.querySelector('svg').style.fill = '#ffffff'; // Change to unhearted color
            }
            document.getElementById('hiddenRating').value = newRating;

        }

        function handleRating(element, type) {
            var likeButton = document.querySelector('.like');
            var dislikeButton = document.querySelector('.dislike');
            var hiddenRating = document.getElementById('hiddenRating');
            var isLike = type === 'like';

            if (isLike) {
                likeButton.querySelector('svg').style.fill = themeActiveColor; // Change to liked color
                dislikeButton.querySelector('svg').style.fill = '#6e6e6e'; // Reset dislike button color
                hiddenRating.value = 5; // Set hidden input value to 1 for like
            } else {
                dislikeButton.querySelector('svg').style.fill = themeActiveColor; // Change to disliked color
                likeButton.querySelector('svg').style.fill = '#6e6e6e'; // Reset like button color
                hiddenRating.value = 1; // Set hidden input value to 0 for dislike
            }
        }


        function submitOnce() {
            document.getElementById('submitButton').disabled = true;
            return true;
        }
    </script>

    <script>
        $(document).on('submit', '#ratingForm', function(e) {
            e.preventDefault(); // Prevent form submission

            const form = $(this);
            const formData = form.serialize();
            const submitButton = form.find('button[type="submit"]');
            const buttonText = submitButton.find('.button-text');
            const spinner = submitButton.find('.spinner-border');

            // Disable the button and show spinner
            submitButton.prop('disabled', true);
            // buttonText.hide();
            spinner.show();

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#messageContainer').html('').fadeOut();
                    if (response.success) {
                        $('.member-reviews').html(response.newReviewHtml);

                        if (response.totalReviews > 0) {
                            $('no-reviews-msg').hide();
                        } else {
                            $('no-reviews-msg').show();
                        }

                        if (response.averageRating !== undefined) {
                            $('.section-title .ratings-count').text(`(${response.averageRating})`);
                        }
                        // Update average rating
                        if (response.averageRating !== undefined) {
                            $('.section-title .average-rating').text(`${response.averageRating}`);
                        }
                        if (response.ratingIconHtml !== undefined) {
                            $('#rating-icon-playerscreen').html(response.ratingIconHtml);
                        }
                        form[0].reset();
                        $('#messageContainer').html(
                                `<div style="color: var(--themeActiveColor);">Review added.</div>`)
                            .fadeIn();
                        setTimeout(function() {
                            $('#messageContainer').fadeOut();
                        }, 3000);
                    }
                },
                error: function(xhr) {
                    const errorMessages = xhr.responseJSON.errors;
                    const errorMessage = errorMessages.rating ? errorMessages.rating[0] :
                        'An error occurred. Please try again later.';
                    // Display the error message
                    $('#messageContainer').html(
                        `<div style="color: var(--themeActiveColor);">${errorMessage}</div>`
                    ).fadeIn();
                    setTimeout(function() {
                        $('#messageContainer').fadeOut();
                    }, 3000);
                },
                complete: function() {
                    // Re-enable the button and hide spinner
                    submitButton.prop('disabled', false);
                    buttonText.show();
                    spinner.hide();
                }
            });
        });
    </script>


    <script>
        // Initialize Select2
        $('.select2-multiple').select2({
            placeholder: "Select favorite friends",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#recommendation')
        });
    </script>
    <script>
        $(document).on('submit', '#recommendationForm', function(e) {
            e.preventDefault();

            let form = $(this);
            let button = $('#submitRecommendation');
            let buttonText = button.find('.button-text');
            let spinner = button.find('.spinner-border');

            // Show spinner and disable button
            button.prop('disabled', true);
            spinner.removeClass('d-none');
            buttonText.text('Sending...');

            $.ajax({
                url: "{{ route('recommendation.store') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form.serialize(),
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: "success",
                            title: response.message,
                        }).then(() => {
                            // Hide the modal after Swal confirmation
                            $('#recommendation').modal('hide');
                            form[0].reset(); // Reset form
                        });
                    } else {
                        Swal.fire({
                            icon: "warning",
                            title: response.message,
                        }).then(() => {
                            // Hide the modal after Swal confirmation
                            $('#recommendation').modal('hide');
                            form[0].reset(); // Reset form
                        });
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    if (errors && errors.fav_friends) {
                        $('#fav_friends_error').text(errors.fav_friends[0]).removeClass('d-none');
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Something went wrong! Please try again.",
                        });
                    }
                },
                complete: function() {
                    // Hide spinner, enable button, restore text
                    spinner.addClass('d-none');
                    button.prop('disabled', false);
                    buttonText.text('Send');
                }
            });
        });
    </script>

    <script>
        const adMacros = @js($adMacros . '&hplatform=web');
        const isMobileBrowser = @js($isMobileBrowser);
        const dataVast2 = @js($dataVast2);
        // Function to initialize Slick sliders
        function initializeSlider(container) {
            const sliderElements = jQuery(container).find(
                '.slick-slider:not(.slick-initialized), .landscape_slider:not(.slick-initialized)');
            if (sliderElements.length && typeof jQuery !== 'undefined' && jQuery.fn.slick) {
                sliderElements.each(function() {
                    const $slider = jQuery(this);
                    const itemsPerRow = parseInt($slider.data('items-per-row')) || 5;
                    const autoplay = $slider.data('autoplay') === false;
                    $slider.slick({
                        slidesToShow: itemsPerRow,
                        slidesToScroll: 1,
                        autoplay: autoplay,
                        infinite: true,
                        dots: true,
                        arrows: true,
                        adaptiveHeight: true,
                        responsive: [{
                                breakpoint: 1740,
                                settings: (itemsPerRow == 2) ? {
                                    slidesToShow: 2,
                                    slidesToScroll: 1,
                                    swipeToSlide: true,
                                    arrows: true
                                } : {
                                    slidesToShow: Math.max(itemsPerRow - 1, 1),
                                    slidesToScroll: 1,
                                    swipeToSlide: true,
                                    dots: true,
                                    arrows: true
                                }
                            },
                            {
                                breakpoint: 1200,
                                settings: (itemsPerRow == 2) ? {
                                    slidesToShow: 2,
                                    slidesToScroll: 1,
                                    swipeToSlide: true,
                                    arrows: false
                                } : {
                                    slidesToShow: Math.max(itemsPerRow - 1, 1),
                                    slidesToScroll: 1,
                                    swipeToSlide: true,
                                    dots: true,
                                    arrows: false
                                }
                            },
                            {
                                breakpoint: 770,
                                settings: (itemsPerRow == 2) ? {
                                    slidesToShow: 2,
                                    slidesToScroll: 1,
                                    swipeToSlide: true,
                                    arrows: false
                                } : {
                                    slidesToShow: Math.max(itemsPerRow - 1, 1),
                                    slidesToScroll: 1,
                                    swipeToSlide: true,
                                    dots: true,
                                    arrows: false
                                }
                            },
                            {
                                breakpoint: 600,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 1,
                                    swipeToSlide: true,
                                    arrows: false
                                }
                            },
                            {
                                breakpoint: 480,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 1,
                                    swipeToSlide: true,
                                    dots: false,
                                    arrows: false
                                }
                            }
                        ]
                    });
                });
            } else if (!sliderElements.length) {
                console.log('No uninitialized sliders found in:', container);
                console.log('Container HTML:', container.innerHTML.substring(0, 200) +
                    '...'); // Log partial HTML for debugging
            } else {
                console.error('Slick Slider or jQuery not loaded for:', sliderElements);
            }
        }

        // Function to force DOM reflow
        function forceReflow(element) {
            element.offsetHeight; // Accessing offsetHeight triggers a reflow
        }

        // Function to load related streams
        function loadRelatedStreams(container) {
            const streamGuid = container.dataset.streamGuid;
            if (!streamGuid) {
                console.error('No stream GUID found for related streams');
                container.style.display = 'none';
                return;
            }
            const skeletonLoader = container.querySelector('.skeleton-loader');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
                console.error('CSRF token missing, cannot make AJAX request');
                container.innerHTML = '<p>Error: CSRF token missing</p>';
                container.style.display = 'block';
                return;
            }
            fetch('{{ url('/streams/playerstream') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        stream_guid: streamGuid
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}, statusText: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success || !data.data.streams || data.data.streams.length === 0) {
                        container.style.display = 'none';
                        return;
                    }
                    const relatedStreams = data.data.streams; // Save the streams for use in both calls
                    return fetch('{{ url('/render-you-might-like') }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            streams: relatedStreams,
                            stream_guid: streamGuid
                        })
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(
                                `HTTP error! status: ${response.status}, statusText: ${response.statusText}`
                            );
                        }
                        return response.json();
                    }).then(renderData => {

                        if (renderData.success && renderData.html) {
                            requestAnimationFrame(() => {
                                if (skeletonLoader) {
                                    skeletonLoader.style.display = 'none';
                                }
                                container.innerHTML = renderData.html;

                                forceReflow(container);
                                initializeSlider(container);
                            });

                            // Call render-playlist-items with the same stream data
                            return fetch('/render-playlist-items', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    streams: relatedStreams,
                                    adMacros: adMacros,
                                    isMobileBrowser: isMobileBrowser,
                                    dataVast2: dataVast2,
                                    stream_guid: streamGuid
                                })
                            });
                        } else {
                            container.style.display = 'none';
                        }
                    }).then(response => {
                        if (!response) return;
                        if (!response.ok) throw new Error('Failed to fetch playlist items');
                        return response.text(); // Assuming HTML response
                    }).then(html => {
                        if (!html) return;
                        const playlistContainer = document.querySelector('.playlist-video');
                        if (playlistContainer) {
                            $(playlistContainer).append($(html));
                        } else {
                            console.warn('Playlist container not found');
                        }
                        window.playlistFetched = true;
                    });
                })
                .catch(error => {
                    console.error(`Error processing streams for stream: ${streamGuid}:`, error);
                    container.innerHTML =
                        '<p class="text-white no-reviews-message m-3 mt-2">Content Not Avaiable yet</p>';
                    container.style.display = 'block';
                });
        }

        // Load related streams after page is fully loaded
        window.onload = () => {
            const container = document.querySelector('.like-tab-slider-container');
            if (container) {
                loadRelatedStreams(container);
            } else {
                console.error('Related streams container not found');
            }
        };

        function watiForPlaylistFetch() {
            return new Promise((resolve) => {
                const interval = setInterval(() => {
                    if (window.playlistFetched) {
                        console.log("Wating for playlist fetch");
                        clearInterval(interval);
                        resolve();
                    }
                }, 1000);
            })
        }
    </script>
    {{-- ajax request for apply coupon  --}}
    <script>
        $('#applyCouponBtn').on('click', function() {
            const id = $('#coupon_id').val();
            const code = $('#couponCode').val();
            const streamCode = $('#stream_code').val();
            $('#coupon_code_error').text('');
            $.ajax({
                url: '{{ route('coupon.apply') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    code: code,
                    stream_code: streamCode
                },
                success: function(response) {
                    const couponModalEl = document.getElementById('couponModal');
                    const couponModal = bootstrap.Modal.getInstance(couponModalEl);
                    if (response && response.data) {
                        if (response.data.success == true) {
                            Swal.fire({
                                title: response.data.message,
                                icon: "success"
                            });
                        } else if (response.data.success == false) {
                            Swal.fire({
                                title: response.data.message,
                                icon: "error"
                            });
                        }
                        if (couponModal) {
                            couponModal.hide();
                            is_active = false;
                        }
                    }
                },

                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        if (errors.code) {
                            $('#coupon_code_error').text(errors.code[0]);
                        }
                    } else {
                        console.log('Failed to apply coupon: ' + xhr.responseJSON.message);
                    }
                }
            });
        });
    </script>


@endpush
