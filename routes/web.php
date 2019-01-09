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
    return view('welcome');
});

Auth::routes(['verify'=> true]);

Route::get('/home', 'HomeController@index')->name('home');


/**Users**/
Route::get('/users', 'UsersController@index')->name('users');
Route::get('/users/add', 'UsersController@add')->name('users/add');
Route::post('/users/new', 'UsersController@news')->name('users/new');
Route::get('/users/edit/{id}', 'UsersController@edit');
Route::post('/users/update', 'UsersController@update')->name('users/update');
Route::get('/users/delete/{id}', 'UsersController@delete');
Route::post('/users/destroy', 'UsersController@destroy')->name('users/destroy');
/**Users**/
