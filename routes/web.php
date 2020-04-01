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

Route::get('/404', 'CustomController@notFound');

Route::get('/users/regist', 'UserController@registView')->middleware(Constants::AUTHORIZE_ADMIN);
Route::POST('/users/regist/save', 'UserController@regist')->middleware(Constants::AUTHORIZE_ADMIN);
Route::get('/users/search', 'UserController@searchView')->middleware(Constants::AUTHORIZE_ADMIN);
Route::POST('/users/search/submit', 'UserController@search')->middleware(Constants::AUTHORIZE_ADMIN);
Route::POST('/users/detail', 'UserController@detailView');
Route::POST('/users/update', 'UserController@update');
Route::get('/users/update/errors', 'UserController@updateError');

Route::get('/projects/regist','ProjectController@registView')->name('registProject');
Route::post('/projects/regist','ProjectController@regist')->name('saveProject');
Route::get('/projects/search', 'ProjectController@searchView')->name('searchProject');
Route::post('/projects/search','ProjectController@search')->name('searchProject');
Route::get('/projects/detail/{id}', 'ProjectController@detailView')->name('detailProject');
Route::post('/projects/update','ProjectController@update')->name('updateProject');
Route::post('/projects/remove/user', 'ProjectController@destroy');

Route::get('/salary/search','SalaryController');
Route::post('/salary/search','SalaryController@search')->name('searchSalary');
Route::get('/salary/regist','SalaryController@registView');
Route::post('/salary/regist','SalaryController@regist')->name('saveSalary');
Route::get('/salary/detail/{id}', 'SalaryController@detailView')->name('detailSalary');
Route::post('/salary/update','SalaryController@update')->name('updateSalary');

Route::resource('companies', 'CompanyController');
Route::POST('/companies/store', 'CompanyController@store');
Route::POST('/companies/search', 'CompanyController@search');

Route::get('/work_time', 'WorkTimeController@index');
Route::post('/work_time/search', 'WorkTimeController@search')->middleware('WorktimeAuthentication');
Route::post('/work_time/save', 'WorkTimeController@save')->middleware('WorktimeAuthentication');

Route::get('/customers/regist', 'CustomersController@registView')->middleware(Constants::AUTHORIZE_ADMIN);
Route::post('/customers/regist/save', 'CustomersController@regist')->middleware(Constants::AUTHORIZE_ADMIN);
Route::get('/customers/search', 'CustomersController@searchView')->middleware(Constants::AUTHORIZE_ADMIN);
Route::post('/customers/search/submit', 'CustomersController@search')->middleware(Constants::AUTHORIZE_ADMIN);
Route::post('/customers/detail', 'CustomersController@detailView')->middleware(Constants::AUTHORIZE_ADMIN);
Route::POST('/customers/update', 'CustomersController@update')->middleware(Constants::AUTHORIZE_ADMIN);
Route::get('/customers/update/errors', 'CustomersController@updateError')->middleware(Constants::AUTHORIZE_ADMIN);


Route::get('logout', 'Auth\LoginController@logout');
