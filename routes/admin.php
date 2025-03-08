<?php


use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Settings\AccountSettingsController;
use App\Http\Controllers\Admin\Settings\GeneralSettingsController;
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
/*======================== SETTINGS ====================================*/
//General Settings
Route::controller(GeneralSettingsController::class)->group(function () {
    Route::get('settings/general','showGeneralSettings')->name('settings.general');
    Route::post('settings/general/update','updateGeneralSettings')->name('settings.general.update')->middleware('permission:update general settings');
    Route::post('settings/general/logo','uploadLogo')->name('settings.general.logo')->middleware('permission:update general settings');
});
//Account Settings
Route::controller(AccountSettingsController::class)->group(function () {
    Route::get('account/settings','showAccountSettingsForm')->name('account.settings');
    Route::post('account/settings/update','updateAccountSettings')->name('account.settings.update');
    //Account Security
    Route::get('account/settings/security','showAccountSecurityPage')->name('account.settings.security');
    Route::post('account/settings/security/set-up-otp','completeTwoFactorAuthenticationSetup')->name('account.settings.security.set-up-otp');
    Route::post('account/settings/password/update','updatePassword')->name('account.settings.password.update');
    //Get recovery code of logged-in admin
    Route::post('account/settings/security/recovery-code','getRecoveryCode')->name('account.settings.security.recovery-code');
    //Profile
    Route::get('account/profile','showProfile')->name('account.profile');
});
