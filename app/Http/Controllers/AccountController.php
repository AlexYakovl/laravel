<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        return view('accounts.index', compact('accounts'));
    }

    public function show($id, Request $request)
    {
        $account = Account::findOrFail($id);

        $perPage = $request->input('per_page', 5); // по умолчанию 5, но можно менять

        $incomeTransactions = $account->incomeTransactions()->orderByDesc('transaction_time')->paginate($perPage, ['*'], 'income_page');
        $expenseTransactions = $account->expenseTransactions()->orderByDesc('transaction_time')->paginate($perPage, ['*'], 'expense_page');

        return view('accounts.show', compact('account', 'incomeTransactions', 'expenseTransactions', 'perPage'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'currency' => 'required|string|max:3',
        ]);

        $clientId = Auth::id();

        $accountNumber = Account::where('client_id', $clientId)->count() + 1;

        Account::create([
            'client_id' => $clientId,
            'number' => $accountNumber,
            'currency' => $validated['currency'],
            'balance' => 0,
        ]);

        return redirect()->back()->with('success', 'Счёт успешно создан!');
    }

    public function destroy($id)
    {
        $account = Account::findOrFail($id);

        // Проверяем, принадлежит ли счёт текущему пользователю
        if ($account->client_id !== Auth::user()->id) {
            return redirect()->back()->with('error', 'Вы не можете удалить этот счёт.');
        }

        $account->delete();
        return redirect()->route('cabinet')->with('success', 'Счёт удалён.');
    }

}

