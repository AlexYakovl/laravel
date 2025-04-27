<?php

namespace App\Http\Controllers;

use App\Models\IncomeTransaction;
use Illuminate\Http\Request;
use App\Models\Account;
class IncomeTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1',
        ]);

        IncomeTransaction::create($validated);

        return redirect()->back()->with('success', 'Приходная операция добавлена!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $account = Account::with(['incomeTransactions', 'expenseTransactions'])->findOrFail($id);
        return view('accounts.show', compact('account'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transaction = IncomeTransaction::findOrFail($id);
        return view('transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $transaction = IncomeTransaction::findOrFail($id);
        $transaction->update($validated);

        return redirect()->route('accounts.show', $transaction->account_id)->with('success', 'Операция обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaction = IncomeTransaction::findOrFail($id);
        $transaction->delete();

        return redirect()->back()->with('success', 'Операция удалена!');
    }
}
