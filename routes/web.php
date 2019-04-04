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

Route::get('/', 'IndexController@index');
Route::get('products', 'IndexController@listProducts');
Route::get('brands', 'IndexController@listBrands');
Route::get('comment', 'IndexController@showCommentForm');
Route::put('comment', 'IndexController@addComment');
Route::get('aboutme', 'IndexController@aboutme');
