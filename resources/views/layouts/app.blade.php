<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CRM</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="icon" href="{{ url('images/management.png') }}">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Loads ApexCharts library -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    {{-- jQuery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    
</head>
<body style="display: none">
    <div id="app">
        <main class="dark:bg-gray-600 min-h-screen">
            @guest
                @yield('content')
            @else    
                @include('partials/nav')
                @include('partials/aside')
                <div class="p-4 sm:ml-64">
                    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
                        @yield('content')
                    </div>
                </div>
            @endguest
        </main>
    </div>

    <!-- Loads Flowbite for interactive UI components -->
    <script  src =" https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js " > </script>
    <script src="{{ asset('js/chart-options.js') }}"></script>
    <script src="{{ asset('js/form-config.js') }}"></script>
    <script src="{{ asset('js/helpers.js') }}"></script>
    <script src="{{ asset('js/html-template.js') }}"></script>

    @yield('scripts')
</body>
</html>
