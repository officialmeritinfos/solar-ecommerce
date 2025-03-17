<?php


use App\Http\Controllers\Admin\AffiliatesController;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\OrderManagement\OrderController;
use App\Http\Controllers\Admin\ProductManagement\CategoryController;
use App\Http\Controllers\Admin\ProductManagement\ProductController;
use App\Http\Controllers\Admin\Settings\AccountSettingsController;
use App\Http\Controllers\Admin\Settings\DeliverySettingsController;
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
//Delivery Locations
Route::controller(DeliverySettingsController::class)->group(function () {
    Route::get('delivery/settings','showLocation')->name('delivery.settings');
    Route::get('delivery/settings/{id}/locations','showSubLocation')->name('delivery.settings.subLocations');
});

/*======================== AFFILIATES ====================================*/
Route::controller(AffiliatesController::class)->group(function () {
    Route::get('affiliates/show','showAffiliates')->name('affiliate.show');

    //Affiliate Details
    Route::get('affiliates/{id}/detail','affiliatesDetails')->name('affiliates.detail');

    //Earnings
    Route::get('affiliates/earnings','affiliateEarnings')->name('affiliate.earnings');
    Route::get('affiliates/earnings/{id}/detail','showAffiliateEarningDetails')->name('affiliates.earnings.detail');

    //Payouts
    Route::get('affiliates/payouts','affiliatesPayouts')->name('affiliate.payouts');
    Route::get('affiliates/payouts/{id}/detail','showAffiliatePayoutRequestDetails')->name('affiliates.payouts.detail');
});

/*======================== PRODUCT MANAGEMENT ====================================*/
Route::controller(ProductController::class)->group(function () {
    Route::get('products/list','showProductList')->name('products.list');

    //New product
    Route::get('product/create','showNewProductPage')->name('product.create');
    Route::post('product/create/process','createProduct')->name('product.create.process');

    //Edit product
    Route::get('product/{id}/edit')->name('product.edit');

    //Product Details
    Route::get('product/{id}/details','productDetails')->name('product.details');
});

/*======================== PRODUCT CATEGORY MANAGEMENT ====================================*/
Route::controller(CategoryController::class)->group(function () {
    Route::post('category/create/process','addCategory')->name('category.create.process');
});

/*======================== ORDER MANAGEMENT ====================================*/
Route::controller(OrderController::class)->group(function () {
    Route::post('order/index','addCategory')->name('order.index');
    Route::post('order/{id}/detail','addCategory')->name('order.detail');
});
