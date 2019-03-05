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
    });

    Route::group(['prefix' => 'banners'], function () {
        Route::get('/', 'BannerController@listAll')->name('admin.banner');
        Route::put('/', 'BannerController@createBanner');
        Route::post('/{id}/activation', 'BannerController@activateBanner');
        Route::post('/{id}/deactivation', 'BannerController@deactivateBanner');
        Route::delete('/{id}', 'BannerController@delBanner');
    });

    Route::get('comments', 'UserCommentController@listAll');
    Route::get('aboutme', 'AboutmeController@showPage');
    Route::put('aboutme', 'AboutmeController@setAboutme');

    Route::group(['prefix' => 'products'], function () {
        Route::get('categories', 'CategoryController@listAll')->name('admin.categories');
        Route::put('categories', 'CategoryController@createCategory');
        Route::post('categories/{id}', 'CategoryController@editCatetory');
        Route::delete('categories/{id}', 'CategoryController@delCatetory');

        Route::get('brands', 'BrandController@listAll');
        Route::get('brand-form', 'BrandController@showBrandForm');
        Route::put('brands', 'BrandController@createBrand');
        Route::post('brands/{id}', 'BrandController@editBrand');
        Route::delete('brands/{id}', 'BrandController@delBrand');
    });

    Route::get('clients', 'ClientController@clientList')->name('admin.dashboard');
    Route::get('clients/create-form', 'ClientController@showCreateNewClientForm');
    Route::put('clients', 'ClientController@createNewClient');
    Route::get('clients/{id}', 'ClientController@showEditClientForm');
    Route::post('clients/{id}', 'ClientController@editClient');
    Route::put('clients/{id}/authorization', 'ClientController@authorizeClient');
});
