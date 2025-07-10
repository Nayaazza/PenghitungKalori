<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'KaloriKu'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased flex flex-col min-h-screen">
    <div class="flex-grow">
        @include('layouts.navigation')

        <main class="container mx-auto px-4 py-8 md:py-12">
            {{-- Ini akan merender konten dari halaman Breeze (seperti profile) --}}
            @if (isset($slot))
                {{ $slot }}
            @endif

            {{-- Ini akan merender konten dari halaman kita (kalkulator, riwayat) --}}
            @yield('content')
        </main>
    </div>

    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Aplikasi KaloriKu. Dibuat dengan ❤️ oleh Naya Azza Arfah.</p>
        </div>
    </footer>
    @stack('scripts')
</body>

</html>
