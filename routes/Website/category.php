<?php

use App\Http\Controllers\Website\Category\CategoryController;
use App\Http\Controllers\Website\Category\SubcategoryController;


Route::group(['namespace' => 'Category'], function () {

	Route::get('category', [CategoryController::class, 'index'])->name('category');
	Route::get('category/getData', [CategoryController::class, 'getData'])->name('category.getData');
	Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
	Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
	Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
	Route::post('category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
	Route::get('category/deleted/{id}', [CategoryController::class, 'deleted'])->name('category.deleted');
	Route::get('category/display/{id}', [CategoryController::class, 'display'])->name('category.display');


	Route::get('subcategory', [SubcategoryController::class, 'index'])->name('subcategory');
	Route::get('subcategory/getData', [SubcategoryController::class, 'getData'])->name('subcategory.getData');
	Route::get('subcategory/create', [SubcategoryController::class, 'create'])->name('subcategory.create');
	Route::post('subcategory/store', [SubcategoryController::class, 'store'])->name('subcategory.store');
	Route::get('subcategory/edit/{id}', [SubcategoryController::class, 'edit'])->name('subcategory.edit');
	Route::post('subcategory/update/{id}', [SubcategoryController::class, 'update'])->name('subcategory.update');
	Route::get('subcategory/deleted/{id}', [SubcategoryController::class, 'deleted'])->name('subcategory.deleted');
	Route::get('subcategory/display/{id}', [SubcategoryController::class, 'display'])->name('subcategory.display');

});