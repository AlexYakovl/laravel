<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\AdminController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register']);


Route::get('/cabinet', [CabinetController::class, 'index'])->name('cabinet');


Route::get('/admin', [AdminController::class, 'index'])->name('admin')->middleware('auth', 'can:admin');

Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');

    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
});

Route::get('/accounts/{id}', [AccountController::class, 'show'])->name('accounts.show');

use App\Http\Controllers\IncomeTransactionController;
use App\Http\Controllers\ExpenseTransactionController;

Route::post('/income_transactions', [IncomeTransactionController::class, 'store'])->name('income_transactions.store');
Route::get('/income_transactions/{id}/edit', [IncomeTransactionController::class, 'edit'])->name('income_transactions.edit');
Route::put('/income_transactions/{id}', [IncomeTransactionController::class, 'update'])->name('income_transactions.update');
Route::delete('/income_transactions/{id}', [IncomeTransactionController::class, 'destroy'])->name('income_transactions.destroy');

Route::post('/expense_transactions', [ExpenseTransactionController::class, 'store'])->name('expense_transactions.store');
Route::get('/expense_transactions/{id}/edit', [ExpenseTransactionController::class, 'edit'])->name('expense_transactions.edit');
Route::put('/expense_transactions/{id}', [ExpenseTransactionController::class, 'update'])->name('expense_transactions.update');
Route::delete('/expense_transactions/{id}', [ExpenseTransactionController::class, 'destroy'])->name('expense_transactions.destroy');


// Создание нового счёта
Route::post('/accounts/store', [AccountController::class, 'store'])->name('accounts.store');
// Удаление счёта
Route::delete('/accounts/{id}/destroy', [AccountController::class, 'destroy'])->name('accounts.destroy');
