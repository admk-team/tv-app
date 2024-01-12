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
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScreenerController;
use App\Http\Controllers\WishlistController;
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

// Authentication
Route::get('signup', [RegisterController::class, 'index'])->name('register');
Route::post('signup', [RegisterController::class, 'register'])->name('register');
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('logout', [LogoutController::class, 'index'])->name('logout');

// Authenticated Routes
Route::middleware('auth.user')->group(function () {
    Route::post('monetization', [MonetizationController::class, 'index'])->name('monetization');
    Route::get('monetization/success', [MonetizationController::class, 'success'])->name('monetization.success');
    Route::get('monetization/cancel', [MonetizationController::class, 'cancel'])->name('monetization.cancel');
    Route::post('stripe/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
    Route::get('stripe/success', [StripeController::class, 'success'])->name('stripe.success');
    Route::get('password/edit', [PasswordUpdateController::class, 'index'])->name('password.edit');
    Route::post('password/update', [PasswordUpdateController::class, 'update'])->name('password.update');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
});

Route::get('get-ad', [AdController::class, 'index'])->name('get-ad');
Route::get('detailscreen/{id}', [DetailScreenController::class, 'index'])->name('detailscreen');
Route::get('page/{slug}', [PageController::class, 'index'])->name('page');
Route::post('contact-us', [PageController::class, 'submit'])->name('contactus.submit');
Route::get('playerscreen/{id}', [PlayerScreenController::class, 'index'])->name('playerscreen');
Route::post('playerscreen-checkpassword', [PlayerScreenController::class, 'checkPassword'])->name('playerscreen.checkpassword');
Route::post('playerscreen-checkscreenerpassword', [PlayerScreenController::class, 'checkScreenerPassword'])->name('playerscreen.checkscreenerpassword');
Route::get('searchscreen', [SearchController::class, 'index'])->name('search');
Route::get('download-apps', [DownloadAppsController::class, 'index'])->name('downloadapps');
Route::get('subscription', [SubscriptionController::class, 'index'])->name('subscription');
Route::get('free-subscription', [FreeSubscriptionController::class, 'index'])->name('free-subscription');
Route::get('transaction-history', [TransactionHistoryController::class, 'index'])->name('transaction-history');
Route::get('category/{id}', [CategoryController::class, 'index'])->name('category');

Route::get('advisory/{id}', [AdvisoryController::class, 'index'])->name('advisory');
Route::get('language/{id}', [LanguageController::class, 'index'])->name('language');

Route::get('person/{id?}', [PersonController::class, 'index'])->name('person');
Route::post('addrating', [DetailScreenController::class, 'addRating'])->name('addrating');
Route::post('wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

// Screener
Route::get('screener/{code}/{itemIndex?}', [ScreenerController::class, 'player'])->name('screener.player');
Route::post('screener/authenticate/{code}', [ScreenerController::class, 'authenticate'])->name('screener.authenticate');

Route::get('{slug?}', [HomeController::class, 'index'])->name('home');