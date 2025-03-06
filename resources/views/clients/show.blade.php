@extends('layouts.app')

@section('title', 'Данные клиента')

@section('content')
    <h1>Клиент: {{ $client->full_name }}</h1>
    <p>ID: {{ $client->id }}</p>

    <h2>Счета</h2>
    @if ($client->accounts->isEmpty())
        <p>У клиента нет счетов.</p>
    @else
        <ul>
            @foreach ($client->accounts as $account)
                <li>Счет #{{ $account->id }} ({{ $account->currency }})</li>
            @endforeach
        </ul>
    @endif
@endsection
