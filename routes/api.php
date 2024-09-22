<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FoodWasteEntryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth routes
Route::post('/register/admin', [AuthController::class, 'registerAdmin']);
Route::post('/register/hospital-owner', [AuthController::class, 'registerHospitalOwner']);
Route::post('/register/employee', [AuthController::class, 'registerEmployee']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/me', [AuthController::class, 'me']);

// Protected routes (JWT required)
Route::middleware('auth:api')->group(function () {
    // Route::post('/logout', [AuthController::class, 'logout']);
    // Route::get('/me', [AuthController::class, 'me']);
    
    // Employee routes (for authenticated users)
    Route::prefix('employees')->group(function () {
        Route::get('/', [EmployeeController::class, 'index']);
        Route::post('/', [EmployeeController::class, 'store']);
        Route::get('/{id}', [EmployeeController::class, 'show']);
        Route::put('/{id}', [EmployeeController::class, 'update']);
        Route::delete('/{id}', [EmployeeController::class, 'destroy']);
    });

    Route::prefix('food-waste-entries')->group(function () {
        Route::get('/', [FoodWasteEntryController::class, 'index']);
        Route::post('/', [FoodWasteEntryController::class, 'store']);
        Route::get('/{id}', [FoodWasteEntryController::class, 'show']);
        Route::put('/{id}', [FoodWasteEntryController::class, 'update']);
        Route::delete('/{id}', [FoodWasteEntryController::class, 'destroy']);
    });

    
    
});

// Admin and Hospital routes (for admins and hospital owners)
Route::middleware(['auth:api', 'admin'])->group(function () {
    
    // Hospital routes
    Route::prefix('hospitals')->group(function () {
        Route::get('/', [HospitalController::class, 'index']);
        Route::post('/', [HospitalController::class, 'store']);
        Route::get('/{id}', [HospitalController::class, 'show']);
        Route::put('/{id}', [HospitalController::class, 'update']);
        Route::delete('/{id}', [HospitalController::class, 'destroy']);
    });

    
    // Route::prefix('categories')->group(function () {
    //     Route::get('/', [CategoryController::class, 'index']);
    //     Route::post('/', [CategoryController::class, 'store']);
    //     Route::get('/{id}', [CategoryController::class, 'show']);
    //     Route::put('/{id}', [CategoryController::class, 'update']);
    //     Route::delete('/{id}', [CategoryController::class, 'destroy']);
    // });
Route::get('/categories', [CategoryController::class, 'index']);      // Get all categories
Route::post('/categories', [CategoryController::class, 'store']);     // Create new category
Route::get('/categories/{id}', [CategoryController::class, 'show']);  // Get a specific category
Route::put('/categories/{id}', [CategoryController::class, 'update']); // Update a category
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']); 

    // Item routes
    Route::prefix('items')->group(function () {
        Route::get('/', [ItemController::class, 'index']);
        Route::post('/', [ItemController::class, 'store']);
        Route::get('/{id}', [ItemController::class, 'show']);
        Route::put('/{id}', [ItemController::class, 'update']);
        Route::delete('/{id}', [ItemController::class, 'destroy']);
    });
});
