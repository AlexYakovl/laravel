<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\IncomeTransaction;
use App\Models\ExpenseTransaction;


class AccountApiController extends Controller
{
    // GET /api/accounts
    public function index(Request $request)
    {
        // Проверяем авторизацию
        if (!$request->user()) {
            return response()->json([], 200); // можно вернуть 401 если хочешь
        }

        $userId = $request->user()->id;

        // Отдаем только счета авторизованного пользователя
        $accounts = Account::where('client_id', $userId)->get();

        return response()->json($accounts);
    }


    // GET /api/accounts/{id}
    public function show($id)
    {
        $client_id = auth()->id(); // Получаем ID текущего пользователя
        $account = Account::where('client_id', $client_id)->get(); // Фильтруем по user_i
        if (!$account) {
            return response()->json(['error' => 'Счет не найден'], 404);
        }
        return response()->json($account);
    }

    // POST /api/accounts
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|integer',
            'currency'  => 'required|string|max:3',
            'balance'   => 'nullable|numeric',
        ]);

        $account = Account::create($validated);
        return response()->json($account, 201);
    }

    // PUT /api/accounts/{id}
    public function update(Request $request, $id)
    {
        $account = Account::find($id);
        if (!$account) {
            return response()->json(['error' => 'Счет не найден'], 404);
        }

        $account->update($request->all());
        return response()->json($account);
    }

    // DELETE /api/accounts/{id}
    public function destroy($id)
    {
        $account = Account::find($id);
        if (!$account) {
            return response()->json(['error' => 'Счет не найден'], 404);
        }

        $account->delete();
        return response()->json(['message' => 'Счет удален']);
    }

    // GET /api/accounts/{id}/transactions
    public function transactions(Request $request, $id)
    {
        $perpage = $request->perpage ?? 5;
        $page = $request->page ?? 0;

        // Приходы
        $incomes = IncomeTransaction::where('account_id', $id);

        // Расходы
        $expenses = ExpenseTransaction::where('account_id', $id);

        // Объединяем
        $transactions = $incomes
            ->select('id', 'amount', 'transaction_time', DB::raw("'income' as type"), 'receipt_url')
            ->unionAll(
                $expenses->select('id', 'amount', 'transaction_time', DB::raw("'expense' as type"), 'receipt_url')
            )
            ->orderBy('transaction_time', 'desc')
            ->limit($perpage)
            ->offset($page * $perpage)
            ->get();

        return response()->json($transactions);
    }


    // GET /api/accounts/{id}/transactions_total
    public function transactions_total($id)
    {
        $count =
            IncomeTransaction::where('account_id', $id)->count() +
            ExpenseTransaction::where('account_id', $id)->count();

        return response()->json($count);
    }


}
