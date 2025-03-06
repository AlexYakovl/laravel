<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Банк')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        nav {
            background-color: #333;
            padding: 10px;
        }
        nav a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<nav>
    <a href="{{ route('clients.index') }}">Клиенты</a>
    <a href="{{ route('accounts.index') }}">Счета</a>
</nav>

<div>
    @yield('content')
</div>

</body>
</html>
