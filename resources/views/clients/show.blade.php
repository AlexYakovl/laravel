@extends('layouts.app')

@section('title', 'Данные клиента')

@section('content')
    <h1>Клиент: {{ $client->name }}</h1>

    <h2>Счета:</h2>
    <ul>
        @foreach ($client->accounts as $account)
            <li>
                <a href="{{ route('accounts.show', $account->id) }}">
                    Счет #{{ $account->id }} ({{ $account->currency }}) - Баланс: {{ $account->balance }} ₽
                </a>
            </li>
        @endforeach
    </ul>

    <a href="{{ route('clients.index') }}">Вернуться к списку клиентов</a>
@endsection
