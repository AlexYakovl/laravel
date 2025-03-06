@extends('layouts.app')

@section('title', 'Список клиентов')

@section('content')
    <h1>Список клиентов</h1>
    <ul>
        @foreach($clients as $client)
            <li>
                <a href="{{ route('clients.show', $client->id) }}">{{ $client->full_name }}</a>
            </li>
        @endforeach
    </ul>
@endsection
