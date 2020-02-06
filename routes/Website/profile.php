<?php

use App\Http\Controllers\Website\Profile\ProfileController;


Route::group(['namespace' => 'Profile'], function () {

	Route::get('profile', [ProfileController::class, 'index'])->name('profile');
	Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');
	Route::post('profile/reset_password', [ProfileController::class, 'reset_password'])->name('discount.reset_password');
	Route::post('profile/add_new_address', [ProfileController::class, 'add_address'])->name('profile/add_new_address');
	Route::get('profile/remove_address/{id}', [ProfileController::class, 'remove_address'])->name('profile.remove_address');
});