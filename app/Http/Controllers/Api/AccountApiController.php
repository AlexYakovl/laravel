<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountApiController extends Controller
{
    // GET /api/accounts
    public function index()
    {
        return response()->json(Account::all());
    }

    // GET /api/accounts/{id}
    public function show($id)
    {
        $account = Account::find($id);
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
}
