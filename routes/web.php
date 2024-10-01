<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
// Rute Dasar
Route::get('/hello', function () {
    return 'Hello, World!';
});

// Rute dengan parameter
Route::get('/user/{id}', function ($id) {
    return "User ID: " . $id;
});

// Rute dengan parameter opsional
Route::get('/user/{name?}', function ($name = 'Guest') {
    return "Hello, " . $name;
});

// Rute dengan nama (rute penamaan)
Route::get('/profile', function () {
    return 'This is the profile page.';
})->name('profile');

// Menggunakan rute bernama untuk pengalihan 
Route::get('/redirect-to-profile', function () {
    return redirect()->route('profile');
});

// Route groups
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return 'Admin Dashboard';
    });
    Route::get('/profile', function () {
        return 'Admin Profile';
    });
});

// Rute dengan middleware
Route::get('/dashboard', function () {
    return 'Welcome to your dashboard!';
})->middleware('auth');

// Resource route (rute suber daya)
Route::resource('posts', 'PostController');

