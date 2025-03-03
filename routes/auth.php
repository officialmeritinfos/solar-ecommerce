<?php

use Illuminate\Support\Facades\Route;

/*==================== LOGIN =========================================*/
Route::get('login')->uses('App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login/process')->uses('App\Http\Controllers\Auth\LoginController@login')->name('login.process');
/*==================== REGISTER ======================================*/
Route::get('register')->uses('App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register/process')->uses('App\Http\Controllers\Auth\RegisterController@register')->name('register.process');
/*===================== PASSWORD RECOVERY =============================*/
Route::get('account-recovery')->uses('App\Http\Controllers\Auth\LoginController@accountRecovery')->name('account-recovery');
