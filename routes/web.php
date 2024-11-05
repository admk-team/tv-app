<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AdvisoryController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
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
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QualityController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ScreenerController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TvGuidePlayerController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\YearController;
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

Route::get('/script', function ($cmd) {
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
Route::middleware('throttle:2,1')->group(
    function () {
        Route::post('signup', [RegisterController::class, 'register'])->name('register');
    }
);
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('logout', [LogoutController::class, 'index'])->name('logout');
//Email Verification
Route::get('verify', [LoginController::class, 'verify'])->name('verify');
Route::post('verify', [LoginController::class, 'verifyEmail'])->name('verify');
//forgot password
Route::get('forgot', [LoginController::class, 'forgot'])->name('forgot');
Route::post('forgot', [LoginController::class, 'forgotPassword'])->name('forgot');
// Authenticated Routes
Route::middleware('auth.user')->group(function () {
    Route::match(['get', 'post'], 'monetization', [MonetizationController::class, 'index'])->name('monetization');
    Route::post('apply-coupon', [MonetizationController::class, 'applyCoupon'])->name('apply-coupon');
    Route::match(['get', 'post'], 'monetization/success', [MonetizationController::class, 'success'])->name('monetization.success');
    Route::get('monetization/cancel', [MonetizationController::class, 'cancel'])->name('monetization.cancel');
    Route::post('stripe/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
    Route::get('stripe/success', [StripeController::class, 'success'])->name('stripe.success');
    Route::get('password/edit', [PasswordUpdateController::class, 'index'])->name('password.edit');
    Route::post('password/update', [PasswordUpdateController::class, 'update'])->name('password.update');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('manageprofile/{id}', [ProfileController::class, 'manage_profile'])->name('profile.manage');
    Route::get('/view/profile/{id}', [ProfileController::class, 'view_profile'])->name('profile.view_profile');
    //watch history
    Route::get('watch/history', [ProfileController::class, 'history'])->name('watch.history');
    //
    Route::post('extra/video', [PlayerScreenController::class, 'extraVideo'])->name('extra-video');
});

Route::get('get-ad', [AdController::class, 'index'])->name('get-ad');
Route::get('detailscreen/{id}', [DetailScreenController::class, 'index'])->name('detailscreen');
Route::get('page/{slug}', [PageController::class, 'index'])->name('page');
Route::post('contact-us', [PageController::class, 'submit'])->name('contactus.submit');
Route::get('playerscreen/{id}', [PlayerScreenController::class, 'index'])->name('playerscreen'); // Main Player Screen
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
Route::post('addrating', [DetailScreenController::class, 'addRating'])->name('addrating');
Route::post('wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

// Screener
Route::get('screener/{code}/{itemIndex?}', [ScreenerController::class, 'player'])->name('screener.player');
Route::post('screener/authenticate/{code}', [ScreenerController::class, 'authenticate'])->name('screener.authenticate');


Route::get('{slug?}', [HomeController::class, 'index'])->name('home');
Route::get('/epgplayer/{channelGuid}/{slug}', [TvGuidePlayerController::class, 'index'])->name('player.tvguide');
//Newsletter
Route::post('newsletter', [NewsLetterController::class, 'newLetter'])->name('newsletter');

Route::get('follow/{code?}', [FollowController::class, 'follow'])->name('toggle.follow');
Route::post('channel/subscribe', [ChannelSubscribeController::class, 'toggleSubscribe'])->name('toggle.subscribe');

Route::post('video/download', [GumletController::class, 'uploadGumlet'])->name('video.convert');
