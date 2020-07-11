<?php

use App\Contracts\UrlService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{urlKey}', function (string $urlKey) {
    /** @var UrlService $urlService */
    $urlService = app(UrlService::class);

    $originalUrl = $urlService->findOriginalUrlByUrlKey($urlKey);

    return redirect($originalUrl);
})->name('show');
