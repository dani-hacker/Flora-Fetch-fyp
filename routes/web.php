<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPlantController;
use App\Http\Controllers\AdminOrderController;
use Illuminate\Support\Facades\Route;

// ── PUBLIC ROUTES ─────────────────────────────────────────────────────────────

Route::get('/', [PlantController::class, 'index'])->name('plants.index');
Route::get('/plants/{plant}', [PlantController::class, 'show'])->name('plants.show');

// Auth
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── CUSTOMER ROUTES (must be authenticated) ───────────────────────────────────

Route::middleware('auth')->group(function () {

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{plant}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{plantId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{plantId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    // Order history
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// ── ADMIN ROUTES ──────────────────────────────────────────────────────────────

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Plant CRUD
        Route::resource('plants', AdminPlantController::class);

        // Order management
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    });
