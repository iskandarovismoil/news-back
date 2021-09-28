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

Route::post('register', 'Api\Auth\AuthController@register');
Route::post('login', 'Api\Auth\AuthController@login');
Route::get('user/{id}', 'Api\Auth\AuthController@user');

Route::get('news', 'Api\NewsController@News');
Route::get('news/{id}', 'Api\NewsController@news_by_id');
Route::get('news/{userid}/all', 'Api\NewsController@news_by_userid');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('/my', 'Api\NewsController@news_my');
    Route::post('/add', 'Api\NewsController@news_add');
    Route::put('/edit/{id}', 'Api\NewsController@news_edit');
    Route::delete('/delete/{id}', 'Api\NewsController@news_delete');
});

