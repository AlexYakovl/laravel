<?php

use App\Http\Controllers\Api\AccountApiController;
use App\Http\Controllers\Api\ExpenseTransactionApiController;
use App\Http\Controllers\Api\IncomeTransactionApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/accounts_close', [AccountApiController::class, 'index']);
    Route::get('/me', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::apiResource('accounts', AccountApiController::class);
Route::apiResource('income-transactions', IncomeTransactionApiController::class);
Route::apiResource('expense-transactions', ExpenseTransactionApiController::class);
