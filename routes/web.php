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

/* User Routes */
Route::resource('/cameras', 'CamerasController');
Route::resource('/models', 'ThreeDsController');
Route::resource('/scenes', 'ScenesController');

/* Admin Routes */
Route::resource('/admin/cameras', 'AdminCamerasController');
Route::resource('/admin/models', 'AdminThreeDsController');
Route::resource('/admin/scenes', 'AdminScenesController');
Route::resource('/protocols', 'ProtocolsController');