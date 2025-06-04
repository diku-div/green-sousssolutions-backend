<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrdersController;




// order routes
Route::post('/order', [OrdersController::class, 'store']);
Route::get('/tracking/{id}', [OrdersController::class, 'tracking']);
Route::post('/validate-order', [OrdersController::class, 'validateOrder']);
Route::get('/orders/status/{status}', [OrdersController::class, 'getOrdersByStatus']);
Route::get('/orders/{id}', [OrdersController::class, 'show']);
Route::put('/orders/{id}/status', [OrdersController::class, 'updateStatus']);
Route::get('/orders-per-month', [OrdersController::class, 'getOrdersPerMonth']);
Route::delete('/orders/{id}', [OrdersController::class, 'destroy']);
Route::post('/get-order-id', [OrdersController::class, 'getOrderId']);




// Admin Routes
Route::post('/login', [AdminController::class, 'login']);
Route::get('/admin/{id}', [AdminController::class, 'getAdmin']);
Route::put('/admin/profile/{id}', [AdminController::class, 'update']);
Route::put('/admin/password', [AdminController::class, 'changePassword']);
Route::post('/admin/profile/picture/{id}', [AdminController::class, 'updatePicture']);



