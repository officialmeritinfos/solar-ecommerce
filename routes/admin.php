<?php


use App\Http\Controllers\Admin\Dashboard;
use \Illuminate\Support\Facades\Route;

/*=========================== ADMIN DASHBOARD ===============================*/
Route::controller(Dashboard::class)->group(function () {
    Route::get('dashboard','landingPage')->name('dashboard');
});

/*======================== STAFF MANAGEMENT ====================================*/
Route::controller(\App\Http\Controllers\Admin\StaffController::class)->group(function () {
    Route::get('staff/list','showStaffLists')->name('staff');
    Route::get('staff/roles-permissions','showRolesAndPermissions')->name('staff.roles-permissions');
    Route::get('staff/activity-logs','showActivityLogs')->name('staff.activity-logs')->middleware('permission:view staff activity logs');
});
