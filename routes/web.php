<?php


use App\Http\Controllers\Home_controller;
use App\Http\Controllers\Website\HomeController;

Auth::routes();

//Auth::routes(['verify' => true]);

Route::get('/', [Home_controller::class, 'index']);
Route::post('/login', [Home_controller::class, 'login'])->name('login');

Route::get('get_credentials', [Home_controller::class, 'get_credentials'])->name('get_credentials');
Route::post('forget_password', [Home_controller::class, 'forget_password'])->name('forget_password');
Route::get('reset_password', [Home_controller::class, 'reset_password'])->name('reset_password');
Route::post('update_password', [Home_controller::class, 'update_password'])->name('update_password');


Route::group(['namespace' => 'Website', 'as' => 'website.', 'middleware' => 'auth'], function () {

	Route::post('/get_notification', [HomeController::class, 'get_notification'])->name('get_notification');
	Route::post('/get_notification_count', [HomeController::class, 'get_notification_count'])->name('get_notification_count');
	Route::post('/get_chat_user', [HomeController::class, 'get_chat_user'])->name('get_chat_user');
	Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
	Route::get('/verification', [HomeController::class, 'show_verify'])->name('verification');
	Route::post('/check_verification', [HomeController::class, 'check_verify'])->name('check_verification');
	

    Route::group(['middleware' => 'verification'], function () {
		include_route_files(__DIR__.'/Website/');
	});
});