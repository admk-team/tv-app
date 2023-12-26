<?php

use App\Http\Controllers\AdController;
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
});

Route::get('get-ad', [AdController::class, 'index'])->name('get-ad');
Route::get('detailscreen/{id}', [DetailScreenController::class, 'index'])->name('detailscreen');
Route::get('page/{slug}', [PageController::class, 'index'])->name('page');
Route::post('contact-us', [PageController::class, 'submit'])->name('contactus.submit');
Route::get('playerscreen/{id}', [PlayerScreenController::class, 'index'])->name('playerscreen');
Route::get('searchscreen', [SearchController::class, 'index'])->name('search');
Route::get('download-apps', [DownloadAppsController::class, 'index'])->name('downloadapps');
Route::get('subscription', [SubscriptionController::class, 'index'])->name('subscription');
Route::get('free-subscription', [FreeSubscriptionController::class, 'index'])->name('free-subscription');
Route::get('transaction-history', [TransactionHistoryController::class, 'index'])->name('transaction-history');
Route::get('{slug?}', [HomeController::class, 'index'])->name('home');