<?php

use App\Http\Controllers\Api\CouponController;


Route::post('active_coupon', [CouponController::class, 'all_active_coupon'])->name('active_coupon');


/*Route::post('update_profile', [AuthController::class, 'update_profile'])->name('update_profile');
Route::put('change_password', [AuthController::class, 'change_password'])->name('change_password');*/