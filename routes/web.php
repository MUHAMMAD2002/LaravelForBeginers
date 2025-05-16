<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');
Route::view('about-us', 'about')->name('about');
Route::view('contact', 'contact')->name('contact');

// Route::view('/second', 'second');
