<?php

use App\Http\Controllers\Api\SiteCloneController;
use App\Services\Api;
use App\Models\AppCofig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('refreshBackData', function () {
    $response = Http::timeout(300)->withHeaders(Api::headers())
        ->get(Api::endpoint("/masterfeed"));
    $appconfig = AppCofig::where('app_code', env('APP_CODE'))->first();
    if ($appconfig) {
        $appconfig->update(['api_data' => $response->body()]);
    } else {
        AppCofig::create(['app_code' => env('APP_CODE'), 'api_data' => $response->body()]);
    }
});

Route::post('createsubdomain', [SiteCloneController::class, 'createSubdomain']);
