<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('wishlists', function () {
    return view('frontend.wishlists.index');
})->name('wishlists.index');

Route::get('products', function () {
    return view('frontend.products.index');
})->name('products.index');

Route::get('products/detail', function () {
    return view('frontend.products.detail');
})->name('products.detail');

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


Route::get('profile', function () {
    return view('auth.profile');
})->name('profile');

Route::get('passwords/change', function () {
    return view('auth.passwords.change');
})->name('passwords.change');


Auth::routes();

Route::group(['middleware' => ['auth', 'isAdmin'], 'prefix' => 'admin', 'as' => 'admin.'], function() {
    // admin
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
});