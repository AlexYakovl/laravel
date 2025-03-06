<?php

namespace App\Http\Controllers;

use App\Models\Account;


class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        return view('accounts.index', compact('accounts'));
    }

    public function show($id)
    {
        $account = Account::with(['incomeTransactions', 'expenseTransactions'])->findOrFail($id);
        return view('accounts.show', compact('account'));
    }
}

