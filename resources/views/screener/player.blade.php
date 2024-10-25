@extends('layouts.app')

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
        session('REDIRECT_TO_SCREEN', url('/playerscreen/' . $streamGuid));
        \App\Helpers\GeneralHelper::headerRedirect(url('/signin'));
    }
    //monetioztion
    $sharingURL = url('/playerscreen/' . $streamGuid);
    $isBuyed = $arrSlctItemData['is_buyed'];
    $monetizationType = $arrSlctItemData['monetization_type'];
    if ($monetizationType != 'F' && $isBuyed == 'N') {
        session('REDIRECT_TO_SCREEN', url('/playerscreen/' . $streamGuid));
        if (!session('USER_DETAILS') || !session('USER_DETAILS')['USER_CODE']) {
            session('REDIRECT_TO_SCREEN', '/playerscreen/' . $streamGuid);
            \App\Helpers\GeneralHelper::headerRedirect(url('/signin'));
        } elseif ($monetizationType == 'S') {
            $sArr['REQUEST_FROM'] = 'player';
            $_SESSION['MONETIZATION'] = $sArr;
            \App\Helpers\GeneralHelper::headerRedirect(url('/subscription'));
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
            $_SESSION['MONETIZATION'] = $sArr;
            \App\Helpers\GeneralHelper::headerRedirect(url('/monetioztion'));
        }
    }

    $mType = 'video';
    if (strpos($streamUrl, '.m3u8')) {
        $mType = 'hls';
    }
    $apiPath = url('/web-controller.php');
    $strQueryParm = "streamGuid=$streamGuid&userCode=" . @session('USER_DETAILS')['USER_CODE'] . '&frmToken=' . session('SESSION_TOKEN');

    // here get the video duration
    $seekFunStr = '';
    $arrFormData4VideoState = [];
    $arrFormData4VideoState['streamGuid'] = $streamGuid;
    //$arrFormData4VideoState['streamDuration'] = "50";
    $arrFormData4VideoState['requestAction'] = 'getStrmDur';
    $arrRes4VideoState = \App\Helpers\GeneralHelper::sendCURLRequest(0, VIDEO_DUR_MNG_BASE_URL, $arrFormData4VideoState);
    //print_r($arrRes4VideoState);
    $status = $arrRes4VideoState['app']['status'];
    if ($status == 1) {
        $streamDurationInSec = $arrRes4VideoState['app']['data']['stream_duration'];
        $seekFunStr = "this.currentTime($streamDurationInSec);";
    }

    // Here Set Ad URL in Session
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
    $dataVast = 'data-vast="' . url('/get-ad?' . $adParam) . '"';

    if ($isMobileBrowser == 1) {
        $dataVast = '';
    }

    $adUrl = $arrSlctItemData['stream_ad_url'] ? 'data-vast="' . $arrSlctItemData['stream_ad_url'] . '"' : null;

    $watermark = $arrRes['app']['screener']['watermark'];
    ?>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mvp.css') }}" />
    <script src="{{ asset('assets/js/new.js') }}"></script>
    <script src="{{ asset('assets/js/vast.js') }}"></script>
    <script src="{{ asset('assets/js/share_manager.js') }}"></script>
    <script src="{{ asset('assets/js/cache.js') }}"></script>
    <script src="{{ asset('assets/js/ima.js') }}"></script>
    <script src="{{ asset('assets/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/playlist_navigation.js') }}"></script>
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
        .videocentalize {
            position: relative;
        }

        .watermark {
            position: absolute;
            z-index: 1;
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

        .watermark img {
            max-height: {{ $watermark ? $watermark['size'] . 'px' : '112px' }};
            height: {{ $watermark ? $watermark['size'] . 'px' : '112px' }};
            opacity: {{ $watermark ? $watermark['opacity'] : 0 }};
            -webkit-user-drag: none;
            user-select: none;
        }
    </style>

    <div>

        <div class="container-fluid containinax">
            <div class="row">
                <div class="col-md-12">

                    <div class="videocentalize">
                        @if ($watermark)
                            <div class="watermark {{ $watermark['position'] }} {{ $watermark['type'] }}">
                                @if ($watermark['type'] === 'text')
                                    {{ $watermark['text'] }}
                                @else
                                    <img src="{{ $watermark['image'] }}" alt="watermark">
                                @endif
                            </div>
                        @endif
                        <div id="wrapper"></div>
                        <!-- LIST OF PLAYLISTS -->
                        <div id="mvp-playlist-list">
                            <div class="mvp-global-playlist-data"></div>
                            <div class="playlist-video">

                                <div class="mvp-playlist-item" data-type="{{ $mType }}"
                                    data-path="{{ $streamUrl }}" data-poster="{{ $arrSlctItemData['stream_poster'] }}"
                                    data-thumb="{{ $arrSlctItemData['stream_poster'] }}"
                                    data-title="{{ $arrSlctItemData['stream_title'] }}"
                                    data-description="{{ $arrSlctItemData['stream_description'] }}"
                                    >

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
                      $dataVast3 = url('/get-ad?'.$adParam);
                      if ($isMobileBrowser == 1)
                      {
                      //  $dataVast = '';
                      }
                     ?>
                                <div class="mvp-playlist-item" data-type="{{ $quality }}"
                                    data-path="{{ $videoUrl }}"
                                    data-poster="{{ $poster }}" data-thumb="{{ $poster }}"
                                    data-title="{{ $arrStreamsData['stream_title'] }}"
                                    data-description="{{ $arrStreamsData['stream_description'] }}"></div>
                                <?php
                    }
                   ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product_bindfullbox">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10">
                        <div class="product_detailbox">
                            <ul class="starpoint" style="display: none;">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <h1 class="content-heading">{{ $arrSlctItemData['stream_title'] }}</h1>
                            <div class="content-timing">
                                <span class="year">{{ $arrSlctItemData['released_year'] }}</span>
                                <span>{{ \App\Helpers\GeneralHelper::showDurationInHourAndMins($arrSlctItemData['stream_duration']) }}</span>
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
                                <span class="content_screen">{{ $arrSlctItemData['content_qlt'] }}</span>
                                <?php
              }
