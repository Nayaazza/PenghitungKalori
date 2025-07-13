@extends('layouts.app')

@section('title', 'Riwayat Perhitungan')

@section('content')
    {{-- Notifikasi Sukses (Toast) yang Disempurnakan --}}
    @if (session('status'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-4"
            class="fixed top-5 left-1/2 -translate-x-1/2 z-50 flex items-center bg-green-500 text-white py-2 px-5 rounded-full shadow-lg"
            role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Riwayat Perhitungan</h1>
            <p class="text-lg text-gray-600 mt-1">Berikut adalah daftar perhitungan kalori yang pernah Anda lakukan.</p>
        </div>
        <a href="{{ route('calculator.download.pdf', request()->query()) }}"
            class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-lg shadow-md transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="mr-2"
                viewBox="0 0 16 16">
                <path
                    d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                <path
                    d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
            </svg>
            Download PDF
        </a>
    </div>

    <div class="bg-white/90 backdrop-blur-sm p-4 rounded-2xl shadow-lg mb-8">
        <form action="{{ route('calculator.history') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 items-end">
                <div>
                    <label for="sport_name" class="block text-sm font-medium text-gray-700">Jenis Olahraga</label>
                    <select id="sport_name" name="sport_name"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                        <option value="">Semua Olahraga</option>
                        @foreach ($sports as $sport)
                            <option value="{{ $sport->name }}"
                                {{ request('sport_name') == $sport->name ? 'selected' : '' }}>
                                {{ $sport->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="date" id="date" value="{{ request('date') }}"
                        class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="flex space-x-2">
                    <button type="submit"
                        class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Filter
                    </button>
                    <a href="{{ route('calculator.history') }}"
                        class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-100 border-b-2 border-gray-200">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">No.</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Jenis Olahraga</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Durasi (Menit)</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Berat (Kg)</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Kalori Terbakar</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Tanggal</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($histories as $history)
                        <tr x-data="{ modalOpen: false }"
                            class="hover:bg-orange-50 transition duration-200 border-b border-gray-200">
                            <td class="p-4 text-gray-700 w-16">
                                {{ ($histories->currentPage() - 1) * $histories->perPage() + $loop->iteration }}.</td>
                            <td class="p-4 text-gray-700">{{ $history->sport_name }}</td>
                            <td class="p-4 text-gray-700">{{ $history->duration_minutes }}</td>
                            <td class="p-4 text-gray-700">{{ $history->weight_kg }}</td>
                            <td class="p-4 text-orange-600 font-bold">{{ number_format($history->calories_burned, 2) }}
                            </td>
                            <td class="p-4 text-sm text-gray-500">
                                {{ $history->created_at->translatedFormat('d F Y, H:i') }}
                            </td>
                            <td class="p-4 text-center">
                                {{-- Tombol Hapus Baru dengan Gaya yang Disempurnakan --}}
                                <button @click="modalOpen = true"
                                    class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-xs font-bold rounded-lg shadow-md hover:bg-red-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus
                                </button>

                                <!-- Modal Konfirmasi Hapus -->
                                <div x-show="modalOpen" x-cloak
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                                    @keydown.escape.window="modalOpen = false">
                                    <div @click.away="modalOpen = false"
                                        class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                                        <h2 class="text-lg font-bold text-gray-900">Konfirmasi Hapus</h2>
                                        <p class="mt-2 text-sm text-gray-600">Apakah Anda yakin ingin menghapus riwayat ini?
                                            Aksi ini tidak dapat dibatalkan.</p>
                                        <div class="mt-6 flex justify-end space-x-3">
                                            <form method="POST" action="{{ route('history.destroy', $history->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700">
                                                    Ya, Hapus
                                                </button>
                                            </form>
                                            <button @click="modalOpen = false" type="button"
                                                class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-300">
                                                Batal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-gray-500">
                                Belum ada riwayat perhitungan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $histories->links('vendor.pagination.custom-pagination') }}
    </div>
@endsection
