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

    Route::get('/ii-foro/streaming-noauth', 'App\Http\Controllers\Api\IIForoController@streamingNoAuth');
    Route::get('/ii-foro/registrations-noauth', 'App\Http\Controllers\Api\IIForoController@registrationsNoAuth');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', 'App\Http\Controllers\Api\AuthController@logout');
        Route::get('/products/{product}', 'App\Http\Controllers\Api\ProductController@show');

        // Específico del Foro
        Route::get('/ii-foro/streaming', 'App\Http\Controllers\Api\IIForoController@streaming');
        Route::get('/ii-foro/registrations', 'App\Http\Controllers\Api\IIForoController@registrations');
    });
});
