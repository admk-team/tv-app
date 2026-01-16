<?php

namespace App\Helpers;

use App\Services\Api;
use App\Services\AppConfig;
use Illuminate\Support\Facades\Http;

class GeneralHelper
{
    public static function replaceDataInList($string, $list)
    {
        $find = array_keys($list);
        $replace = array_values($list);
        return str_ireplace($find, $replace, $string);
    }

    public static function randomMD5()
    {
        return MD5(TOKEN_SALT . time() . mt_rand());
    }

    public static function trimFormValue($trace, $array)
    {
        $rtnArr = array_map('trim', $array);
        if ($trace) {
            echo "<pre><-------------Input array value-------------><br>";
            print_r($array);
            echo "<-------------Output array value-------------><br>";
            print_r($rtnArr);
            echo "</pre>";
            die;
        }
        return $rtnArr;
    }

    public static function prepareKeyValue4Msql($trace, $array, $keyExcludeArr)
    {
        $rtnArr = array();

        foreach ($array as $key => $value) {
            if (!in_array($key, $keyExcludeArr)) $rtnArr[$key] = $value;
        }

        if ($trace) {
            echo "<pre><-------------Input array value-------------><br>";
            print_r($array);
            echo "<-------------Output array value-------------><br>";
            print_r($rtnArr);
            echo "</pre>";
            die;
        }
        return $rtnArr;
    }

    public static function checkTimeFormat($timeFormat)
    {
        $timeFormat = trim($timeFormat);

        if (strstr($timeFormat, ':')) {
            list($hr, $min) = @explode(":", $timeFormat);

            if (@is_numeric($hr) && @is_numeric($min)) {
                if (strlen($hr) == 2 && strlen($min) == 2) {
                    return 1;
                }
            }
        }

        return 0;
    }

    public static function makeRandNo6Digit()
    {
        return rand(100000, 999999);
    }

    public static function unixtime64($str)
    {
        date_default_timezone_set("UTC");
        $dateTime = new DateTime($str);
        return $dateTime->format("U");
    }

    public static function getCurrentUnixtime()
    {
        date_default_timezone_set("UTC");
        return date('U');
    }

    public static function getExpiredDate($interval)
    {
        date_default_timezone_set("UTC");
        $readableCurrDt = date(LONG_MYSQL_DATE_FORMAT);
        $readableExtendedDt = date(LONG_MYSQL_DATE_FORMAT, strtotime("$readableCurrDt $interval"));

        return array('readableExtendedDt' => $readableExtendedDt, 'unixtimeExtended' => unixtime64($readableExtendedDt), 'readableCurrDt' => $readableCurrDt, 'unixtimeCurrnt' => unixtime64($readableCurrDt));
    }

    public static function convertDateTimeSpecificTimeZone($dt, $tz1 = 'America/New_York', $df = 'Y-m-d H:i:s', $tz2 = 'UTC')
    {
        $rtnStr = '';
        $dt = trim($dt);
        if ($dt != '') {
            $date = date_create($dt, timezone_open($tz1));
            date_timezone_set($date, timezone_open($tz2));
            $rtnStr = $date->format($df);
        }

        return $rtnStr;
    }

    public static function mysqlDate($value)
    {
        if ($value) {
            if (MYSQL_DATE_CONVERSION_STYLE == 'EU') list($dd, $mm, $yy) = explode(DATE_FORMAT_SPLITTER, $value);
            else if (MYSQL_DATE_CONVERSION_STYLE == 'US') list($mm, $dd, $yy) = explode(DATE_FORMAT_SPLITTER, $value);
            return "$yy-$mm-$dd"; // Obtain the final date
        }
    }

    public static function getRealIpAddr()
    {
        if (!empty(request()->server('HTTP_CLIENT_IP'))) {
            // Check ip from share internet
            $ip = request()->server('HTTP_CLIENT_IP');
        } else if (!empty(request()->server('HTTP_X_FORWARDED_FOR'))) {
            // Check if ip is pass from proxy
            $ip = request()->server('HTTP_X_FORWARDED_FOR');
        } else {
            $ip = request()->server('REMOTE_ADDR');
        }
        return $ip;
    }


    public static function headerRedirect($url)
    {
        ob_start();
        header('location:' . $url);
        exit;
    }

