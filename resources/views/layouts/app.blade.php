<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title> @yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js?v='.rand(1, 9999)) }}" defer></script>
    <script src="{{ asset('js/main.js?v='.rand(1, 9999)) }}"></script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css?v='.rand(1, 9999)) }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css?v='.rand(1, 9999)) }}">

    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function () {
            OneSignal.init({
                appId: "db9296e6-f1a2-4306-a76a-5aca46f243d8",
            });

            if (!OneSignal.isPushNotificationsSupported()) return;


            OneSignal.getUserId(function (playerId) {
                console.log(playerId);
                if (playerId) {
                    onesignalSubscribe(playerId);
                }
            });

            OneSignal.on("subscriptionChange", function (isSubscribed) {
                if (isSubscribed) {
                    OneSignal.getUserId(function (playerId) {
                        if (playerId) {
                            onesignalSubscribe(playerId);
                        }
                    });
                }
            });

        });

        function onesignalSubscribe(playerId) {
            let response = fetch('/onesignal/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify({
                    player_id: playerId
                })
            });
        }

    </script>

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
        'permissions'=>auth()->user()->getPermissionNames(),
        'apiToken'=>auth()->user()->api_token ?? null,
        'companies'=>auth()->user()->companies()->get(),
   ]) !!};

</script>
</body>
</html>
