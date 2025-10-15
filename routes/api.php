<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;

Route::post('/register', [UserController::class, 'register']);

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);
Route::middleware('jwt')->group(function () {
    Route::post('/add-product', [ProductController::class, 'store']);
    Route::get('/all-products', [ProductController::class, 'allProducts']);
    //one Product
    Route::get('/product/{id}', [ProductController::class, 'oneProduct']);
    //update product
    Route::put('/update-product/{id}', [ProductController::class, 'updateProduct']);

    //cart
    // add to cart
    Route::post('/add-to-cart', [CartController::class, 'store']); //if not exist it add to
    // card it exist it increase its quantity
    //view cart
    Route::get('/view-cart', [CartController::class, 'viewCart']);
    //remove from cart
    Route::delete('/remove-from-cart/{id}', [CartController::class, 'deleteCartItem']);
    //create Order
    Route::post('/add-order', [OrderController::class, 'store']);
    Route::get('/view-order', [OrderController::class, 'viewOrder']);
    Route::post('/payment', [PaymentController::class, 'processPayment']);
});