    public static function viewState($viewStateArray, $mode)
    {
        if ($mode) {
            foreach ($viewStateArray as $key => $value) {
                $_SESSION['session_' . $key] = $value;
            }
        } else {
            foreach ($viewStateArray as $key => $value) {
                unset($_SESSION['session_' . $key]);
            }
        }
    }

    public static function getTimestamp($value, $dateFormat)
    {
        if ($value) {
            return @date($dateFormat, strtotime($value));
        }
    }

    public static function allowedFIleExten($indexName, $arrAllowedExtension = array('png', 'jpg', 'jpeg', 'gif'))
    {
        $rten = 0;
        if (!empty($_FILES[$indexName]['name'])) {
            $fileName = trim($_FILES[$indexName]['name']);
            $arrPathInfo = pathinfo($fileName);
            $fileExten = strtolower($arrPathInfo['extension']);
            if (!in_array($fileExten, $arrAllowedExtension)) $rten = 1;
        }
        return $rten;
    }

    public static function showSessionMessage()
    {
        if (session('messageSession')) {
            //$ARR_GLOBAL_MSG = @$GLOBALS['ARR_GLOBAL_MSG'];
            echo session('messageSession');
            session()->forget('messageSession');
            session()->forget('msgTrue');
        }
    }

    public static function sendEmail($to, $subject, $body, $fromName, $from, $format = '')
    {
        $headers = '';
        $url = HTTP_PATH . '/images/mail-header.jpg';

        if ($format == 'HTML') {
            $headers .= "Content-type: text/html; charset=iso-8859-1\n";
        }

        $headers .= "From: $fromName <$from>" . "\n";
        $headers .= "Cc: " . "\n";
        $headers .= "Bcc: " . "\n";
        //<img src='{$url}'>
        $body = "<center>
                    <table width='100%' cellpadding='0' cellspacing='0' bgcolor='#EEE' style='color: #000000; text-align:left; border: 1px solid #ddd;'>
                    <tr>
                        <td style='padding:15px 15px 15px 15px; font-size: 12px; color: #000000; line-height:1.3; text-align:justify; font-family: Arial,Helvetica,sans-serif;'>" . $body . "<td>
                    </tr>
                    </table>
                </center>";

        if ($_SERVER['SERVER_NAME'] == 'localhost') {
            $str = "<font face='arial' size='2'><b>To Email:</b> $to<br><br><b>Subject:</b> $subject<br><br><b>From:</b> $fromName<br><br><b>From Email:</b> $from<br><br>$body</font>";
            $mailDir = HARD_PATH . '/gen_mail';

            $fp = fopen($mailDir . '/mail_' . date('U') . '_' . rand(10000, 99999) . '.html', 'w');
            fwrite($fp, $str);
            fclose($fp);
        } else {

            $success = mail($to, $subject, $body, $headers, '-f ' . NO_REPLY_EMAIL);
            return $success;
        }
    }

    public static function getValPostORGet($indexName, $method = 'P')
    {
        $rtenVal = '';
        if (!empty($_POST[$indexName]) && ($method == "P" || $method == "B")) $rtenVal = trim($_POST[$indexName]);
        else if (!empty($_GET[$indexName]) && ($method == "G" || $method == "B")) $rtenVal = trim($_GET[$indexName]);
        return $rtenVal;
    }

    public static function responses($trace, $arrData)
    {
        if ($trace) {
            echo "<pre><-------------Input array value-------------><br>";
            print_r($arrData);
            die;
        }

        header('Content-Type: application/json');
        echo json_encode($arrData);
    }

    public static function getContents()
    {
        parse_str(file_get_contents("php://input"), $vars);
        return $vars;
    }

