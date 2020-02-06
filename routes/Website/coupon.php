<?php

use App\Http\Controllers\Website\Coupon\DiscountController;
use App\Http\Controllers\Website\Coupon\ReferralController;


Route::group(['namespace' => 'Coupon'], function () {


	Route::get('discount', [DiscountController::class, 'index'])->name('discount');
	Route::get('discount/getrecord', [DiscountController::class, 'getrecord'])->name('discount.getrecord');
	Route::get('discount/create', [DiscountController::class, 'create'])->name('discount.create');
	Route::post('discount/store', [DiscountController::class, 'store'])->name('discount.store');
	Route::get('discount/edit/{id}', [DiscountController::class, 'edit'])->name('discount.edit');
	Route::post('discount/update/{id}', [DiscountController::class, 'update'])->name('discount.update');
	Route::get('discount/deleted/{id}', [DiscountController::class, 'deleted'])->name('discount.deleted');
	


	Route::get('referral', [ReferralController::class, 'index'])->name('referral');
	Route::get('discount/getData', [ReferralController::class, 'getData'])->name('referral.getData');
	Route::get('referral/edit/{id}', [ReferralController::class, 'edit'])->name('referral.edit');
	Route::post('referral/update/{id}', [ReferralController::class, 'update'])->name('referral.update');
	
});

