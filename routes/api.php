<?php

use Illuminate\Http\Request;
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

Route::prefix('v1')->group(function () {
    Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');
    Route::post('/register', 'App\Http\Controllers\Api\AuthController@register');
    Route::post('/registration', 'App\Http\Controllers\Api\RegistrationController@store');
    Route::get('/products/{product}', 'App\Http\Controllers\Api\ProductController@show');

    // Específico de Productos sin AUTH
    Route::get('/iii-foro/streaming-noauth', 'App\Http\Controllers\Api\IIIForoController@streamingNoAuth');

    // Necesita AUTH
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', 'App\Http\Controllers\Api\AuthController@logout');
        Route::get('/products', 'App\Http\Controllers\Api\ProductController@index');
        Route::get('/campaigns', 'App\Http\Controllers\Api\CampaignController@index');
        Route::get('/registrations/{product}', 'App\Http\Controllers\Api\RegistrationController@show');
        Route::get('/verify/{uniqueId}', 'App\Http\Controllers\Api\VerificationController@update');

        // Específico de Productos
        Route::get('/iii-foro/streaming', 'App\Http\Controllers\Api\IIIForoController@streaming');
        Route::get('/jornadacf/streaming', 'App\Http\Controllers\Api\JornadaCfController@streaming');
        Route::get('/ii-congreso/streaming', 'App\Http\Controllers\Api\IICongresoController@streaming');
        Route::get('/i-mbf/streaming', 'App\Http\Controllers\Api\ImbfController@streaming');
    });
});
