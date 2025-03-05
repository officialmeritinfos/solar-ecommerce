<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordRecoveryController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TwoFactorController;
use Illuminate\Support\Facades\Route;

/*==================== LOGIN CONTROLLER=========================================*/
Route::controller(LoginController::class)->group(function () {
    Route::get('login','showLoginForm')->name('login');
    Route::post('login/process','login')->name('login.process')->middleware('throttle:authentication');
    //Logout
    Route::get('logout','logout')->name('logout')->middleware(['web', 'auth'])->name('logout');
});
/*==================== TWO-FACTOR CONTROLLER=========================================*/
Route::controller(TwoFactorController::class)->group(function () {
    Route::get('two-factor','showTwoFactorForm')->name('two-factor');
    Route::post('two-factor/process','processTwoFactor')->name('two-factor.process')->middleware('throttle:authentication');
    //Recover authenticator
    Route::get('two-factor/reset','show2FactorResetCode')->name('2fa.reset');
    Route::post('two-factor/reset/process','processTwoFactorReset')->name('2fa.reset.process')->middleware('throttle:authentication');
});
/*==================== REGISTER CONTROLLER======================================*/
Route::controller(RegisterController::class)->group(function () {
    Route::get('register','showRegistrationForm')->name('register');
    Route::post('register/process','register')->name('register.process')->middleware('throttle:authentication');
    //Email verification
    Route::get('email/verify-notice','showVerificationNotice')->name('verification.notice');
    Route::post('email/resend','resend')->name('verification.resend')->middleware('throttle:authentication');
    Route::get('email/verify/{id}/{hash}', 'verify')->middleware(['signed'])->name('verification.verify');
});
/*===================== PASSWORD RECOVERY CONTROLLER =============================*/
Route::controller(PasswordRecoveryController::class)->group(function () {
    Route::get('account-recovery','showPasswordRecoveryForm')->name('account-recovery');
    Route::post('account-recovery/process','processPasswordRecoveryRequest')->name('account-recovery.process');
    //Recovery Notice
    Route::get('account-recovery/reset-notice','showPasswordRecoveryNotice')->name('account-recovery.reset-notice');
    Route::post('account-recovery/resend','resendPasswordVerification')->name('account-recovery.resend')->middleware('throttle:authentication');
    //Password Reset
    Route::get('account-recovery/reset-password','showPasswordResetForm')->name('password.reset');
    Route::post('account-recovery/reset-password/process','resetPassword')->name('password.reset.process');
});
