<?php

use App\Http\Controllers\Website\User\CustomerController;
use App\Http\Controllers\Website\User\DeliveryController;
use App\Http\Controllers\Website\User\ShopkeeperController;


Route::group(['namespace' => 'User'], function () {

	Route::get('customer', [CustomerController::class, 'index'])->name('customer');
	Route::get('customer/getData', [CustomerController::class, 'getData'])->name('customer.getData');
	Route::get('customer/create', [CustomerController::class, 'create'])->name('customer.create');
	Route::post('customer/store', [CustomerController::class, 'store'])->name('customer.store');
	Route::get('customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
	Route::get('customer/edit_address/{id}', [CustomerController::class, 'edit_address'])->name('customer.edit_address');
	Route::post('customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
	Route::post('customer/update_address/{id}', [CustomerController::class, 'update_address'])->name('customer.update_address');
	Route::get('customer/deleted/{id}', [CustomerController::class, 'deleted'])->name('customer.deleted');
	Route::get('customer/display/{id}', [CustomerController::class, 'display'])->name('customer.display');
	Route::get('customer/aprove_document/{id}', [CustomerController::class, 'aprove_doc'])->name('customer.aprove_document');
	Route::get('customer/reject_document/{id}', [CustomerController::class, 'reject_doc'])->name('customer.reject_document');
	


	Route::get('delivery', [DeliveryController::class, 'index'])->name('delivery');
	Route::get('delivery/getData', [DeliveryController::class, 'getData'])->name('delivery.getData');
	Route::get('delivery/create', [DeliveryController::class, 'create'])->name('delivery.create');
	Route::post('delivery/store', [DeliveryController::class, 'store'])->name('delivery.store');
	Route::get('delivery/edit/{id}', [DeliveryController::class, 'edit'])->name('delivery.edit');
	Route::post('delivery/update/{id}', [DeliveryController::class, 'update'])->name('delivery.update');
	Route::get('delivery/deleted/{id}', [DeliveryController::class, 'delete'])->name('delivery.deleted');
	Route::get('delivery/display/{id}', [DeliveryController::class, 'display'])->name('delivery.display');



	Route::get('shopkeeper', [ShopkeeperController::class, 'index'])->name('shopkeeper');
	Route::get('shopkeeper/getData', [ShopkeeperController::class, 'getData'])->name('shopkeeper.getData');
	Route::get('shopkeeper/create', [ShopkeeperController::class, 'create'])->name('shopkeeper.create');
	Route::post('shopkeeper/store', [ShopkeeperController::class, 'store'])->name('shopkeeper.store');
	Route::get('shopkeeper/edit/{id}', [ShopkeeperController::class, 'edit'])->name('shopkeeper.edit');
	Route::get('shopkeeper/edit_address/{id}', [ShopkeeperController::class, 'edit_address'])->name('shopkeeper.edit_address');
	Route::post('shopkeeper/update/{id}', [ShopkeeperController::class, 'update'])->name('shopkeeper.update');
	Route::post('shopkeeper/update_address/{id}', [ShopkeeperController::class, 'update_address'])->name('shopkeeper.update_address');
	Route::get('shopkeeper/deleted/{id}', [ShopkeeperController::class, 'delete'])->name('shopkeeper.deleted');
	Route::get('shopkeeper/display/{id}', [ShopkeeperController::class, 'display'])->name('shopkeeper.display');

});


