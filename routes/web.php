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

Route::get('/', 'HomeController@index')->name('home');
Auth::routes();

Route::resource('meals', 'MealController');
Route::resource('meals.products', 'Meal\ProductController')->only(
  ['create', 'store', 'destroy']
);

Route::resource('products', 'ProductController')->only(
  ['index', 'show']
);
