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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Api\Auth\AuthController@register');
Route::post('login', 'Api\Auth\AuthController@login');

Route::get('news', 'Api\NewsController@News');
Route::get('news/{id}', 'Api\NewsController@NewsById');

Route::post('news', 'Api\NewsController@NewsAdd');
Route::put('news/{id}', 'Api\NewsController@NewsEdit');
Route::delete('news/{id}', 'Api\NewsController@NewsDelete');