?>
                                <?php
                  if ($arrSlctItemData['content_rating'] != '')
                  {
                    ?>
                                <span class="content_screen">{{ $arrSlctItemData['content_rating'] }}</span>
                                <?php
                  }
                  ?>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-2 sharesinbos">
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
                  <a href="javascript:void(0);" onClick="javascript:manageFavItem();"><i id="btnicon-fav" class="{{ $cls }}"></i></a>
                  <input type="hidden" id="myWishListSign" value='{{ $signStr }}'/>
                  <input type="hidden" id="strQueryParm" value='{{ $strQueryParm }}'/>
                  <input type="hidden" id="reqUrl" value='{{ route('wishlist.toggle') }}'/>
                  @csrf
                </div>
              <?php
              }
              ?>
              <div class="share_circle addWtchBtn" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                <a href="javascript:void(0);"><i class="fa fa-share"></i></a>
              </div>
            </div> --}}
                </div>
<div class=" d-flex justify-content-between align-items-center flex-wrap w-75">
    <div class="slider_title_box slidessbwh" style="padding: 0 45px; flex: 1;">
        <div class="about_fulltxt">{{ $arrSlctItemData['stream_description'] }}</div>
    </div>
        @if (!empty($arrSlctItemData['is_download']) && $arrSlctItemData['is_download'] == 1)
                <form action="{{ route('video.convert') }}" method="POST" class="d-flex flex-column flex-sm-row align-items-center">
                    @csrf
                    @if (session('message'))
                        <span id="success-message" class="text-success">{{ session('message') }}</span>
                    @endif
                    <span id="error-message" class="text-danger"></span>

                    <input type="hidden" name="stream_url" value="{{ $arrStreamsData['stream_url'] }}">
                    <input type="hidden" name="stream_description" value="{{ $arrStreamsData['stream_description'] }}">
                    <input type="hidden" name="stream_title" value="{{ $arrSlctItemData['stream_title'] }}">
                    <input type="hidden" name="email" value="{{ request()->get('email') }}">
                    <button type="submit" class="auth app-secondary-btn rounded mt-2 mt-sm-0">
                        <span class="px-1"><i class="ri-arrow-down-line"></i></span>Download
                    </button>
                </form>
    @endif
