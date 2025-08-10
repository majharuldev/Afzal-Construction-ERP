<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController;


Route::prefix('v1')->group(function () {

    // Public Routes (No auth needed)
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Protected Routes (Need Sanctum auth)
    Route::middleware('auth:sanctum')->group(function () {

        // User info & logout
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/logout', [AuthController::class, 'logout']);


        Route::apiResource('payments', DailyExpenseController::class);
    });
});
