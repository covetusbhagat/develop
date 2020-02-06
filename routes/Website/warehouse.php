<?php

use App\Http\Controllers\Website\Warehouse\WarehouseController;


Route::group(['namespace' => 'Warehouse'], function () {

	Route::get('warehouse', [WarehouseController::class, 'index'])->name('warehouse');
	Route::get('warehouse/getData', [WarehouseController::class, 'getData'])->name('warehouse.getData');
	Route::get('warehouse/create', [WarehouseController::class, 'create'])->name('warehouse.create');
	Route::post('warehouse/store', [WarehouseController::class, 'store'])->name('warehouse.store');
	Route::get('warehouse/edit/{id}', [WarehouseController::class, 'edit'])->name('warehouse.edit');
	Route::post('warehouse/update/{id}', [WarehouseController::class, 'update'])->name('warehouse.update');
	Route::get('warehouse/deleted/{id}', [WarehouseController::class, 'deleted'])->name('warehouse.deleted');

});