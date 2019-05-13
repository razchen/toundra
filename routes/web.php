<?php

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

Auth::routes();

Route::get('/', 'PagesController@home');
Route::get('/dashboard', 'PagesController@dashboard');

/* User Routes */
Route::resource('/cameras', 'CamerasController');
Route::resource('/models', 'ThreeDsController');
Route::post('/upload-3d-json', 'ThreeDsController@upload3DJSON');
Route::resource('/scenes', 'ScenesController');
Route::resource('/control-definitions', 'ControlDefinitionsController');
Route::resource('/reports', 'ReportsController');

/* Admin Routes */
Route::resource('/users', 'UsersController');
Route::resource('/protocols', 'ProtocolsController');