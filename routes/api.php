<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;

Route::post('/login', [AuthController::class, 'login']);

// Mặc định apiResource sẽ trỏ tới 5 hàm mặc định trong controller api
// Nếu muốn tạo ra các phương thức mới trong controller api
// thì ta phải tạo thêm các route khác để trỏ riêng tới phương thức đó
// Route tạo thêm phải đặt ở bên trên apiResource
Route::apiResource('products', ProductController::class)->middleware('auth:sanctum');