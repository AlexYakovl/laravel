<?php

use App\Http\Controllers\Api\AccountApiController;
use App\Http\Controllers\Api\ExpenseTransactionApiController;
use App\Http\Controllers\Api\IncomeTransactionApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('accounts', AccountApiController::class);
Route::apiResource('income-transactions', IncomeTransactionApiController::class);
Route::apiResource('expense-transactions', ExpenseTransactionApiController::class);
