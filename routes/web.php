<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/product/{id}', [ProductController::class, 'index']);
Route::get('/product/create', [ProductController::class, 'create'])->name("product-create");
Route::post('/product', [ProductController::class, 'store'])->name("product-store");


Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier-create');
Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier-store');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
