<?php

use Illuminate\Http\Request;

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

Route::post('/register', 'Auth\RegisterController@register');
Route::group(['middleware' => ['check_api_key']], function () {
	Route::resource('/cameras', 'APICamerasController');
	Route::resource('/models', 'APIThreeDsController');
	Route::resource('/scenes', 'APIScenesController');
	Route::resource('/control-definitions', 'APIControlDefinitionsController');
});