    public static function makeDropDownFromDB($dropDownName, $optionListArray, $optionValueDbFld, $optionTextDbFld, $selectedOptionValue, $mode = '', $style = '', $event = '')
    {
        $str  = "<select name = '$dropDownName' id = '$dropDownName' $style $event $mode>";
        $str .= "<option value=''>Please Select</option>";

        if (is_array($optionListArray)) {
            $numOfRows = count($optionListArray);
            for ($i = 0; $i < $numOfRows; $i++) {

                if ($optionListArray[$i][$optionValueDbFld] == $selectedOptionValue) {
                    $str .= "<option value='" . $optionListArray[$i][$optionValueDbFld] . "' selected>" . htmlspecialchars($optionListArray[$i][$optionTextDbFld]) . "</option>";
                } else {
                    $str .= "<option value='" . $optionListArray[$i][$optionValueDbFld] . "'>" . htmlspecialchars($optionListArray[$i][$optionTextDbFld]) . "</option>";
                }
            }
        }

        $str .= "</select>";
        echo $str;
    }

    public static function makeDropDown($dropDownName, $optionValueArray, $optionTextArray, $selectedOptionValue, $mode = '', $style = '', $event = '', $hideShowPlzSelect = 'N')
    {
        $str  = "<select name = '$dropDownName' id = '$dropDownName' $style $event $mode>";
        if ($hideShowPlzSelect != 'Y') $str .= "<option value=''>Please Select</option>";

        if (is_array($optionValueArray)) {
            $numOfRows = count($optionValueArray);

            for ($i = 0; $i < $numOfRows; $i++) {
                if ($optionValueArray[$i] == $selectedOptionValue) {
                    $str .= "<option value='" . $optionValueArray[$i] . "' selected>" . htmlspecialchars($optionTextArray[$i]) . "</option>";
                } else {
                    $str .= "<option value='" . $optionValueArray[$i] . "'>" . htmlspecialchars($optionTextArray[$i]) . "</option>";
                }
            }
        }

        $str .= "</select>";
        echo $str;
    }

    public static function stripslashesHtmlChars($str)
    {
        return  stripslashes(htmlspecialchars(trim($str)));
    }

    public static function checkPageAccessPermission($codeStr)
    {
        if ($codeStr == '') {
            $_SESSION['messageSession'] = UNAUTHORIZED_MSG;
            headerRedirect('dashboard.php');
        }
    }

