<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {
    //Landing page
    Route::get('/', 'index')->name('home');
    Route::get('home/about-us', 'aboutPage')->name('home.about');
    Route::get('home/solutions', 'solutions')->name('home.solutions');
    Route::get('home/solutions/{id}/details', 'solutionDetail')->name('home.solutions.details');
    Route::get('home/faqs','faqs')->name('home.faqs');
    Route::get('home/contact-us', 'contactUs')->name('home.contact');
    Route::post('home/contact-us/submit','processFormSubmission')->name('home.contact.submit');
});
//Shop controller
Route::controller(ShopController::class)->group(function () {
    Route::get('shop', 'index')->name('shop');
    Route::get('shop/collections/{slug}', 'categoryProducts')->name('shop.category.products');
    Route::get('shop/products/{slug}/{id}','productDetail')->name('shop.products.details');
});
//Cart Controller
Route::controller(\App\Http\Controllers\CartController::class)->group(function () {
    Route::get('cart', 'index')->name('cart.index');
    //Add to cart
    Route::post('cart/add', 'index')->name('cart.add');
});


Route::controller(LegalController::class)->prefix('legal')->group(function (){
    Route::get('terms-and-conditions','terms')->name('legal.terms-and-conditions');
    Route::get('privacy-policy','privacy')->name('legal.privacy-policy');
    Route::get('refund-policy','refund')->name('legal.refund-policy');
    Route::get('shipping-policy','shipping')->name('legal.shipping-policy');
    Route::get('field-support-engineer-terms','engineerTerms')->name('legal.engineer-terms');
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
