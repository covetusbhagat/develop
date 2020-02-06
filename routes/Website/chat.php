<?php

use App\Http\Controllers\Website\Chat\ChatController;


Route::group(['namespace' => 'Chat'], function () {

	Route::get('chat/{id}', [ChatController::class, 'index'])->name('chat');
	Route::post('chat/store', [ChatController::class, 'store'])->name('chat.store');

});