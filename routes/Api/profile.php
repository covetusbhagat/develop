<?php

use App\Http\Controllers\Api\ProfileController;


Route::get('profile', [ProfileController::class, 'index'])->name('profile');
Route::post('update_profile', [ProfileController::class, 'update_profile'])->name('update_profile');

Route::post('add_address', [ProfileController::class, 'add_address'])->name('add_address');
Route::post('remove_address', [ProfileController::class, 'remove_address'])->name('remove_address');
Route::post('change_password', [ProfileController::class, 'change_password'])->name('change_password');

 
/*Route::post('update_profile', [AuthController::class, 'update_profile'])->name('update_profile');
Route::put('change_password', [AuthController::class, 'change_password'])->name('change_password');*/