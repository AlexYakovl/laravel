@extends('layouts.app')

@section('title', 'Список счетов')

@section('content')
    <h1>Список счетов</h1>
    <ul>
        @foreach($accounts as $account)
            <li>
                <a href="{{ route('accounts.show', $account->id) }}">
                    {{ $account->currency }} - {{ $account->balance }} ₽
                </a>
            </li>
        @endforeach
    </ul>
@endsection
