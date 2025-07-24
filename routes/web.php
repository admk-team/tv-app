<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AdvertiserController as ControllersAdvertiserController;
use App\Http\Controllers\AdvisoryController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\BundleContentController;
use App\Http\Controllers\DetailScreenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PlayerScreenController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DownloadAppsController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\MonetizationController;
use App\Http\Controllers\FreeSubscriptionController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PasswordUpdateController;
use App\Http\Controllers\TransactionHistoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChannelSubscribe;
use App\Http\Controllers\ChannelSubscribeController;
use App\Http\Controllers\GumletController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\GiftStreamController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\NotifyComingSoonStreamController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QualityController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ScreenerController;
use App\Http\Controllers\SeriesDetailScreenController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TvGuidePlayerController;
use App\Http\Controllers\UserBadgeController;
use App\Http\Controllers\VideoEventsController;
use App\Http\Controllers\WatchPartyController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\AdvertiserController;

use App\Models\WatchParty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/cmd/{cmd}', function ($cmd) {
    Artisan::call("$cmd");
    echo "<pre>";
    return Artisan::output();
});

Route::get('/script', function () {
    // Define the path to your script
    $scriptPath = '/home/u763586918/domains/octv.online/public_html/copyscript.sh';

    // Execute the script and capture the output
    $output = shell_exec("sh $scriptPath 2>&1");

    // Return or log the output
    return response()->json(['output' => $output]);
});


// Temporary landing page route
Route::view('/new3', 'components.new3');
Route::view('/lyra', 'components.damian');
// Route::view('/new3', 'components.new3');

Route::post('/video', [GumletController::class, 'uploadGumlet'])->name('video.convert');
Route::get('video/download/{streamId}', [GumletController::class, 'download'])->middleware('throttle:3,1')->name('video.download');

Route::get('/check-channel-status', [ChannelSubscribeController::class, 'checkSubscriptionStatus'])->name('check.subscription.status');



// Authentication
Route::get('signup', [RegisterController::class, 'index'])->name('register');
Route::post('signup', [RegisterController::class, 'register'])->name('register');
Route::get('auth/google', [RegisterController::class, 'socialLogin'])->name('social');
Route::get('auth/facebook', [RegisterController::class, 'socialfacebook'])->name('facebook');
Route::get('auth/linkedin', [RegisterController::class, 'socialLinkedin'])->name('linkedin');
Route::get('login/google/callback', [RegisterController::class, 'redirectBack']);
Route::get('login/facebook/callback', [RegisterController::class, 'redirectfaceook']);
Route::get('login/linkedin/callback', [RegisterController::class, 'redirectLinkedin']);

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('logout', [LogoutController::class, 'index'])->name('logout');
//Email Verification
Route::get('verify', [LoginController::class, 'verify'])->name('verify');
Route::post('verify', [LoginController::class, 'verifyEmail'])->name('verify');
//forgot password
Route::get('forgot', [LoginController::class, 'forgot'])->name('forgot');
Route::post('forgot', [LoginController::class, 'forgotPassword'])->name('forgot');
//reset password
Route::get('/reset-password', [LoginController::class, 'showResetPasswordForm'])->name('auth.resetPassword');
Route::post('/reset-password', [LoginController::class, 'resetpassword'])->name('reset.password');

