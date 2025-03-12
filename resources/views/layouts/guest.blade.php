<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ $title }} | EC Projects </title>
    <link rel="shortcut icon" href="{{ asset('assets/ecpr logo.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased text-gray-900 font-inter">
    <div class="flex flex-col items-center justify-center min-h-screen pt-4 bg-mine-100">
        <div class="w-full max-w-md px-6 py-4 mt-6 overflow-hidden bg-white rounded-lg shadow-md">
            <div class="flex justify-center w-full pb-4">
                <a href="/">
                    <x-application-logo class="w-20 h-20 rounded-lg bg-mine-200" />
                </a>
            </div>
            {{ $slot }}
        </div>
    </div>
</body>

</html>
