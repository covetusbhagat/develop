<?php

use App\Http\Controllers\Website\Notification\NotificationController;


Route::group(['namespace' => 'Notification'], function () {

	Route::get('notification', [NotificationController::class, 'index'])->name('notification');
	Route::get('notification/getData', [NotificationController::class, 'getData'])->name('notification.getData');

});