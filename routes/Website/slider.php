<?php

use App\Http\Controllers\Website\Slider\SliderController;


Route::group(['namespace' => 'Slider'], function () {

	Route::get('slider', [SliderController::class, 'index'])->name('slider');
	Route::get('slider/getData', [SliderController::class, 'getData'])->name('slider.getData');
	Route::get('slider/create', [SliderController::class, 'create'])->name('slider.create');
	Route::post('slider/store', [SliderController::class, 'store'])->name('slider.store');
	Route::get('slider/edit/{id}', [SliderController::class, 'edit'])->name('slider.edit');
	Route::post('slider/update/{id}', [SliderController::class, 'update'])->name('slider.update');
	Route::get('slider/deleted/{id}', [SliderController::class, 'deleted'])->name('slider.deleted');

});