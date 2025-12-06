<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IncomeTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

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
        // Проверка прав (добавим позже)
        // if (! Gate::allows('create-income-transaction')) {
        //     return response()->json(['code' => 1, 'message' => 'Нет прав'], 403);
        // }

        $validated = $request->validate([
            'account_id'        => 'required|integer',
            'amount'            => 'required|numeric',
            'transaction_time'  => 'required|date',
            'receipt'           => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096'
        ]);

        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $fileName = rand(1, 100000) . '_' . $file->getClientOriginalName();

            try {
                $path = Storage::disk('s3')->putFileAs(
                    'receipts/income',
                    $file,
                    $fileName
                );
                $fileUrl = Storage::disk('s3')->url($path);

            } catch (Exception $e) {
                return response()->json([
                    'code' => 2,
                    'message' => 'Ошибка загрузки в S3',
                ], 500);
            }
        }

        $transaction = new IncomeTransaction($validated);
        $transaction->receipt_url = $fileUrl;
        $transaction->save();

        return response()->json([
            'code' => 0,
            'message' => 'Приходная операция добавлена',
            'transaction' => $transaction
        ], 201);
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
