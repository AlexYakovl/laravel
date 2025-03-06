@extends('layouts.app')

@section('content')
    <h1>Счёт: {{ $account->currency }} - {{ $account->balance }} ₽</h1>

    <h2>Приходные операции</h2>
    <ul>
        @foreach($account->incomeTransactions as $transaction)
            <li>{{ $transaction->amount }} ₽ - {{ $transaction->transaction_time }}</li>
        @endforeach
    </ul>

    <h2>Расходные операции</h2>
    <ul>
        @foreach($account->expenseTransactions as $transaction)
            <li>{{ $transaction->amount }} ₽ - {{ $transaction->transaction_time }}</li>
        @endforeach
    </ul>
@endsection