</div>

            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Share</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <ul class="share_list">
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
                            <a data-toggle="tooltip" data-placement="top" title="linkdin"
                                href="https://www.linkedin.com/shareArticle?mini=true&url={{ $sharingURL }}"
                                target="_blank">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                    <form class="form-inline">
                        <input type="text" class="share_formbox" id="sharingURL" value="{{ $sharingURL }}"
                            readonly>
                        <input type="button" class="submit_btn share_btnbox" value="Copy">
                </div>
            </div>
        </div>
    </div>
    <?php
$arrCatData = $ARR_FEED_DATA['arrCategoriesData'];
$nextVideoPath = '';
if (!empty($arrCatData) && count($arrCatData['streams']) > 1)
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
                foreach ($arrCatData['streams'] as $index => $arrStreamsData)
                {
                    if ($arrStreamsData['stream_guid'] === $arrSlctItemData['stream_guid'])
                      continue;

                    $vidPath = route('screener.player', ['code' => $code, 'itemIndex' => $index + 1]);
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
                        <a
                            href="{{ route('screener.player', ['code' => $code, 'itemIndex' => $index + 1]) }}?email={{ request()->email }}">
                            <div class="thumbnail_img">
                                <div class="trending_icon_box" {!! $strBrige !!}><img
                                        src="{{ asset('/assets/images/trending_icon.png') }}"
                                        alt="{{ $arrStreamsData['stream_title'] }}"></div>
                                <img src="{{ $arrStreamsData['stream_poster'] }}"
                                    alt="{{ $arrStreamsData['stream_title'] }}">
                                <div class="detail_box_hide">
                                    <div class="detailbox_time">{{ $arrStreamsData['stream_duration_timeformat'] }}</div>
                                    <div class="deta_box">
                                        <div class="season_title">
                                            {{ $arrStreamsData['stream_episode_title'] && $arrStreamsData['stream_episode_title'] !== 'NULL' ? $arrStreamsData['stream_episode_title'] : '' }}
                                        </div>
                                        <!-- <div class="play_icon"><a href="/details/21"><i class="fa fa-play" aria-hidden="true"></i></a>
                                  </div> -->
                                        <div class="content_title">{{ $arrStreamsData['stream_title'] }}</div>
                                        <div class="content_description">{{ $arrStreamsData['stream_description'] }}</div>
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
                useImaLoader: false,
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

            player = new mvp(document.getElementById('wrapper'), settings);

            setTimeout(unmutedVoice, 2000);

        });

        function unmutedVoice() {
            //alert("hi");
            player.toggleMute();
            player.playMedia();
            setInterval(sendAdRequrst, 50000);
        }

        document.addEventListener("DOMContentLoaded", function(event) {
            player.addEventListener('mediaStart', function(data) {
                //called on media start, returns (instance, instanceName, counter)

                console.log(data.instanceName);
                console.log(data.counter); //active item

                //get media current time
                data.instance.getCurrentTime();

                //get media duration
                data.instance.getDuration();



            });
        });

        function sendAdRequrst() {
            $.get("<?php echo $dataVast3 ?? ''; ?>", function(data, status) {
                //alert("Data: " + data + "\nStatus: " + status);
            });
        }
    </script>
    <script>
        //sendAjaxRes4VideoDuration('saveStrmDur', this.currentTime())
        //sendAjaxRes4VideoDuration('removeStrmDur', '')

        function sendAjaxRes4VideoDuration(requestAction, streamDuration) {
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
                xhttp.send(strQueryParm);
            }
        }
    </script>
@endpush
