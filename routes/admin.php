<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'aaa'], function () {
    Route::get('login', 'AuthController@showLoginForm')->name('admin.login');
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');
});

Route::group(['middleware' => 'auth:admin'], function () {
    Route::group(['prefix' => 'aaa'], function () {
        Route::get('password-changing', 'AuthController@showPasswordChangingForm');
        Route::post('password-changing', 'AuthController@passwordChanging');
    });

    Route::group(['prefix' => 'adminusers'], function () {
        Route::get('create-form', 'AdminUserController@addAdminUserForm');
        Route::put('/', 'AdminUserController@addAdminUser');
        Route::get('/', 'AdminUserController@listAll')->name('admin.list');
        Route::delete('/{id}', 'AdminUserController@delAdminUser');
        Route::get('{id}/password-reset', 'AdminUserController@resetPasswordForm');
        Route::post('{id}/password-reset', 'AdminUserController@resetPassword');
    })->middleware('can:manage-adminuser');

    Route::get('clients', 'ClientController@clientList')->name('admin.dashboard');
    Route::get('clients/create-form', 'ClientController@showCreateNewClientForm');
    Route::put('clients', 'ClientController@createNewClient');
    Route::get('clients/{id}', 'ClientController@showEditClientForm');
    Route::post('clients/{id}', 'ClientController@editClient');
    Route::put('clients/{id}/authorization', 'ClientController@authorizeClient');
});
