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
use App\Constants;

Route::get('/test', function () {

});



Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users/regist', 'UserController@registView');
Route::POST('/users/regist/save', 'UserController@regist');
Route::get('/users/search', 'UserController@searchView');
Route::POST('/users/search/submit', 'UserController@search');

Route::resource('companies', 'CompanyController');
Route::POST('/companies/store', 'CompanyController@store');
Route::POST('/companies/search', 'CompanyController@search');

Route::get('/work_time', 'WorkTimeController@index');
Route::post('/work_time/search', 'WorkTimeController@search');
Route::post('/work_time/save', 'WorkTimeController@save');


Route::get('logout', 'Auth\LoginController@logout');
