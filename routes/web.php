<?php

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\DetailScreen\DetailScreenController;
use App\Http\Controllers\Page\PageController;
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

Route::get('/{slug?}', [HomeController::class, 'index'])->name('home');
Route::get('/detailscreen/{id}', [DetailScreenController::class, 'index'])->name('detailscreen');
Route::get('/page/{slug}', [PageController::class, 'index'])->name('page');
Route::post('/contact-us', [PageController::class, 'submit'])->name('contactus.submit');