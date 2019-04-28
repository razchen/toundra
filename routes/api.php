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

Route::fallback(function(){
    return response()->json(['error' => 'Resource not found.'], 404);
})->name('fallback');

Route::post('/register', 'Auth\RegisterController@register');
Route::group(['middleware' => ['check_api_key']], function () {
	Route::resource('/cameras', 'CamerasController');
	Route::resource('/models', 'ThreeDsController');
	Route::resource('/scenes', 'ScenesController');
	Route::resource('/control-definitions', 'ControlDefinitionsController');
	Route::resource('/reports', 'ReportsController');
});