    public static function cors()
    {

        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }
    }

    public static function sendCURLRequest($trace, $url, $arrPost = array(), $rtnRes = "jsonObj")
    {
        $curl = curl_init();
        if (session('USER_DETAILS') && session('USER_DETAILS')['USER_CODE']) {
            $userCode = session('USER_DETAILS')['USER_CODE'];
            $headers = ['happCode: ' . env('APP_CODE'), 'huserCode: ' . $userCode];
        } else {
            $headers = ['happCode: ' . env('APP_CODE')];
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => $headers
        ));

        if (!empty($arrPost)) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $arrPost);
        }

        $res = curl_exec($curl);
        if ($rtnRes == "jsonObj") {
            $arrRes = json_decode($res, true);
        }

        if ($trace) {
            echo curl_error($curl);
            echo "<pre>";
            $info = curl_getinfo($curl);
            print_r($info);

            echo "<br><-----------Response------------------><br>";
            print_r($arrRes);
            die;
        }
        return $arrRes;
        curl_close($curl);
    }


    public static function parseMainFeedArrDataArchive_without_subcat($trace, $arrData, $selectedMenuGuid = '')
    {
        $selectedMenuType = 'L';
        $selectedMenuName = '';
        //$selectedMenuGuid = '';

        $arrMenuData = array();
        $arrMenuSelectedItemData = array();

        if ($arrData['app']['status'] == 1) {

            foreach ($arrData['app']['menus'] as $arrMenuDataInfo) {
                $menuGuid = $arrMenuDataInfo['menu_guid'];
                $menuType = $arrMenuDataInfo['menu_type'];
                $menuName = $arrMenuDataInfo['menu_name'];
                $isStartupMenu = $arrMenuDataInfo['is_startup_menu'];

                $arrMenuData[] = array(
                    'menu_guid' => $menuGuid,
                    'menu_name' => $menuName,
                    'menu_type' => $menuType,
                    'is_startup_menu' => $isStartupMenu
                );
                if (($selectedMenuGuid == '' && $isStartupMenu == 'Y') || $menuGuid == $selectedMenuGuid) {
                    $arrMenuSelectedItemData = $arrMenuDataInfo['streams'];
                    $selectedMenuGuid = $menuGuid;
                    $selectedMenuType = $menuType;
                    $selectedMenuName = $menuName;
                }
            }
        }

        if ($trace) {
            echo "<pre>";
            echo "-----------------Selected Menu Data----------------------------<br>";
            print_r($arrMenuSelectedItemData);
            echo "<br><br>----------------Menu Data----------------------------<br>";
            print_r($arrMenuData);

            echo "<br><br>----------------Response Data----------------------------<br>";
            print_r($arrData);
            die;
        }

        return array('arrMenuData' => $arrMenuData, 'arrMenuSelectedItemData' => $arrMenuSelectedItemData, 'selectedMenuGuid' => $selectedMenuGuid, 'selectedMenuType' => $selectedMenuType, 'selectedMenuName' => $selectedMenuName);
    }

    public static function parseMainFeedArrData($trace, $arrData)
    {
        $arrTopSliderData = array();
        $arrCategoriesData = array();
        $arrChannelsData = array();

        if ($arrData['app']->status == 1) {
            if (@$arrData['app']->featured_items->is_show == "Y") {
                $arrTopSliderData = @$arrData['app']['featured_items']['streams'];
            }
            // Check if 'channels' property exists
            if (isset($arrData['app']->channels)) {
                $arrChannelsData = $arrData['app']->channels;
            }
            // Check if 'categories' property exists
            if (isset($arrData['app']->categories)) {
                $arrCategoriesData = $arrData['app']->categories;
            }
            // $arrChannelsData = $arrData['app']->channels;
            // $arrCategoriesData = $arrData['app']->categories;
        }

        if ($trace) {
            echo "<pre>";
            echo "-----------------Top Banners Data----------------------------<br>";
            print_r($arrTopSliderData);
            echo "<br><br>----------------Categories Data----------------------<br>";
            print_r($arrCategoriesData);

            echo "<br><br>----------------Response Data------------------------<br>";
            print_r($arrData);
            die;
        }

        return array('arrTopSliderData' => $arrTopSliderData, 'arrCategoriesData' => $arrCategoriesData, 'arrChannelsData' => $arrChannelsData);
    }
    public static function parseMainFeedArrData__TVGuide($trace, $arrData)
    {
        $arrTopSliderData = array();
        $arrCategoriesData = array();
        $arrChannelsData = array();


        if ($arrData->app->status == 1) {
            if (@$arrData->app->featured_items->is_show == "Y") {
                $arrTopSliderData = @$arrData['app']['featured_items']['streams'];
            }
            $arrChannelsData = $arrData->app->channels;
            // $arrCategoriesData = $arrData['app']->categories;
        }

        if ($trace) {
            echo "<pre>";
            echo "-----------------Top Banners Data----------------------------<br>";
            print_r($arrTopSliderData);
            echo "<br><br>----------------Categories Data----------------------<br>";
            print_r($arrCategoriesData);

            echo "<br><br>----------------Response Data------------------------<br>";
            print_r($arrData);
            die;
        }

        return array('arrTopSliderData' => $arrTopSliderData, 'arrCategoriesData' => $arrCategoriesData, 'arrChannelsData' => $arrChannelsData);
    }

    public static function parseDetailPgFeedArrData($trace, $arrData)
    {
        $arrSelectedItemData = array();
        $arrCategoriesData = array();

        if ($arrData['app']['status'] == 1) {
            $arrCategoriesData = $arrData['app']['latest_items'];
            $arrSelectedItemData = $arrData['app']['stream_details'];
        }

        if ($trace) {
            echo "<pre>";
            echo "-----------------Selected Stream Data----------------------------<br>";
            print_r($arrSelectedItemData);
            echo "<br><br>----------------Latest Stream Data----------------------------<br>";
            print_r($arrCategoriesData);

            echo "<br><br>----------------Response Data----------------------------<br>";
            print_r($arrData);
            die;
        }

        return array('arrSelectedItemData' => $arrSelectedItemData, 'arrCategoriesData' => $arrCategoriesData);
    }

    public static function printDuration($strDuration)
    {
        $strDuration = trim($strDuration);
        if ($strDuration == '') $strDuration = "0 Min";
        else if ($strDuration < 2) $strDuration = "$strDuration Min";
        else $strDuration = "$strDuration Mins";

        return $strDuration;
    }

    public static function displayNA($str)
    {
        $str = trim($str);
        if (trim($str) == '') $str = "NA";
        return $str;
    }

    public static function redirect2Home()
    {
        headerRedirect(HTTP_PATH);
    }

    public static function setUserDetailInSession($trace, $userInfoArr, $isSeesionSet = 'Y')
    {
        if ($isSeesionSet == 'Y') {
            $_SESSION['USER_DETAILS']['USER_CODE'] = $userInfoArr['data']['user_code'];
            $_SESSION['USER_DETAILS']['USER_NAME'] = $userInfoArr['data']['name'];
            $_SESSION['USER_DETAILS']['USER_PICTURE'] = $userInfoArr['data']['picture'];

            $_SESSION['USER_DETAILS']['USER_ACCOUNT_STATUS'] = $userInfoArr['data']['account_status'];
        }
        $_SESSION['USER_DETAILS']['USER_EMAIL'] = $userInfoArr['data']['email'];
        $_SESSION['USER_DETAILS']['USER_ID'] = $userInfoArr['data']['user_id'];

        if ($trace) {
            print_r($userInfoArr);
            echo "In Seesion Data";
            print_r($_SESSION['USER_DETAILS']);
            die;
        }
    }

    public static function isSessionExpired()
    {
        if (empty($_SESSION['USER_DETAILS']['USER_CODE'])) redirect2Home();
    }

    public static function setCookies($cookieName, $cookieValue)
    {

        setcookie($cookieName, base64_encode($cookieValue), time() + (10 * 365 * 24 * 60 * 60));
    }

    public static function removeCookie($cookieName)
    {
        setcookie($cookieName, null, -1);
    }

    public static function getCookieVal($trace, $cookieName)
    {
        if ($trace) {
            echo "<pre>";
            print_r($_COOKIE);
            echo "</pre>";
        }
        return base64_decode($_COOKIE[$cookieName]);
    }

    public static function showDurationInMins($trace, $duration)
    {
        if ($trace) {
            echo "<pre>";
            print_r($duration);
            echo "</pre>";
        }
        return $duration . " Mins";
    }

    public static function showDurationInHourAndMins($duration, $stramType = 'M')
    {
        $duration = (int)$duration;
        $hour = floor($duration / 60);
        $minute = floor($duration % 60);

        $streamTime = '';

        if ($hour == 1) $streamTime = $hour . " Hour ";
        elseif ($hour > 1) $streamTime = $hour . " Hours ";

        if ($minute == 1) $streamTime .= $minute . " min";
        elseif ($minute > 1) $streamTime .= $minute . " min";

        if ($stramType != 'M') $streamTime = '&nbsp;';
        return $streamTime;
    }

    public static function makeMenuBasedURL($type, $code)
    {
        $url = '';

        if ($type == 'M') $url = HTTP_PATH . '/moviedetails/' . $code;
        else if ($type == 'S')  $url = HTTP_PATH . '/showdetails/' . $code;
        else if ($type == 'L')  $url = HTTP_PATH . '/fplayerpage/' . $code;
        else if ($type == 'P')  $url = HTTP_PATH . '/fplayerpage/' . $code;
        else $url = "javascript:void(0);";

        return $url;
    }

    public static function returnCardTypeCls($cardType)
    {
        // card_types: LA: Landscape, PO: Portrait, ST: Standard, QU: Square
        $cardThumbCls = "card card-img-container";
        $cardThumbCls2 = "thumbnail-container";
        switch ($cardType) {
            case 'LA':
                $cartMainCls = "landscape_slider";
                $cartMainSubCls = "ripple";
                $cardThumbCls = "";
                $cardThumbCls2 = "thumbnail_img";
                $streamPosterKey = 'stream_poster';
                break;
            case 'PO':
                $cartMainCls = "potrait_slider";
                $cartMainSubCls = "ripple vertical";
                $streamPosterKey = 'stream_portrait';
                break;
            case 'ST': // ST: Standard (4x3),
                $cartMainCls = "landscape_slider";
                $cartMainSubCls = "ripple";
                $cardThumbCls = "";
                $cardThumbCls2 = "thumbnail_img thumbnailfourbyfour";
                $streamPosterKey = 'stream_sdm';
                break;
            case 'QU': //QU: Square (1x1)
                $cartMainCls = "potrait_slider";
                $cartMainSubCls = "vertical onebyone";
                $streamPosterKey = 'stream_square';
                break;
            case 'BA': //Billboard Ads (1606x470)  803 : 235,
                $cartMainCls = "billboard_ads";
                $cartMainSubCls = "ripple";
                $cardThumbCls = "";
                $cardThumbCls2 = "thumbnail_img billboard_img";
                $streamPosterKey = 'stream_poster';
                break;
            case 'LB': // Leaderboard Ads (1350x50) 27:1,
                $cartMainCls = "leaderboard_ads";
                $cartMainSubCls = "ripple";
                $cardThumbCls = "";
                $cardThumbCls2 = "thumbnail_img leaderboard_img";
                $streamPosterKey = 'stream_poster';
                break;
        }
        return array('cartMainCls' => $cartMainCls, 'cartMainSubCls' => $cartMainSubCls, 'streamPosterKey' => $streamPosterKey, 'cardThumbCls' => $cardThumbCls, 'cardThumbCls2' => $cardThumbCls2);
    }

    public static function getShortName()
    {
        $name = $_SESSION['USER_DETAILS']['USER_NAME'];
        list($fname, $lname) = explode(" ", $name);
        $shortName = substr($fname, 0, 1) . substr($lname, 0, 1);
        return $shortName;
    }

    public static function isSubscribed()
    {
        $response = Http::withHeaders(Api::headers())
            ->get(Api::endpoint('/check-subscription'));
        
        if (!$response->successful()) {
            return false;
        }

        $responseJson = $response->json();

        if (isset($responseJson['is_subscribed']) && $responseJson['is_subscribed'] === true) {
            return true;
        }

        return false;
    }

    public static function subscriptionIsRequired()
    {
        if ((AppConfig::get()->app->app_info->subscription_on_signup ?? 'no') === 'yes' && !self::isSubscribed()) {
            return true;
        }

        return false;
    }

    public static function generateGradient($color) {
        static $results = [];

        if (isset($results[$color])) {
            return $results[$color];
        }

        // Helper function to adjust brightness of a color
        $adjustBrightness = function ($hex, $steps) {
            // Normalize the steps
            $steps = max(-255, min(255, $steps));
    
            // Parse the color into its RGB components
            $r = hexdec(substr($hex, 1, 2));
            $g = hexdec(substr($hex, 3, 2));
            $b = hexdec(substr($hex, 5, 2));
    
            // Adjust brightness
            $r = max(0, min(255, $r + $steps));
            $g = max(0, min(255, $g + $steps));
            $b = max(0, min(255, $b + $steps));
    
            // Convert back to hex
            return sprintf("#%02x%02x%02x", $r, $g, $b);
        };
    
        // Generate two additional colors by adjusting brightness
        $color1 = $adjustBrightness($color, -50); // Darker
        $color2 = $adjustBrightness($color, 50);  // Lighter
    
        // Create the CSS gradient string
        $gradient = "background-image: linear-gradient(90deg, $color1, $color, $color2);";

        // Cache result for future calls
        $results[$color] = $gradient;

        return $gradient;
    }

    /**
     * Format views count with abbreviated notation (1k, 1.5k, 1M, etc.)
     * 
     * @param int|float $views The number of views
     * @return string Formatted views string
     */
    public static function formatViews($views)
    {
        $views = (int) $views;
        
        if ($views < 1000) {
            return (string) $views;
        }
        
        if ($views < 1000000) {
            // Format as thousands (1k, 1.5k, 2k, etc.)
            $thousands = $views / 1000;
            if ($thousands == (int) $thousands) {
                // Whole number (e.g., 1000 -> 1k, 2000 -> 2k)
                return (int) $thousands . 'k';
            } else {
                // Decimal (e.g., 1500 -> 1.5k, 2500 -> 2.5k)
                return number_format($thousands, 1) . 'k';
            }
        }
        
        // Format as millions (1M, 1.5M, etc.)
        $millions = $views / 1000000;
        if ($millions == (int) $millions) {
            return (int) $millions . 'M';
        } else {
            return number_format($millions, 1) . 'M';
        }
    }
}
