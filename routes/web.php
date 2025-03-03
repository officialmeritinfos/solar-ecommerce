<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::prefix('legal')->group(function (){
    Route::get('terms-and-conditions')->name('legal.terms-and-conditions');
    Route::get('privacy-policy')->name('legal.privacy-policy');
});
