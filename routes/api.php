<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FoodWasteEntryController;


// Hospital Routes
Route::get('hospitals', [HospitalController::class, 'index']);
Route::post('hospitals', [HospitalController::class, 'store']);
Route::get('hospitals/{id}', [HospitalController::class, 'show']);
Route::put('hospitals/{id}', [HospitalController::class, 'update']);
Route::delete('hospitals/{id}', [HospitalController::class, 'destroy']);

// Employee Routes
Route::get('employees', [EmployeeController::class, 'index']);
Route::post('employees', [EmployeeController::class, 'store']);
Route::get('employees/{id}', [EmployeeController::class, 'show']);
Route::put('employees/{id}', [EmployeeController::class, 'update']);
Route::delete('employees/{id}', [EmployeeController::class, 'destroy']);

// Waste Food Routes
Route::get('waste-food', [WasteFoodController::class, 'index']);
Route::post('waste-food', [WasteFoodController::class, 'store']);
Route::get('waste-food/{id}', [WasteFoodController::class, 'show']);
Route::put('waste-food/{id}', [WasteFoodController::class, 'update']);
Route::delete('waste-food/{id}', [WasteFoodController::class, 'destroy']);
