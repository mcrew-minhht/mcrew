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

Route::get('/users/regist', 'UserController@registView')->name('user_regist')->middleware(Constants::AUTHORIZE_ADMIN);
Route::POST('/users/regist/save', 'UserController@regist')->middleware(Constants::AUTHORIZE_ADMIN);
Route::get('/users/search', 'UserController@searchView')->name('user_search')->middleware(Constants::AUTHORIZE_ADMIN);
Route::POST('/users/search/submit', 'UserController@search')->middleware(Constants::AUTHORIZE_ADMIN);
Route::POST('/users/detail', 'UserController@detailView');
Route::POST('/users/update', 'UserController@update')->name('user_update');
Route::get('/users/password', 'UserController@editPassword')->name('user_password');
Route::POST('/users/password', 'UserController@updatePassword');
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
Route::get('/salary/regist','SalaryController@registView')->name('registSalary');
Route::post('/salary/regist','SalaryController@regist')->name('saveSalary');
Route::get('/salary/detail/{id}', 'SalaryController@detailView')->name('detailSalary');
Route::post('/salary/update','SalaryController@update')->name('updateSalary');

Route::get('companies/regist', 'CompanyController@create')->name('companyRegist');
Route::POST('/companies/store', 'CompanyController@store');
Route::get('/companies/search','CompanyController@index')->name('companySearch');
Route::POST('/companies/search', 'CompanyController@search');
Route::get('/companies/detail/{id}', 'CompanyController@detailView')->name('detailCompany');
Route::POST('/companies/update', 'CompanyController@update');

Route::get('/work_time', 'WorkTimeController@index')->name('worktime');
Route::post('/work_time/search', 'WorkTimeController@search')->middleware('WorktimeAuthentication');
Route::post('/work_time/save', 'WorkTimeController@save')->middleware('WorktimeAuthentication');

Route::get('/customers/regist', 'CustomersController@registView')->name('customerRegist')->middleware(Constants::AUTHORIZE_ADMIN);
Route::post('/customers/regist/save', 'CustomersController@regist')->middleware(Constants::AUTHORIZE_ADMIN);
Route::get('/customers/search', 'CustomersController@searchView')->name('customerSearch')->middleware(Constants::AUTHORIZE_ADMIN);
Route::post('/customers/search/submit', 'CustomersController@search')->middleware(Constants::AUTHORIZE_ADMIN);
Route::post('/customers/detail', 'CustomersController@detailView')->middleware(Constants::AUTHORIZE_ADMIN);
Route::POST('/customers/update', 'CustomersController@update')->middleware(Constants::AUTHORIZE_ADMIN);
Route::get('/customers/update/errors', 'CustomersController@updateError')->middleware(Constants::AUTHORIZE_ADMIN);

Route::get('/salary/calc', 'SalaryController@calcView')->name('calcSalary');;
Route::post('/salary/calc/search', 'SalaryController@calcSearch')->middleware(Constants::AUTHORIZE_ADMIN);


Route::get('logout', 'Auth\LoginController@logout');
