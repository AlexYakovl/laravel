@extends('layouts.app')

@section('title', 'Список клиентов')

@section('content')
    <nav>
        <a href="{{ route('clients.index') }}">Клиенты</a>
        <a href="{{ route('accounts.index') }}">Счета</a>
    </nav>


    <body>

    <div>
        @yield('content')
    </div>

    </body>
@endsection