// Authenticated Routes
Route::middleware('auth.user')->group(function () {

    Route::match(['get', 'post'], 'monetization', [MonetizationController::class, 'index'])->name('monetization');
    Route::post('apply-coupon', [MonetizationController::class, 'applyCoupon'])->name('apply-coupon');
    Route::match(['get', 'post'], 'monetization/success', [MonetizationController::class, 'success'])->name('monetization.success');
    Route::get('monetization/cancel', [MonetizationController::class, 'cancel'])->name('monetization.cancel');
    Route::post('tipjar', [MonetizationController::class, 'tipjar'])->name('tipjar.view');
    Route::post('/stripe/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
    Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success');
    Route::get('password/edit', [PasswordUpdateController::class, 'index'])->name('password.edit');
    Route::post('password/update', [PasswordUpdateController::class, 'update'])->name('password.update');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('profile-setting', [ProfileController::class, 'view_setting'])->name('profile.setting');
    Route::get('manageprofile/{id}', [ProfileController::class, 'manage_profile'])->name('profile.manage');
    Route::get('/view/profile/{id}', [ProfileController::class, 'view_profile'])->name('profile.view_profile');
    //watch history
    Route::get('watch/history', [ProfileController::class, 'history'])->name('watch.history');
    //
    Route::post('extra/video', [PlayerScreenController::class, 'extraVideo'])->name('extra-video');
    //watch history
    Route::get('user/badge', [UserBadgeController::class, 'index'])->name('user.badge');

    Route::get('get-profile', [ProfileController::class, 'getUserProfile'])->name('public-profile');
    Route::post('update-profile', [ProfileController::class, 'updateProfile'])->name('update-profile');

    // friend request controller
    Route::get('public-firends', [FriendRequestController::class, 'getPublicFriend'])->name('public-friend');
    Route::post('send-firend-request', [FriendRequestController::class, 'sendFriendRequest'])->name('send-friend-request');
    Route::get('get-firend-request', [FriendRequestController::class, 'getFriendRequests'])->name('get-friend-request');
    Route::post('accept-firend-request', [FriendRequestController::class, 'AceptFriendRequests'])->name('accept-friend-request');
    Route::post('reject-firend-request', [FriendRequestController::class, 'rejectFriendRequests'])->name('reject-friend-request');
    Route::get('get-firend', [FriendRequestController::class, 'getFriends'])->name('get-friend');
    Route::post('un-firend', [FriendRequestController::class, 'markUnFriends'])->name('un-friend');
    Route::get('get-fav-firend', [FriendRequestController::class, 'getFavFriends'])->name('get-fav-friend');
    Route::post('mark-fav-firend', [FriendRequestController::class, 'markAsFavFriends'])->name('mark-fav-friend');
    Route::post('remove-fav-firend', [FriendRequestController::class, 'removeFavFriends'])->name('remove-fav-friend');

    //friends.recommendation
    Route::get('friends/recommendation', [FriendRequestController::class, 'friends_option'])->name('friends.recommendation');
    Route::post('/recommendation/store', [FriendRequestController::class, 'store'])->name('recommendation.store');

    Route::get('/advertiser/banner_ad', [AdvertiserController::class, 'bannerAd'])->name('advertiser.banner_ad');
    Route::get('/advertiser/banner_ad/report/{id}', [AdvertiserController::class, 'bannerAdReport'])->name('advertiser.banner_ad.report');
    Route::get('/advertiser/overlay_ad', [AdvertiserController::class, 'overlayAd'])->name('advertiser.overlay_ad');
    Route::get('/advertiser/overlay_ad/report/{id}', [AdvertiserController::class, 'overlayAdReport'])->name('advertiser.overlay_ad.report');
    Route::get('/advertiser/video_ad', [AdvertiserController::class, 'videoAd'])->name('advertiser.video_ad');
    Route::get('/advertiser/video_ad/report/{id}', [AdvertiserController::class, 'videoAdReport'])->name('advertiser.video_ad.report');
     Route::get('/advertiser/cta', [AdvertiserController::class, 'ctaAd'])->name('advertiser.cta');
    Route::get('/advertiser/cta/report/{id}', [AdvertiserController::class, 'ctaAdReport'])->name('advertiser.cta.report');
});

Route::get('get-ad', [AdController::class, 'index'])->name('get-ad');
Route::get('detailscreen/{id}', [DetailScreenController::class, 'index'])->name('detailscreen');
Route::get('series/{id}', [SeriesDetailScreenController::class, 'index'])->name('series');
Route::post('addrating/series', [SeriesDetailScreenController::class, 'addRating'])->name('addrating.series');
Route::get('page/{slug}', [PageController::class, 'index'])->name('page');
Route::post('contact-us', [PageController::class, 'submit'])->name('contactus.submit');
Route::get('cancelsubscription/{subid}', [StripeController::class, 'cancelsub'])->name('cancel.subscription');
Route::post('offer/disscount', [StripeController::class, 'offerDiscountBeforeCancel']);
Route::post('/pause-subscription', [StripeController::class, 'pauseSubscription']);
Route::get('playerscreen/{id}', [PlayerScreenController::class, 'index'])->name('playerscreen'); // Main Player Screen
Route::post('apply-coupon/', [PlayerScreenController::class, 'ApplyCoupon'])->name('coupon.apply'); // Apply For Coupon
Route::get('playerscreen/private/{id}', [PlayerScreenController::class, 'private'])->name('playerscreen.private'); // Player Screen for private videos
Route::post('playerscreen-checkpassword', [PlayerScreenController::class, 'checkPassword'])->name('playerscreen.checkpassword');
Route::post('playerscreen-checkscreenerpassword', [PlayerScreenController::class, 'checkScreenerPassword'])->name('playerscreen.checkscreenerpassword');
Route::get('searchscreen', [SearchController::class, 'index'])->name('search');
Route::get('download-apps', [DownloadAppsController::class, 'index'])->name('downloadapps');
Route::get('subscription', [SubscriptionController::class, 'index'])->name('subscription');
Route::get('free-subscription', [FreeSubscriptionController::class, 'index'])->name('free-subscription');
Route::get('transaction-history', [TransactionHistoryController::class, 'index'])->name('transaction-history');
Route::get('category/{id}', [CategoryController::class, 'index'])->name('category');
Route::get('year/{year}', [YearController::class, 'index'])->name('year');
Route::get('quality/{code}', [QualityController::class, 'index'])->name('quality');
Route::get('rating/{code}', [RatingController::class, 'index'])->name('rating');

Route::get('advisory/{id}', [AdvisoryController::class, 'index'])->name('advisory');
Route::get('language/{id}', [LanguageController::class, 'index'])->name('language');
Route::get('tag/{id}', [TagController::class, 'index'])->name('tag');


Route::get('person/{id?}', [PersonController::class, 'index'])->name('person');
Route::post('addrating/post', [DetailScreenController::class, 'addRating'])->name('addrating');
Route::post('addrating', [PlayerScreenController::class, 'addRating'])->name('addrating.playerscreen');
Route::post('wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

// Screener
Route::get('screener/{code}/{itemIndex?}', [ScreenerController::class, 'player'])->name('screener.player');
Route::post('screener/authenticate/{code}', [ScreenerController::class, 'authenticate'])->name('screener.authenticate');


Route::get('/epgplayer/{channelGuid}/{slug}', [TvGuidePlayerController::class, 'index'])->name('player.tvguide');
Route::get('/next-previous/{channelGuid}', [TvGuidePlayerController::class, 'indexRender'])->name('next-previous.player.tvguide');
//Newsletter
Route::post('newsletter', [NewsLetterController::class, 'newLetter'])->name('newsletter');

Route::get('follow/{code?}', [FollowController::class, 'follow'])->name('toggle.follow');
Route::post('channel/subscribe', [ChannelSubscribeController::class, 'toggleSubscribe'])->name('toggle.subscribe');

Route::post('video/download', [GumletController::class, 'uploadGumlet'])->name('video.convert');

Route::get('/content-bundle/{stream_guid}', [BundleContentController::class, 'index'])->name('content-bundle');
Route::post('/purchase', [BundleContentController::class, 'purchase'])->name('bundle.purchase');
Route::post('/stripe/purchase', [BundleContentController::class, 'createCheckoutSession'])->name('stripe.purchase');
Route::get('/bundle/success', [BundleContentController::class, 'success'])->name('bundle.success');
Route::get('live-tv-guide/channel/stream/{channelCode}', [TvGuidePlayerController::class, 'getChannelStreams'])->name('channel.streams');
Route::get('tv-guide-group/{tvGuidePlaylist}', [TvGuidePlayerController::class, 'watchTvGuideStreams']);

Route::get('email-ad-info/{id}', [PlayerScreenController::class, 'emailAdInfo']);

Route::get('{slug?}', [HomeController::class, 'index'])->name('home');

Route::get('check/remind/me', [NotifyComingSoonStreamController::class, 'checkRemindStatus'])->name('check.remind.me');
Route::post('remind/me', [NotifyComingSoonStreamController::class, 'toggleRemind'])->name('remind.me');

Route::post('/media-events', [VideoEventsController::class, 'store']);
Route::get('watch-party/code/{watch_party_code}', [WatchPartyController::class, 'joinWatchParty']);
Route::get('/watch-party/latest-player-state', [VideoEventsController::class, 'getLatestPlayerState']);
Route::post('/watch-party/check-expire-time', [VideoEventsController::class, 'checkExpireTime']);
// Route::view('ended-watch-party', 'watch_party.ended_party')->name('watch-party.ended');
Route::get('/watch/ended-watch-party', function () {
    return view('watch_party.ended_party');
})->name('watch-party.ended');

Route::get('/create/{streamCode}/watch/party', [WatchPartyController::class, 'create'])->name('create.watch.party');
Route::post('/store/watch/party', [WatchPartyController::class, 'store'])->name('store.watch.party');

//category streams call
Route::post('/categories/streams', [CategoryController::class, 'getStreams'])->name('categories.streams');
Route::post('/render-category-slider', [CategoryController::class, 'renderCategorySlider'])->name('render.category.slider');

//you might also like streams call detail screen
Route::post('/streams/related', [DetailScreenController::class, 'getRelatedStreams'])->name('streams.related');
//playerscreen
Route::post('/streams/playerstream', [PlayerScreenController::class, 'getplayerStreams'])->name('streams.player.related');
Route::post('/render-you-might-like', [DetailScreenController::class, 'renderYouMightLike'])->name('render.you-might-like');
Route::post('/render-playlist-items', [DetailScreenController::class, 'renderplaylist'])->name('render.renderplaylist');
