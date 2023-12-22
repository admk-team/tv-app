<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DetailScreenController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Page\PageController;
use App\Http\Controllers\PlayerScreenController;
use App\Http\Controllers\Search\SearchController;
use App\Http\Controllers\DownloadApps\DownloadAppsController;
use App\Http\Controllers\Subscription\SubscriptionController;
use App\Http\Controllers\Monetization\MonetizationController;
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

// Authenticated Routes
Route::middleware('auth.user')->group(function () {

});

Route::get('/get-ad', [AdController::class, 'index'])->name('get-ad');
Route::get('/detailscreen/{id}', [DetailScreenController::class, 'index'])->name('detailscreen');
Route::get('/page/{slug}', [PageController::class, 'index'])->name('page');
Route::post('/contact-us', [PageController::class, 'submit'])->name('contactus.submit');
Route::get('/playerscreen/{id}', [PlayerScreenController::class, 'index'])->name('playerscreen');
Route::get('/searchscreen', [SearchController::class, 'index'])->name('search');
Route::get('/download-apps', [DownloadAppsController::class, 'index'])->name('downloadapps');
Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription');
Route::post('/monetization', [MonetizationController::class, 'index'])->name('monetization');
Route::get('/monetization/cancel', [MonetizationController::class, 'cancel'])->name('monetization.cancel');
Route::get('/{slug?}', [HomeController::class, 'index'])->name('home');