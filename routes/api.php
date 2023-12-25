<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// controller
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RentalSpaceController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Customer
Route::post('/register-customer', [AuthController::class, 'registerCustomer']);
Route::post('/login-customer', [AuthController::class, 'loginCustomer']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout-customer', [AuthController::class, 'logoutCustomer']);
});

// Employee
Route::post('/register-employee', [AuthController::class, 'registerEmployee']);
Route::post('/login-employee', [AuthController::class, 'loginEmployee']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout-employee', [AuthController::class, 'logoutEmployee']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/add-rental-spaces', [RentalSpaceController::class, 'addRentalSpaces']);
});

