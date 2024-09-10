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


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (JWT required)
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});


Route::middleware(['auth:api', 'admin'])->group(function () {
    Route::get('/hospitals', [HospitalController::class, 'index']);
    Route::post('/hospitals', [HospitalController::class, 'store']);
    Route::get('/hospitals/{id}', [HospitalController::class, 'show']);
    Route::put('/hospitals/{id}', [HospitalController::class, 'update']);
    Route::delete('/hospitals/{id}', [HospitalController::class, 'destroy']);
    Route::get('/food-waste-entries', [FoodWasteEntryController::class, 'index']);       // Get all food waste entries
    Route::post('/food-waste-entries', [FoodWasteEntryController::class, 'store']);      // Create a new food waste entry
    Route::get('/food-waste-entries/{id}', [FoodWasteEntryController::class, 'show']);   // Get a single food waste entry
    Route::put('/food-waste-entries/{id}', [FoodWasteEntryController::class, 'update']); // Update a food waste entry
    Route::delete('/food-waste-entries/{id}', [FoodWasteEntryController::class, 'destroy']); // Delete a food waste entry
});

// Protected routes for Employee CRUD, only accessible to authenticated users (admins and hospital owners)
Route::middleware(['auth:api'])->group(function () {
    // List all employees for a hospital (if hospital owner) or all employees (if admin)
    Route::get('/employees', [EmployeeController::class, 'index']);

    // Create a new employee
    Route::post('/employees', [EmployeeController::class, 'store']);

    // Get a single employee
    Route::get('/employees/{id}', [EmployeeController::class, 'show']);

    // Update an employee
    Route::put('/employees/{id}', [EmployeeController::class, 'update']);

    // Delete an employee
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);
});

Route::middleware(['auth:api', 'admin'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);       // Get all categories
    Route::post('/categories', [CategoryController::class, 'store']);      // Create a new category
    Route::get('/categories/{id}', [CategoryController::class, 'show']);   // Get a single category
    Route::put('/categories/{id}', [CategoryController::class, 'update']); // Update a category
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']); // Delete a category
});

Route::middleware(['auth:api','admin'])->group(function () {
    Route::get('/items', [ItemController::class, 'index']);       // Get all items
    Route::post('/items', [ItemController::class, 'store']);      // Create a new item
    Route::get('/items/{id}', [ItemController::class, 'show']);   // Get a single item
    Route::put('/items/{id}', [ItemController::class, 'update']); // Update an item
    Route::delete('/items/{id}', [ItemController::class, 'destroy']); // Delete an item
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
