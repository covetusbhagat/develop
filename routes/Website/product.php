<?php

use App\Http\Controllers\Website\Product\ProductController;
use App\Http\Controllers\Website\Product\InventoryController;
use App\Http\Controllers\Website\Product\ShopInventoryController;

Route::group(['namespace' => 'Product'], function () {

	Route::get('product', [ProductController::class, 'index'])->name('product');
	Route::get('product/getrecord', [ProductController::class, 'getrecord'])->name('product.getrecord');
	Route::get('product/create', [ProductController::class, 'create'])->name('product.create');
	Route::post('product/store', [ProductController::class, 'store'])->name('product.store');
	Route::get('product/display/{id}', [ProductController::class, 'display'])->name('product.display');


		Route::group(['middleware' => 'isadmin'], function () {
			Route::get('product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
			Route::post('product/update/{id}', [ProductController::class, 'update'])->name('product.update');
			Route::get('product/deleted/{id}', [ProductController::class, 'deleted'])->name('product.deleted');
			Route::get('product/remove_image/{id}', [ProductController::class, 'image_remove'])->name('product.remove_image');
			Route::get('product/report', [ProductController::class, 'report'])->name('product.report');
			
		});




	Route::group(['middleware' => 'isadmin'], function () {
		Route::get('inventory', [InventoryController::class, 'index'])->name('inventory');
		Route::get('inventory/getdata', [InventoryController::class, 'getdata'])->name('inventory.getdata');
		Route::get('inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
		Route::post('inventory/store', [InventoryController::class, 'store'])->name('inventory.store');
		Route::get('inventory/edit/{id}', [InventoryController::class, 'edit'])->name('inventory.edit');
		Route::post('inventory/update/{id}', [InventoryController::class, 'update'])->name('inventory.update');
		Route::post('inventory/update_quantity/{id}', [InventoryController::class, 'update_quantity'])->name('inventory.update_quantity');
		Route::get('inventory/deleted/{id}', [InventoryController::class, 'deleted'])->name('inventory.deleted');
		Route::get('inventory/display/{id}', [InventoryController::class, 'display'])->name('inventory.display');
	});
	


	Route::get('shopinventory', [ShopInventoryController::class, 'index'])->name('shopinventory');
	Route::get('shopinventory/getdata', [ShopInventoryController::class, 'getdata'])->name('shopinventory.getdata');
	Route::get('shopinventory/create', [ShopInventoryController::class, 'create'])->name('shopinventory.create');
	Route::post('shopinventory/store', [ShopInventoryController::class, 'store'])->name('shopinventory.store');
	Route::get('shopinventory/edit/{id}', [ShopInventoryController::class, 'edit'])->name('shopinventory.edit');
	Route::post('shopinventory/update/{id}', [ShopInventoryController::class, 'update'])->name('shopinventory.update');
	Route::post('shopinventory/update_quantity/{id}', [ShopInventoryController::class, 'update_quantity'])->name('shopinventory.update_quantity');
	Route::get('shopinventory/display/{id}', [ShopInventoryController::class, 'display'])->name('shopinventory.display');
});

