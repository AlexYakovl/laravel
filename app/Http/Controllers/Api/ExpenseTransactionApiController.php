<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExpenseTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

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

    public function store(Request $request)
    {
        // Проверка прав (добавим позже)
        // if (! Gate::allows('create-expense-transaction')) {
        //     return response()->json(['code' => 1, 'message' => 'Нет прав'], 403);
        // }

        $validated = $request->validate([
            'account_id'        => 'required|integer',
            'amount'            => 'required|numeric',
            'transaction_time'  => 'required|date',
            'receipt'           => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096' // чек
        ]);

        $fileUrl = null;

        // Если чек загружен
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $fileName = uniqid() . '_' . $file->getClientOriginalName();

            try {
                // Путь: receipts/expense/filename
                $path = Storage::disk('s3')->putFileAs(
                    'receipts/expense',
                    $file,
                    $fileName
                );
                $fileUrl = Storage::disk('s3')->url($path);

            } catch (Exception $e) {
                return response()->json([
                    'code' => 2,
                    'message' => 'Ошибка загрузки файла в S3',
                ], 500);
            }
        }

        // Создаем запись
        $transaction = new ExpenseTransaction($validated);
        $transaction->receipt_url = $fileUrl;
        $transaction->save();

        return response()->json([
            'code' => 0,
            'message' => 'Расходная операция добавлена',
            'transaction' => $transaction
        ], 201);
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
