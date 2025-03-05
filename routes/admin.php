<?php


use App\Http\Controllers\Admin\Dashboard;
use \Illuminate\Support\Facades\Route;

/*=========================== ADMIN DASHBOARD ===============================*/
Route::controller(Dashboard::class)->group(function () {
    Route::get('dashboard','landingPage')->name('dashboard');
});
