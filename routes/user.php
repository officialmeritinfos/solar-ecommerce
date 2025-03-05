<?php

use App\Http\Controllers\User\Dashboard;
use \Illuminate\Support\Facades\Route;

/*=========================== USER DASHBOARD ===============================*/
Route::controller(Dashboard::class)->group(function () {
    Route::get('dashboard','landingPage')->name('dashboard');
});
