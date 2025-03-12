<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} | EC Projects</title>
    <link rel="shortcut icon" href="{{ asset('assets/ecpr logo.png') }}" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

<body class="antialiased">
    <div class="flex h-screen max-w-full max-h-screen min-h-screen bg-mine-100 font-inter">
        @include('layouts.sidebar')

        <!-- Page Content -->
        <main class="flex flex-col w-full h-screen max-w-full gap-4 p-4 pl-28 md:pl-64">
            @include('layouts.navigation')
            <div class="relative z-20 w-full h-full max-w-full p-4 overflow-y-auto bg-white rounded-lg">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>

</html>
