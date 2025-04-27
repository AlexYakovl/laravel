@extends('layouts.app')

@section('title', 'Редактировать операцию')

@section('content')
    <h1>Редактировать операцию</h1>

    <form action="{{ route(request()->routeIs('income_transactions.edit') ? 'income_transactions.update' : 'expense_transactions.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="amount">Сумма:</label>
        <input type="number" name="amount" value="{{ old('amount', $transaction->amount) }}" required>

        <button type="submit" class="btn btn-success">Сохранить</button>
    </form>

    <a href="{{ route('accounts.show', $transaction->account_id) }}" class="btn btn-secondary">Отмена</a>
@endsection
