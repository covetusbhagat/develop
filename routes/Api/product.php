<?php

use App\Http\Controllers\Api\ProductController;


//Route::get('featured_product_list', [ProductController::class, 'featured_product_list'])->name('featured_product_list');

Route::post('wishlist_list', [ProductController::class, 'wishlist_list'])->name('wishlist_list');
Route::post('add_and_remove_wishlist', [ProductController::class, 'add_and_remove_wishlist'])->name('add_and_remove_wishlist');	

Route::post('cart_list', [ProductController::class, 'cart_list'])->name('cart_list');
Route::post('add_and_remove_cart', [ProductController::class, 'add_and_remove_cart'])->name('add_and_remove_cart');

Route::post('add_product_review', [ProductController::class, 'add_product_review'])->name('add_product_review');

Route::post('add_complaint', [ProductController::class, 'add_complaint'])->name('add_complaint');

Route::post('change_complaint_status', [ProductController::class, 'change_complaint_status'])->name('change_complaint_status');

Route::get('complaint_list', [ProductController::class, 'complaint_list'])->name('complaint_list');

Route::post('add_chat_message', [ProductController::class, 'add_chat_message'])->name('add_chat_message');

Route::get('chat_message_list', [ProductController::class, 'chat_message_list'])->name('chat_message_list');

Route::post('product_shopkeeper_list', [ProductController::class, 'product_shopkeeper_list'])->name('product_shopkeeper_list');

Route::post('coupan_apply_on_order', [ProductController::class, 'coupan_apply_on_order'])->name('coupan_apply_on_order');

Route::post('add_order', [ProductController::class, 'add_order'])->name('add_order');

Route::post('update_order_status', [ProductController::class, 'update_order_status'])->name('update_order_status');




 

/*Route::post('update_profile', [AuthController::class, 'update_profile'])->name('update_profile');
Route::put('change_password', [AuthController::class, 'change_password'])->name('change_password');*/