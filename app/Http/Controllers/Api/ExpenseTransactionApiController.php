<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExpenseTransaction;
use Illuminate\Http\Request;

class ExpenseTransactionApiController extends Controller
{
    // GET /api/expense-transactions
    public function index()
    {
        return response()->json(ExpenseTransaction::all());
    }

    // GET /api/expense-transactions/{id}
    public function show($id)
    {
        $transaction = ExpenseTransaction::find($id);
        if (!$transaction) {
            return response()->json(['error' => 'Расходная операция не найдена'], 404);
        }
        return response()->json($transaction);
    }

    // POST /api/expense-transactions
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id'        => 'required|integer',
            'amount'            => 'required|numeric',
            'transaction_date'  => 'required|date',
        ]);

        $transaction = ExpenseTransaction::create($validated);
        return response()->json($transaction, 201);
    }

    // PUT /api/expense-transactions/{id}
    public function update(Request $request, $id)
    {
        $transaction = ExpenseTransaction::find($id);
        if (!$transaction) {
            return response()->json(['error' => 'Расходная операция не найдена'], 404);
        }

        $transaction->update($request->all());
        return response()->json($transaction);
    }

    // DELETE /api/expense-transactions/{id}
    public function destroy($id)
    {
        $transaction = ExpenseTransaction::find($id);
        if (!$transaction) {
            return response()->json(['error' => 'Расходная операция не найдена'], 404);
        }

        $transaction->delete();
        return response()->json(['message' => 'Расходная операция удалена']);
    }
}
