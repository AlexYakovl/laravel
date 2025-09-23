<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IncomeTransaction;
use Illuminate\Http\Request;

class IncomeTransactionApiController extends Controller
{
    // GET /api/income-transactions
    public function index()
    {
        return response()->json(IncomeTransaction::all());
    }

    // GET /api/income-transactions/{id}
    public function show($id)
    {
        $transaction = IncomeTransaction::find($id);
        if (!$transaction) {
            return response()->json(['error' => 'Приходная операция не найдена'], 404);
        }
        return response()->json($transaction);
    }

    // POST /api/income-transactions
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id'        => 'required|integer',
            'amount'            => 'required|numeric',
            'transaction_date'  => 'required|date',
        ]);

        $transaction = IncomeTransaction::create($validated);
        return response()->json($transaction, 201);
    }

    // PUT /api/income-transactions/{id}
    public function update(Request $request, $id)
    {
        $transaction = IncomeTransaction::find($id);
        if (!$transaction) {
            return response()->json(['error' => 'Приходная операция не найдена'], 404);
        }

        $transaction->update($request->all());
        return response()->json($transaction);
    }

    // DELETE /api/income-transactions/{id}
    public function destroy($id)
    {
        $transaction = IncomeTransaction::find($id);
        if (!$transaction) {
            return response()->json(['error' => 'Приходная операция не найдена'], 404);
        }

        $transaction->delete();
        return response()->json(['message' => 'Приходная операция удалена']);
    }
}
