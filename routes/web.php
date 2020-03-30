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
// dd(file_exists( public_path('pdfs') ));
mkdir(public_path('pdfs'));
});



Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users/regist', 'UserController@registView')->middleware(Constants::AUTHORIZE_ADMIN);
Route::POST('/users/regist/save', 'UserController@regist')->middleware(Constants::AUTHORIZE_ADMIN);
Route::get('/users/search', 'UserController@searchView')->middleware(Constants::AUTHORIZE_ADMIN);
Route::POST('/users/search/submit', 'UserController@search')->middleware(Constants::AUTHORIZE_ADMIN);
Route::POST('/users/detail', 'UserController@detailView');
Route::POST('/users/update', 'UserController@update');
Route::get('/users/update/errors', 'UserController@updateError');

Route::resource('companies', 'CompanyController');
Route::POST('/companies/store', 'CompanyController@store');
Route::POST('/companies/search', 'CompanyController@search');

Route::get('/work_time', 'WorkTimeController@index');
Route::post('/work_time/search', 'WorkTimeController@search')->middleware('WorktimeAuthentication');
Route::post('/work_time/save', 'WorkTimeController@save')->middleware('WorktimeAuthentication');


Route::get('logout', 'Auth\LoginController@logout');
