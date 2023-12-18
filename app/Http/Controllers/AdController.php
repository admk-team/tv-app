<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index(Request $request)
    {
        $adUrl = session('ADS_INFO')? session('ADS_INFO')['adUrl']: null;
        $videoId = $request->videoId;
        $channelName = session('ADS_INFO')? session('ADS_INFO')['channelName']: null;
        $contentGenre = "action";
        $contentTitle = urlencode($request->title);
        $userAgent = urlencode($request->server('HTTP_USER_AGENT'));
        $webSitePageUrl = url('/playerscreen/'.$videoId);
        $domainName = session('ADS_INFO')? session('ADS_INFO')['domain_name']: null;

        $fullAUrl = $adUrl.'?w=680&h=480&cb='.time().'&url='.$domainName.'&ip='.GeneralHelper::getRealIpAddr();
        $fullAUrl .= '&ua='.$userAgent.'&content_episode=1&ic=IAB1&min_dur=5&pod_max_dur=90&pod_ad_slots=5&vid='.$videoId;
        $fullAUrl .= '&content_livestream=0&rating=pg&gdpr_consent=&content_id='.$videoId.'&content_title='.$contentTitle;
        $fullAUrl .= '&gdpr=1&us_privacy=---1&channel_name='.urlencode($channelName).'&content_genre='.$contentGenre;
        //echo $fullAUrl;
        //die;
        // Test Ads
        //$fullAUrl = "https://tv.springserve.com/vast/703046?w=1920&h=1080&cb={{CACHEBUSTER}}&ip={{IP}}&ua={{USER_AGENT}}&pod_max_dur={{POD_MAX_DUR}}&pod_ad_slots={{POD_AD_SLOTS}}&app_bundle={{APP_BUNDLE}}&app_name={{APP_NAME}}&app_store_url={{APP_STORE_URL}}&did={{DEVICE_ID}}";

        $res = file_get_contents($fullAUrl);
        if ($res == '<VAST version="3.0" />');
        {
        //  $res = file_get_contents(HTTP_PATH."/717813.xml");
        }
        for ($i = 0; $i < 4; $i++)
        {
        file_get_contents($fullAUrl);
        }
        header("Content-type: application/xml");
        echo $res;
    }
}
