<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PassportAuthController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\DividendController;
use App\Http\Controllers\CurrencyController;

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
    Route::delete('platforms/{platform}/delete', [PlatformController::class, 'delete'])->name('platform.delete');

    Route::get('portfolios', [PortfolioController::class, 'index'])->name('portfolio.index');
    Route::get('portfolios/{portfolio}', [PortfolioController::class, 'show'])->name('portfolio.show');
    Route::post('portfolios/create', [PortfolioController::class, 'store'])->name('portfolio.create');
    Route::put('portfolios/{portfolio}/edit', [PortfolioController::class, 'update'])->name('portfolio.update');
    Route::delete('portfolios/{portfolio}/delete', [PortfolioController::class, 'delete'])->name('portfolio.delete');

    Route::get('dividends/{portfolio?}', [DividendController::class, 'index'])->name('dividend.index');
    Route::post('dividends/create', [DividendController::class, 'store'])->name('dividend.store');
    Route::post('dividends/{portfolio}/create', [DividendController::class, 'storeMultiple'])->name('dividend.storeMultiple');
    Route::put('dividends/{dividend}/edit', [DividendController::class, 'update'])->name('dividend.update');
    Route::delete('dividends/{dividend}/delete', [DividendController::class, 'delete'])->name('dividend.delete');

    Route::get('companies', [\App\Http\Controllers\CompanyController::class, 'index'])->name('company.index');
    Route::get('currencies', [CurrencyController::class, 'index'])->name('currency.index');
});

Route::middleware(['auth:api', 'admin'])->group(function () {
    Route::post('admin/companies/create', [CompanyController::class, 'store'])->name('admin.company.index');
});
