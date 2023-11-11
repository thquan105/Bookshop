<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('frontend.home');
})->name('home');

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

Route::get('about', function () {
    return view('frontend.other.about');
})->name('about');

Route::get('contact', function () {
    return view('frontend.other.contact');
})->name('contact');

