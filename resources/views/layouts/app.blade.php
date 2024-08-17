<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <main class="dark:bg-gray-600 min-h-screen">
            @yield('content')
        </main>
    </div>
    <!-- Loads Flowbite for interactive UI components -->
    <script  src =" https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js " > </script>
</body>
</html>
