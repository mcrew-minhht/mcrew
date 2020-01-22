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

Route::get('/test', function () {
//    echo App::getLocale();
    echo __('widget.languages');
});



Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users/regist', 'UserController@registView');
Route::POST('/users/regist/save', 'UserController@regist');
Route::get('/users/search', 'UserController@searchView');
Route::POST('/users/search/submit', 'UserController@search');


Route::get('logout', 'Auth\LoginController@logout');
