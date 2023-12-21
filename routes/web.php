<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DetailScreenController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Page\PageController;
use App\Http\Controllers\PlayerScreenController;
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

Route::get('signup', [RegisterController::class, 'index'])->name('register');
Route::post('signup', [RegisterController::class, 'register'])->name('register');

Route::get('/get-ad', [AdController::class, 'index'])->name('get-ad');
Route::get('/{slug?}', [HomeController::class, 'index'])->name('home');
Route::get('/detailscreen/{id}', [DetailScreenController::class, 'index'])->name('detailscreen');
Route::get('/page/{slug}', [PageController::class, 'index'])->name('page');
Route::post('/contact-us', [PageController::class, 'submit'])->name('contactus.submit');
Route::get('/playerscreen/{id}', [PlayerScreenController::class, 'index'])->name('playerscreen');
