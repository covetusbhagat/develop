<?php

use App\Http\Controllers\Website\Order\OrderController;
use App\Http\Controllers\Website\Order\ShoporderController;


Route::group(['namespace' => 'Order'], function () {

	Route::get('order', [OrderController::class, 'index'])->name('order');
	Route::get('order/getData', [OrderController::class, 'getData'])->name('order.getData');
	Route::get('order/deleted/{id}', [OrderController::class, 'deleted'])->name('order.deleted');
	Route::get('order/display/{id}', [OrderController::class, 'display'])->name('order.display');


	Route::get('shoporder', [ShoporderController::class, 'index'])->name('shoporder');
	Route::get('shoporder/getData', [ShoporderController::class, 'getData'])->name('shoporder.getData');
	Route::get('shoporder/display/{id}', [ShoporderController::class, 'display'])->name('shoporder.display');
	Route::get('shoporder/start/{id}', [ShoporderController::class, 'start'])->name('shoporder.start');
	Route::post('shoporder/delivery_process/{id}', [ShoporderController::class, 'delivery_process'])->name('shoporder.delivery_process');

});