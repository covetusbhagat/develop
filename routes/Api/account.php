<?php

use App\Http\Controllers\Api\AuthController;


Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('otp_confirmation', [AuthController::class, 'confirmed_user_account'])->name('otp_confirmation');
Route::post('user', [AuthController::class, 'user'])->name('user');


/*Route::post('update_profile', [AuthController::class, 'update_profile'])->name('update_profile');
Route::put('change_password', [AuthController::class, 'change_password'])->name('change_password');*/