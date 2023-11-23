<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
Route::get('/Home/{slug?}', [App\Http\Controllers\Frontend\HomeController::class, 'showProduct'])->name('home.product');
Route::get('/shop/{slug?}', [App\Http\Controllers\Frontend\ShopController::class, 'index'])->name('products.index');
Route::get('/product/{product:slug}', [\App\Http\Controllers\Frontend\ProductController::class, 'show'])->name('products.show');
Route::get('/product/quick-view/{product:slug}', [\App\Http\Controllers\Frontend\ProductController::class, 'quickView']);

Route::get('wishlists', function () {
    return view('frontend.wishlists.index');
})->name('wishlists.index');

// Route::get('products', function () {
//     return view('frontend.products.index');
// })->name('products.index');

// Route::get('products/detail', function () {
//     return view('frontend.products.detail');
// })->name('products.detail');

Route::get('carts', function () {
    return view('frontend.carts.index');
})->name('carts.index');

Route::get('carts/checkout', function () {
    return view('frontend.carts.checkout');
})->name('carts.checkout');

Route::get('about', function () {
    return view('frontend.other.about');
})->name('about');

Route::get('contact', function () {
    return view('frontend.other.contact');
})->name('contact');

Route::get('blogs', function () {
    return view('frontend.blogs.index');
})->name('blogs.index');

Route::get('blogs/detail', function () {
    return view('frontend.blogs.detail');
})->name('blogs.detail');







Auth::routes();

//login by google account
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('login-by-google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::group(['middleware' => 'auth'], function () {
    //The Email Verification Notice
    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->name('verification.notice');
    //The Email Verification Handler
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/');
    })->middleware('signed')->name('verification.verify');
    //Resending The Verification Email
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('resent', 'done');
    })->middleware('throttle:6,1')->name('verification.resend');
});

Route::group(['middleware' => ['auth', 'isAdmin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    // admin
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::post('products/images', [\App\Http\Controllers\Admin\ProductController::class, 'storeImage'])->name('products.storeImage');
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');

    Route::resource('slides', \App\Http\Controllers\Admin\SlideController::class);
    Route::get('slides/{slideId}/up', [\App\Http\Controllers\Admin\SlideController::class, 'moveUp']);
    Route::get('slides/{slideId}/down', [\App\Http\Controllers\Admin\SlideController::class, 'moveDown']);
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    //user
    Route::get('profile', [\App\Http\Controllers\Auth\ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [\App\Http\Controllers\Auth\ProfileController::class, 'update'])->name('profile.update');
    Route::get('passwords/change', [\App\Http\Controllers\Auth\ProfileController::class, 'show'])->name('passwords.index');
    Route::put('passwords/change', [\App\Http\Controllers\Auth\ProfileController::class, 'change'])->name('passwords.change');
    Route::post('get-cities', [\App\Http\Controllers\frontend\OrderController::class, 'cities']);
});
