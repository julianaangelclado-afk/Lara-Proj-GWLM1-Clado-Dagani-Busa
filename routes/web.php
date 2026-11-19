<?php

use Illuminate\Support\Facades\Route;

/* Member 1: Home */
Route::get('/', function () {
    return view('home', [
        'studios'     => config('bandit.studios'),
        'instruments' => config('bandit.instruments'),
        'categories'  => config('bandit.categories'),
    ]);
})->name('home');

/* Member 2: About */
Route::get('/about', function () {
    return view('about');
})->name('about');

/* Member 3: Contact (message + booking tabs) */
Route::get('/contact', function () {
    return view('contact', [
        'studios'     => config('bandit.studios'),
        'instruments' => config('bandit.instruments'),
        'categories'  => config('bandit.categories'),
    ]);
})->name('contact');
