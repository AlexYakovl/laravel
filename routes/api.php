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
Route::get('/accounts/{id}/transactions', [AccountApiController::class, 'transactions']);
Route::get('/accounts/{id}/transactions_total', [AccountApiController::class, 'transactions_total']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/accounts', [AccountApiController::class, 'index']);
    Route::post('/accounts', [AccountApiController::class, 'store']);
    Route::get('/accounts/{id}', [AccountApiController::class, 'show']);
    Route::put('/accounts/{id}', [AccountApiController::class, 'update']);
    Route::delete('/accounts/{id}', [AccountApiController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/income', [IncomeTransactionApiController::class, 'store'])
        ->middleware('can:create-transaction');

    Route::post('/expense', [ExpenseTransactionApiController::class, 'store'])
        ->middleware('can:create-transaction');

});


