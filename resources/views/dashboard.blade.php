<x-app-layout>
    <div class="space-y-12">
        <!-- Header -->
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-lg text-gray-600 mt-1">Berikut adalah ringkasan aktivitas olahragamu.</p>
        </div>

        <!-- Filter Periode -->
        <div>
            <form action="{{ route('dashboard') }}" method="GET"
                class="bg-white/90 backdrop-blur-sm p-2 rounded-xl shadow-md inline-flex items-center space-x-1">
                @php
                    $periods = [
                        'daily' => 'Harian',
                        'weekly' => 'Mingguan',
                        'monthly' => 'Bulanan',
                        'all' => 'Semua',
                    ];
                @endphp
                @foreach ($periods as $key => $label)
                    <button type="submit" name="period" value="{{ $key }}"
                        class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors duration-200
                        {{ $period == $key ? 'bg-orange-500 text-white shadow' : 'text-gray-600 hover:bg-orange-100' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </form>
        </div>

        <!-- Grid Statistik Utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Kalori Terbakar -->
            <div class="bg-gradient-to-br from-yellow-400 to-orange-500 p-6 rounded-2xl shadow-lg text-white">
                <p class="text-sm font-medium text-orange-100">Total Kalori Terbakar</p>
                <p class="text-4xl font-bold mt-2">{{ number_format($stats->total_calories ?? 0, 2) }} <span
                        class="text-2xl font-medium opacity-80">Kcal</span></p>
            </div>
            <!-- Total Durasi Olahraga -->
            <div class="bg-gray-800 p-6 rounded-2xl shadow-lg text-white">
                <p class="text-sm font-medium text-gray-400">Total Durasi Olahraga</p>
                <p class="text-4xl font-bold mt-2">{{ number_format($stats->total_duration ?? 0) }} <span
                        class="text-2xl font-medium opacity-80">Menit</span></p>
            </div>
            <!-- Olahraga Favorit -->
            <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-lg">
                <p class="text-sm font-medium text-gray-500">Olahraga Favorit</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $favoriteSport->sport_name ?? 'Belum Ada' }}</p>
            </div>
            <!-- Rekor Kalori -->
            <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-lg">
                <p class="text-sm font-medium text-gray-500">Rekor Kalori</p>
                <p class="text-3xl font-bold text-orange-600 mt-2">
                    {{ number_format($topActivity->calories_burned ?? 0, 2) }} <span
                        class="text-xl font-medium text-gray-500">Kcal</span></p>
                @if ($topActivity)
                    <p class="text-xs text-gray-400 mt-1">dari {{ $topActivity->sport_name }}</p>
                @endif
            </div>
        </div>

        <!-- Grid Konten Utama (Grafik & Riwayat) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Grafik Aktivitas -->
            <div class="lg:col-span-2 bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-lg">
                {{-- Judul Grafik Dinamis --}}
                <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ $chartTitle }}</h3>
                <canvas id="activityChart"></canvas>
            </div>

            <!-- Riwayat Terakhir & Aksi -->
            <div class="space-y-8">
                <!-- Aktivitas Terakhir -->
                <div class="bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Aktivitas Terakhir</h3>
                    <div class="space-y-4">
                        @forelse ($recentHistories as $history)
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $history->sport_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $history->created_at->diffForHumans() }}</p>
                                </div>
                                <p class="font-bold text-orange-600">{{ number_format($history->calories_burned, 2) }}
                                    Kcal</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">Belum ada aktivitas.</p>
                        @endforelse
                    </div>
                </div>
                <!-- Tombol Aksi -->
                <div class="space-y-4">
                    <a href="{{ route('calculator.index') }}"
                        class="flex items-center justify-center w-full text-center p-4 bg-orange-500 text-white font-bold rounded-xl shadow-lg hover:bg-orange-600 transition-colors duration-200">
                        Hitung Kalori Baru
                    </a>
                    <a href="{{ route('calculator.history') }}"
                        class="flex items-center justify-center w-full text-center p-4 bg-gray-800 text-white font-bold rounded-xl shadow-lg hover:bg-gray-900 transition-colors duration-200">
                        Lihat Riwayat Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('activityChart');
            // Hancurkan chart lama jika ada untuk mencegah error saat filter
            if (window.myActivityChart instanceof Chart) {
                window.myActivityChart.destroy();
            }
            window.myActivityChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Kalori Terbakar',
                        data: @json($chartValues),
                        backgroundColor: 'rgba(249, 115, 22, 0.6)',
                        borderColor: 'rgba(249, 115, 22, 1)',
                        borderWidth: 1,
                        borderRadius: 8,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
