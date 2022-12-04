<?php

use App\Http\Controllers\Api\v1\DictionaryController;
use App\Http\Controllers\Api\v1\DocumentController;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => ['api', 'CheckApiToken'], 'prefix' => 'v1'], function () {
    Route::get('/dictionary', [DictionaryController::class, 'index']);
    Route::post('/document/store', [DocumentController::class, 'store']);
});
