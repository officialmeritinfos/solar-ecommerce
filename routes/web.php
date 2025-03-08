<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::prefix('legal')->group(function (){
    Route::get('terms-and-conditions')->name('legal.terms-and-conditions');
    Route::get('privacy-policy')->name('legal.privacy-policy');
});


// Route for disabling 2FA
Route::get('/disable-2fa/{user}', function (Request $request, $userId) {
    if (!$request->hasValidSignature()) {
        abort(403, 'Unauthorized or expired link.');
    }
    $user = \App\Models\User::findOrFail($userId);

    $user->two_factor = false;
    $user->google2fa_secret = null;

    $user->save();
    return redirect()->route('login')->with('success', 'Two-Factor Authentication has been disabled.');
})->name('2fa.disable');
