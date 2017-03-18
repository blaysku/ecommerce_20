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

Route::get('/', 'Front\HomeController')->name('index');

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

    Route::post('suggest/reject/{id}', 'SuggestController@reject')->name('suggest.reject');
    Route::post('suggest/accept/{id}', 'SuggestController@accept')->name('suggest.accept');
    Route::resource('suggest', 'SuggestController', ['only' => ['index', 'show']]);
});

Route::group(['as' => 'front.'], function () {
    Route::post('product/add-to-cart/{id}', 'Front\ProductController@addToCart')->name('product.addToCart');
    Route::resource('product', 'Front\ProductController', ['only' => ['index', 'show']]);
    Route::resource('rating', 'Front\RatingController', ['only' => ['store', 'update']]);
    Route::post('cart/update', 'Front\CartController@update')->name('cart.update');
    Route::resource('cart', 'Front\CartController', ['only' => ['index', 'destroy'], 'before' => 'auth']);
    Route::get('checkout', 'Front\CartController@showCheckout')->name('cart.checkout');
    Route::post('checkout', 'Front\CartController@checkout');
    Route::post('user', 'Front\UserController@update')->name('user.update');
    Route::resource('user', 'Front\UserController', ['only' => 'show']);
    Route::resource('order', 'Front\OrderController', ['only' => ['show', 'update']]);
    Route::post('suggest', 'Front\SuggestController')->name('suggest');
});
