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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('products', 'ProductsController@index')->name('products');
Route::get('add-product','ProductsController@addProduct')->name('add-product');

Route::get('orders', 'OrdersController@index')->name('orders');
Route::get('new-order','OrdersController@newOrder')->name('new-order');

Route::get('suppliers', 'SuppliersController@index')->name('suppliers');
Route::get('new-supplier','SuppliersController@newSupplier')->name('new-supplier');

