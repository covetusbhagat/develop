<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;

/*header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');*/

    
Route::group(['namespace' => 'Api'], function () {

	Route::get('test', [AuthController::class, 'index'])->name('test');

	Route::get('state', [ProfileController::class, 'get_States'])->name('state');
	Route::post('city', [ProfileController::class, 'get_city_by_state'])->name('city');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('signup', [AuthController::class, 'signup'])->name('signup');

    Route::get('get_subcategory_list/{id}', [CategoryController::class, 'subcategory_by_category'])->name('get_subcategory_list');
    Route::post('product_by_subcategory', [ProductController::class, 'product_by_subcategory'])->name('product_by_subcategory');
    Route::get('get_city_list/{id}', [ProfileController::class, 'city_by_state'])->name('get_city_list');
    Route::post('product_detail', [ProductController::class, 'product_detail'])->name('product_detail');

    Route::post('search_product', [ProductController::class, 'search_product'])->name('search_product');
    Route::post('filter_list', [ProductController::class, 'filter_list'])->name('filter_list');
    Route::post('filter_product_list', [ProductController::class, 'filter_product_list'])->name('filter_product_list');
    
    Route::post('search_product_suggestion', [ProductController::class, 'search_product_suggestion'])->name('search_product_suggestion');

     Route::get('product_short_by', [ProductController::class, 'product_short_by'])->name('product_short_by');

    Route::post('running_rental_product_list', [ProductController::class, 'running_rental_product_list'])->name('running_rental_product_list');
    
    Route::get('slider_list', [ProductController::class, 'get_slider_list'])->name('slider_list');
    Route::post('home_category_by_product_list', [ProductController::class, 'home_category_by_product_list'])->name('home_category_by_product_list');
    

    Route::get('category_subcategory', [CategoryController::class, 'all_category_subcategory'])->name('category_subcategory');

    Route::post('resent_email_otp', [AuthController::class, 'resent_email_otp'])->name('resent_email_otp');
	Route::post('resent_mobile_otp', [AuthController::class, 'resent_mobile_otp'])->name('resent_mobile_otp');

    Route::post('forget_password', [AuthController::class, 'forget_password'])->name('forget_password');

    Route::post('featured_product_list', [ProductController::class, 'featured_product_list'])->name('featured_product_list');
   // Route::post('push_notification', [AuthController::class, 'push_notification'])->name('push_notification');

    
    Route::group(['middleware' => 'auth:api'], function() {

        include_route_files(__DIR__.'/Api/');

    });

});