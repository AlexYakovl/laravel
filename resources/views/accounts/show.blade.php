@extends('layouts.app')

@section('title', 'Счёт')

@section('content')
    <h1>Счёт #{{ $account->id }} ({{ $account->currency }})</h1>
    <p>Баланс: {{ $account->balance }} ₽</p>

    <h2>Приходные операции</h2>
    @if ($account->incomeTransactions->isEmpty())
        <p>Нет приходных операций.</p>
    @else
        <ul>
            @foreach ($account->incomeTransactions as $transaction)
                <li>{{ $transaction->amount }} ₽ ({{ $transaction->transaction_date }})</li>
            @endforeach
        </ul>
    @endif

    <h2>Расходные операции</h2>
    @if ($account->expenseTransactions->isEmpty())
        <p>Нет расходных операций.</p>
    @else
        <ul>
            @foreach ($account->expenseTransactions as $transaction)
                <li>{{ $transaction->amount }} ₽ ({{ $transaction->transaction_date }})</li>
            @endforeach
        </ul>
    @endif
@endsection
