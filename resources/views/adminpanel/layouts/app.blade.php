<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>AM partners - Закрита партнерська база вакансій | Адмінпанель</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>

<div id="app">
    @yield('content')
</div>


</body>
</html>
