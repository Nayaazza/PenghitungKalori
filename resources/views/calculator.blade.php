@extends('layouts.app')
@section('title', 'Kalkulator Kalori Olahraga')
@section('content')
    <div class="text-center mb-8 md:mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800">Hitung Kalori Olahraga Anda</h1>
        <p class="text-lg text-gray-600 mt-2">Pilih olahraga, masukkan durasi, dan berat badan Anda.</p>
    </div>
    <div id="calculator-container" data-calculate-url="{{ route('calculator.calculate') }}"
        class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
        {{-- Form Input --}}
        <div class="bg-white/90 backdrop-blur-sm p-6 md:p-8 rounded-2xl shadow-lg flex flex-col h-full">
            <h2 class="text-2xl font-bold text-gray-700 mb-6">Masukkan Data</h2>
            <form id="calculate-form" class="space-y-6 flex-grow flex flex-col justify-center">
                <div>
                    <label for="sport_id" class="block text-sm font-medium text-gray-600 mb-1">Jenis Olahraga</label>
                    <select
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition"
                        id="sport_id" name="sport_id" required>
                        <option selected disabled value="">Pilih olahraga...</option>
                        @foreach ($sports as $sport)
                            <option value="{{ $sport->id }}" data-image-url="{{ asset($sport->image_url) }}">
                                {{ $sport->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-600 mb-1">Durasi (menit)</label>
                        <input type="number"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition"
                            id="duration" name="duration" placeholder="Contoh: 30" required min="1">
                    </div>
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-600 mb-1">Berat Badan (kg)</label>
                        <input type="number"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition"
                            id="weight" name="weight" placeholder="Contoh: 65.5" required min="1" step="0.1">
                    </div>
                </div>
                <div>
                    <label for="activity_time" class="block text-sm font-medium text-gray-600 mb-1">Waktu Aktivitas
                        (Opsional)</label>
                    <input type="datetime-local"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition"
                        id="activity_time" name="activity_time">

                    <div class="flex items-center space-x-2 mt-2">
                        <button type="button" data-time-preset="now" class="quick-time-btn">Sekarang</button>
                        <button type="button" data-time-preset="yesterday" class="quick-time-btn">Kemarin</button>
                        <button type="button" data-time-preset="morning" class="quick-time-btn">Pagi Ini</button>
                    </div>
                </div>
                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-4 rounded-lg shadow-md transition-colors duration-200 ease-in-out">
                        Hitung Kalori
                    </button>
                </div>
            </form>
        </div>

        {{-- Card Hasil dan Gambar --}}
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg flex flex-col h-full overflow-hidden">
            <div id="sport-image-container"
                class="w-full h-56 rounded-t-2xl flex items-center justify-center bg-gray-100 p-4 transition-colors duration-300">
                <img id="sport-image" src="{{ asset('images/icons/default.png') }}" alt="Ikon Olahraga"
                    class="max-w-full max-h-full object-contain transition-opacity duration-300"
                    onerror="this.onerror=null; this.src='https://placehold.co/128x128/FFF0E0/FF8C00?text=Icon';">
            </div>
            <div id="result-viewport" class="p-6 md:p-8 flex-grow flex items-center justify-center h-56">
                <div id="result-content" class="text-center text-gray-500">
                    <p>Hasil perhitungan akan muncul di sini.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Elemen tak terlihat untuk memastikan Tailwind JIT menyertakan kelas dinamis --}}
    <div class="hidden">
        <h1 class="text-6xl md:text-7xl"></h1>
    </div>
@endsection

@push('scripts')
    <style>
        .quick-time-btn {
            padding: 4px 12px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 9999px;
            transition: background-color 0.2s;
            background-color: #FFF7ED;
            color: #9A3412;
        }

        .quick-time-btn:hover {
            background-color: #FFEDD5;
        }
    </style>
@endpush
