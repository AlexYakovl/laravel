@extends('layouts.app')

@section('title', 'Счёт')

@section('content')
    <div class="container">
        <h1 class="mb-4">Счёт #{{ $account->number }} ({{ $account->currency }})</h1>
        <p class="fs-5">Баланс: <strong>{{ $account->balance }} {{ $account->currency }}</strong></p>

        <!-- Выбор количества записей -->
        <form method="GET" class="mb-4 d-flex align-items-center gap-2">
            <label for="per_page" class="form-label mb-0">Операций на странице:</label>
            <select name="per_page" class="form-select w-auto" onchange="this.form.submit()">
                <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
            </select>
        </form>

        <!-- Приходные операции -->
        <h2>Приходные операции</h2>
        @if ($incomeTransactions->isEmpty())
            <div class="alert alert-info">Нет приходных операций.</div>
        @else
            <ul class="list-group mb-3">
                @foreach ($incomeTransactions as $transaction)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $transaction->amount }} {{ $account->currency }}</strong>
                            <small class="text-muted"> ({{ $transaction->transaction_time }})</small>
                        </div>
                        <div>
                            <a href="{{ route('income_transactions.edit', $transaction->id) }}" class="btn btn-sm btn-warning">Редактировать</a>
                            <form action="{{ route('income_transactions.destroy', $transaction->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
            {{ $incomeTransactions->appends(['per_page' => $perPage])->links() }}
        @endif

        <!-- Форма добавления приходной операции -->
        <h4 class="mt-4">Добавить приходную операцию</h4>
        <form action="{{ route('income_transactions.store') }}" method="POST" class="row g-3 mb-5">
            @csrf
            <input type="hidden" name="account_id" value="{{ $account->id }}">

            <div class="col-md-4">
                <label for="amount" class="form-label">Сумма:</label>
                <input type="number" name="amount" class="form-control" required>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-success">Добавить</button>
            </div>
        </form>

        <!-- Расходные операции -->
        <h2>Расходные операции</h2>
        @if ($expenseTransactions->isEmpty())
            <div class="alert alert-info">Нет расходных операций.</div>
        @else
            <ul class="list-group mb-3">
                @foreach ($expenseTransactions as $transaction)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $transaction->amount }} {{ $account->currency }}</strong>
                            <small class="text-muted"> ({{ $transaction->transaction_time }})</small>
                        </div>
                        <div>
                            <a href="{{ route('expense_transactions.edit', $transaction->id) }}" class="btn btn-sm btn-warning">Редактировать</a>
                            <form action="{{ route('expense_transactions.destroy', $transaction->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
            {{ $expenseTransactions->appends(['per_page' => $perPage])->links() }}
        @endif

        <!-- Форма добавления расходной операции -->
        <h4 class="mt-4">Добавить расходную операцию</h4>
        <form action="{{ route('expense_transactions.store') }}" method="POST" class="row g-3">
            @csrf
            <input type="hidden" name="account_id" value="{{ $account->id }}">

            <div class="col-md-4">
                <label for="amount" class="form-label">Сумма:</label>
                <input type="number" name="amount" class="form-control" required>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-danger">Добавить</button>
            </div>
        </form>

        <div class="mt-5">
            <a href="/cabinet" class="btn btn-outline-secondary">Вернуться в личный кабинет</a>
        </div>
    </div>
@endsection
