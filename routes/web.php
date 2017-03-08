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
    Route::get('user/{role?}', 'UserController@index')->where('role', config('setting.admin'))->name('user.index');
    Route::put('user/changestatus/{id}', 'UserController@changeStatusWithAjax')->name('user.status');
    Route::resource('user', 'UserController', ['except' => 'index']);

    Route::resource('category', 'CategoryController', ['except' => ['show', 'create']]);

    Route::put('product/trending/{id}', 'ProductController@changTrendingAjax')->name('product.trending');
    Route::resource('product', 'ProductController', ['except' => 'show']);

    Route::put('order/change-status/{id}', 'OrderController@changeStatusWithAjax')->name('order.status');
    Route::resource('order', 'OrderController', ['only' => ['index', 'show']]);
});
