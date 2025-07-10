@extends('layouts.app')

@section('title', 'Riwayat Perhitungan')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Riwayat Perhitungan</h1>
            <p class="text-lg text-gray-600 mt-1">Berikut adalah daftar perhitungan kalori yang pernah Anda lakukan.</p>
        </div>
        <a href="{{ route('calculator.download.pdf') }}"
            class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-md transition-transform transform hover:scale-105">
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
                    </tr>
                </thead>
                <tbody>
                    @forelse($histories as $history)
                        <tr class="hover:bg-orange-50 transition duration-200 border-b border-gray-200">
                            <td class="p-4 text-gray-700 w-16">{{ $loop->iteration }}.</td>
                            <td class="p-4 text-gray-700">{{ $history->sport_name }}</td>
                            <td class="p-4 text-gray-700">{{ $history->duration_minutes }}</td>
                            <td class="p-4 text-gray-700">{{ $history->weight_kg }}</td>
                            <td class="p-4 text-orange-600 font-bold">{{ $history->calories_burned }}</td>
                            <td class="p-4 text-sm text-gray-500">{{ $history->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-gray-500">
                                Belum ada riwayat perhitungan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
