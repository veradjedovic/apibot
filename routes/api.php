<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

// Customers
Route::get('/customers', 'Api\CustomerController@index')->name('customers.index');
Route::post('/customers', 'Api\CustomerController@store')->name('customers.store');
Route::get('/customers/{customer}', 'Api\CustomerController@show')->name('customers.show');
Route::put('/customers/{customer}', 'Api\CustomerController@update')->name('customers.update');
Route::delete('/customers/{customer}', 'Api\CustomerController@destroy')->name('customers.destroy');

// Orders
Route::get('/orders', 'Api\OrderController@index')->name('orders.index');
Route::post('/orders', 'Api\OrderController@store')->name('orders.store');
Route::get('/orders/{order}', 'Api\OrderController@show')->name('orders.show');
Route::put('/orders/{order}', 'Api\OrderController@update')->name('orders.update');
Route::delete('/orders/{order}', 'Api\OrderController@destroy')->name('orders.destroy');

// Soap
Route::get('/soap', 'Api\SoapController@index')->name('soap.index');
