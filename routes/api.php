<?php

use App\Models\VendorLedger;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\VendorController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\SupplierController;
use App\Http\Controllers\Api\V1\VendorBillController;
use App\Http\Controllers\Api\V1\DailyExpenseController;
use App\Http\Controllers\Api\V1\EmployeeController;
use App\Http\Controllers\Api\V1\FundsTransferController;
use App\Http\Controllers\Api\V1\HelperController;
use App\Http\Controllers\Api\V1\OfficeController;
use App\Http\Controllers\Api\V1\PaymentRecievedController;

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


        // daily Expense Route
        Route::apiResource('payments', DailyExpenseController::class);

        // supplier 
        Route::apiResource('supplier', SupplierController::class);

        // customer
        Route::apiResource('customer', CustomerController::class);

        // vendor list
        Route::apiResource('vendor', VendorController::class);

        // vendor Bill 
        Route::apiResource('vendorbill', VendorBillController::class);


        // paymentRecieve
        Route::apiResource('payment/recieve', PaymentRecievedController::class);

        // helper
        Route::apiResource('helper', HelperController::class);

        // office
        Route::apiResource('office', OfficeController::class);

        // fundTransfer
        Route::apiResource('fund/transfer', FundsTransferController::class);

        // employee
        Route::apiResource('employee', EmployeeController::class);


    });
});
