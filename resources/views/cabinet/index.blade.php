@extends('layouts.app')

@section('content')
    <h1>Личный кабинет</h1>
    <p>Здравствуйте, {{ Auth::user()->name }}</p>

    @if (Auth::user()->is_admin)
        <a href="{{ route('admin') }}" class="btn btn-primary">Перейти в админ-панель</a>
    @endif

    <h2>Ваши счета</h2>

    @if ($client && $client->accounts->count() > 0)
        <ul>
            @foreach ($client->accounts as $account)
                <li>
                    <a href="{{ route('accounts.show', $account->id) }}">
                        Счет #{{ $account->number }} - Баланс: {{ $account->balance }} {{ $account->currency }}
                    </a>
                    <!-- Кнопка удаления счета -->
                    <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p>У вас пока нет счетов.</p>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Форма добавления нового счета -->
    <h3>Добавить новый счет</h3>
    <form action="{{ route('accounts.store') }}" method="POST">
        @csrf
        <label for="currency">Валюта:</label>
        <input type="text" name="currency" required placeholder="Например, RUB">
        <button type="submit" class="btn btn-success">Создать счет #{{ $nextAccountNumber }}</button>
    </form>
@endsection
