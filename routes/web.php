<?php

use App\Http\Controllers\DetailScreenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\PlayerScreenController;

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
Route::get('/playerscreen/{id}', [PlayerScreenController::class, 'index'])->name('playerscreen');