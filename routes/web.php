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

Route::get('/', function () {
    return view('home');
});

Route::get('/',                         'HomeController@index');
Route::get('login',						'AuthController@loginForm');
Route::post('login',					'AuthController@login');
Route::get('logout',					'AuthController@logout');

Route::get('my-account',			    'UsersController@myAccount');
Route::get('users/change-pass/{id}',	'UsersController@newPassword');
Route::post('users/change-pass',		'UsersController@changePassword');
Route::resource('users',                'UsersController');

Route::get('reports/test',              'ReportsController@index');
Route::get('reports/daily',             'ReportsController@daily');


Route::get('home/calendar',             'HomeController@calendar');
Route::resource('home',                 'HomeController');
Route::resource('categories',           'CategoryController');
Route::resource('accounts',             'AccountsController');
Route::resource('ledger',               'LedgerController');
Route::get('transactions/list/{type}',	'TransactionsController@listTypes');
Route::resource('transactions',         'TransactionsController');
Route::resource('expense',              'ExpenseController');