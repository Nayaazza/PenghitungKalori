<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Aplikasi Penghitung Kalori Olahraga" />
    <meta name="author" content="Naya Azza Arfah" />
    <title>@yield('title', 'Kalkulator Kalori')</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .calculator-card {
            transition: all 0.3s ease-in-out;
        }

        .result-card {
            background-color: #e2e3e5;
        }

        #loading-spinner {
            display: none;
            /* FR03: Spinner disembunyikan secara default */
        }
    </style>
</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('calculator.index') }}">Kalkulator Kalori</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a
                            class="nav-link {{ request()->routeIs('calculator.index') ? 'active' : '' }}"
                            aria-current="page" href="{{ route('calculator.index') }}">Kalkulator</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ request()->routeIs('calculator.history') ? 'active' : '' }}"
                            href="{{ route('calculator.history') }}">Riwayat</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Page content-->
    <div class="container mt-5">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="py-5 bg-dark mt-auto">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Aplikasi Kalori 2025</p>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('js/scripts.js') }}"></script>
    @stack('scripts')
</body>

</html>
