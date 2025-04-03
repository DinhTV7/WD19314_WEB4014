<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/showLogin',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',       [AuthController::class, 'login'])->name('login-post');
Route::get('/showRegister', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',    [AuthController::class, 'register'])->name('register-post');
Route::post('/logout',      [AuthController::class, 'logout'])->name('logout');

// Nhóm đường dẫn
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Các đường dẫn trong admin sẽ đặt trong đây
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Route quản lý sản phẩm
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/',                [ProductController::class, 'index'])->name('index');
        Route::get('/{id}/show',       [ProductController::class, 'show'])->name('show');
        Route::get('/create',          [ProductController::class, 'create'])->name('create');
        Route::post('/store',          [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit',       [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}/update',     [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [ProductController::class, 'destroy'])->name('destroy');
    });
});
