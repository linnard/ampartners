<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title> @yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>

<div id="app">
    @yield('content')
</div>

<script>
    window.user = {!! json_encode([
        'firstname' => Auth::user()->firstname,
        'lastname' => Auth::user()->lastname,
        'roles'=>auth()->user()->getRoleNames(),
        'apiToken'=>auth()->user()->api_token ?? null,
   ]) !!};

</script>
</body>
</html>
