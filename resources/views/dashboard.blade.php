<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, {{ $user->name }}!</h1>
                <p class="text-lg text-gray-600">Berikut adalah ringkasan aktivitas olahragamu.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gradient-to-br from-orange-400 to-yellow-400 p-6 rounded-2xl shadow-lg text-white">
                    <h3 class="text-lg font-semibold text-white/80">Total Kalori Terbakar</h3>
                    <p class="text-4xl font-bold mt-2">{{ number_format($stats->total_calories ?? 0, 2) }} <span
                            class="text-2xl font-medium">Kcal</span></p>
                </div>
                <div class="bg-gradient-to-br from-gray-700 to-gray-800 p-6 rounded-2xl shadow-lg text-white">
                    <h3 class="text-lg font-semibold text-white/80">Total Durasi Olahraga</h3>
                    <p class="text-4xl font-bold mt-2">{{ number_format($stats->total_duration ?? 0) }} <span
                            class="text-2xl font-medium">Menit</span></p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <a href="{{ route('calculator.index') }}"
                    class="bg-orange-500 text-white text-center p-6 rounded-2xl shadow-lg hover:bg-orange-600 transition duration-300">
                    <h3 class="text-2xl font-bold">Hitung Kalori Baru</h3>
                    <p class="text-orange-100 mt-1">Mulai perhitungan baru</p>
                </a>
                <a href="{{ route('calculator.history') }}"
                    class="bg-gray-800 text-white text-center p-6 rounded-2xl shadow-lg hover:bg-gray-900 transition duration-300">
                    <h3 class="text-2xl font-bold">Lihat Riwayat Lengkap</h3>
                    <p class="text-gray-300 mt-1">Tinjau semua aktivitasmu</p>
                </a>
            </div>

            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Aktivitas Terakhir</h3>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 space-y-4">
                        @forelse ($recentHistories as $history)
                            <div class="flex justify-between items-center border-b pb-2">
                                <div>
                                    <p class="font-semibold">{{ $history->sport_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $history->duration_minutes }} menit -
                                        {{ $history->created_at->diffForHumans() }}</p>
                                </div>
                                <p class="font-bold text-lg text-orange-600">{{ $history->calories_burned }} Kcal</p>
                            </div>
                        @empty
                            <p class="text-gray-500">Kamu belum punya riwayat perhitungan. Ayo mulai berolahraga!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
