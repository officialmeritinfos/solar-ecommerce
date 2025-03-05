<?php


use App\Http\Controllers\Affiliate\Dashboard;
use \Illuminate\Support\Facades\Route;

/*=========================== AFFILIATE DASHBOARD ===============================*/
Route::controller(Dashboard::class)->group(function () {
    Route::get('dashboard','landingPage')->name('dashboard');
});
