<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Aplikasi Cerdas untuk Menghitung Kalori Olahraga Anda" />
    <meta name="author" content="Naya Azza Arfah" />
    <title>@yield('title', 'Kalkulator Kalori') - KaloriKu</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="font-sans antialiased flex flex-col min-h-screen">
    <nav class="bg-white/80 backdrop-blur-md shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a class="text-2xl font-bold text-orange-500" href="{{ route('calculator.index') }}">
                    Kalori<span class="text-yellow-500">Ku</span>
                </a>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('calculator.index') }}"
                        class="text-gray-600 hover:text-orange-500 transition duration-300 {{ request()->routeIs('calculator.index') ? 'font-bold text-orange-500' : '' }}">Kalkulator</a>
                    <a href="{{ route('calculator.history') }}"
                        class="text-gray-600 hover:text-orange-500 transition duration-300 {{ request()->routeIs('calculator.history') ? 'font-bold text-orange-500' : '' }}">Riwayat</a>
                </div>
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-600 focus:outline-none">
                        <svg id="menu-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                        <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200">
            <a href="{{ route('calculator.index') }}"
                class="block py-3 px-4 text-center text-base text-gray-700 hover:bg-orange-100 transition-colors">Kalkulator</a>
            <a href="{{ route('calculator.history') }}"
                class="block py-3 px-4 text-center text-base text-gray-700 hover:bg-orange-100 transition-colors">Riwayat</a>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8 md:py-12 flex-grow">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Aplikasi KaloriKu. Dibuat dengan ❤️ oleh Naya Azza Arfah.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('scripts')
    <script>
        $(document).ready(function() {
            $('#mobile-menu-button').on('click', function() {
                $('#mobile-menu').slideToggle(300);
                $('#menu-icon').toggleClass('hidden');
                $('#close-icon').toggleClass('hidden');
            });
        });
    </script>
</body>

</html>
