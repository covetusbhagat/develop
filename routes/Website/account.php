<?php

use App\Http\Controllers\Website\HomeController;


Route::get('/home', [HomeController::class, 'index'])->name('home');


//Route::get('/home', [HomeController::class, 'index'])->name('home');

