<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\OrderController; // <-- Added this
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// --- PUBLIC ROUTES ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);

// Repair Public Access
Route::get('/repairs', [RepairController::class, 'index']);
Route::post('/repairs', [RepairController::class, 'store']);
Route::get('/repairs/track/{code}', [RepairController::class, 'track']);

// Order Public Access (Checkout)
Route::post('/orders', [OrderController::class, 'store']); // <-- Users place orders here

// --- PROTECTED ROUTES ---
Route::group(['middleware' => ['auth:sanctum']], function () {
    // Auth & Identity
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']); // Recommended to add
    
    Route::get('/users', function () {
        return \App\Models\User::all();
    });

    // Product Management
    Route::post('/products', [ProductController::class, 'store']);
    // Route::put('/products/{id}', [ProductController::class, 'update']); // If you add editing later
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    
    // Repair Management
    Route::patch('/repairs/{id}/status', [RepairController::class, 'updateStatus']);
    Route::delete('/repairs/{id}', [RepairController::class, 'destroy']);

    // Order Management (Admin Only)
    Route::get('/orders', [OrderController::class, 'index']); // <-- Fetch all orders
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus']); // <-- Change status
    Route::delete('/orders/{id}', [OrderController::class, 'destroy']); // <-- Archive/Delete
});