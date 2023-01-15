<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PassportAuthController;
use App\Http\Controllers\PlatformController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::get('platforms', [PlatformController::class, 'index'])->name('platform.index');
    Route::post('platforms/create', [PlatformController::class, 'store'])->name('platform.create');
    Route::put('platforms/{platform}/edit', [PlatformController::class, 'update'])->name('platform.update');
});
