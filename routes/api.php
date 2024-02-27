<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(
    ['namespace' => 'App\Http\Controllers\Api'],
    function () {
        Route::post('/login', 'AuthController@login');
        Route::post('/register', 'AuthController@register');
        Route::post('/password/create', 'AuthController@resetPassword');
        Route::post('/password/reset-password', 'AuthController@resend');
        Route::post('/password/resend-password-create', 'AuthController@resend');
        Route::post('/refresh-token', 'AuthController@refreshToken');

        Route::middleware(['auth:sanctum'])->group(function () {
            Route::delete('/logout', 'AuthController@logout');
            Route::get('/category', 'CategoryController@index');
            Route::get('/category/{category}', 'CategoryController@show');
            Route::post('/category/create', 'CategoryController@store');
            Route::put('/category/update/{category}', 'CategoryController@update');

            Route::get('/product', 'ProductController@index');
            Route::get('/product/{product}', 'ProductController@show');
            Route::post('/product/upload-attachment', 'ProductController@uploadAttachments');
            Route::post('/product/create', 'ProductController@store');
            Route::put('/product/update/{product}', 'ProductController@update');
            Route::delete('/product/delete/{product}', 'ProductController@delete');
        });
        Route::get('/category-list', 'CategoryController@mainCategories');
        Route::get('/sub-category-list', 'CategoryController@subCategories');

        Route::group(['prefix' => '/cart'], function () {
            Route::get('/', 'ShoppingCartController@index');
            Route::post('/add/{product}', 'ShoppingCartController@addProduct');
            Route::post('/update/{product}', 'ShoppingCartController@updateProduct');
            Route::post('/remove/{product}', 'ShoppingCartController@removeProduct');
            Route::post('/checkout-order', 'OrderController@createOrder');
        });
        Route::get('/product-list', 'ProductController@productList');
        Route::get('/product-show/{product}', 'ProductController@singleProduct');
    }
);