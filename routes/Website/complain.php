<?php

use App\Http\Controllers\Website\Complain\ComplainController;


Route::group(['namespace' => 'Complain'], function () {

	Route::get('complain', [ComplainController::class, 'index'])->name('complain');
	Route::get('complain/getData', [ComplainController::class, 'getData'])->name('complain.getData');
	Route::get('complain/edit/{id}', [ComplainController::class, 'edit'])->name('complain.edit');
	Route::post('complain/update/{id}', [ComplainController::class, 'update'])->name('complain.update');
	Route::get('complain/deleted/{id}', [ComplainController::class, 'deleted'])->name('complain.deleted');
	Route::get('complain/display/{id}', [ComplainController::class, 'display'])->name('complain.display');

});