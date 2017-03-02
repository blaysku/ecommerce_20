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

Route::get('register/verify/{confirmationCode}', 'Auth\RegisterController@confirmEmail')->name('verify.email');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('user/{role?}', 'UserController@index')->where('role', '[a-z]+')->name('user.index');
    Route::put('user/changestatus/{id}', 'UserController@changeStatusWithAjax')->name('user.status');
    Route::resource('user', 'UserController', ['except' => 'index']);
});
