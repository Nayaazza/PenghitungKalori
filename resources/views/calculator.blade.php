@extends('layouts.app')
@section('title', 'Kalkulator Kalori Olahraga')
@section('content')
    <div class="text-center mb-8 md:mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800">Hitung Kalori Olahraga Anda</h1>
        <p class="text-lg text-gray-600 mt-2">Pilih olahraga, masukkan durasi, dan berat badan Anda.</p>
    </div>
    <div id="calculator-container" data-calculate-url="{{ route('calculator.calculate') }}"
        class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
        <div class="bg-white/90 backdrop-blur-sm p-6 md:p-8 rounded-2xl shadow-lg flex flex-col h-full">
            <h2 class="text-2xl font-bold text-gray-700 mb-6">Masukkan Data</h2>
            <form id="calculate-form" class="space-y-6 flex-grow flex flex-col justify-center">
                {{-- @csrf tidak lagi diperlukan di sini karena sudah dihandle oleh JS --}}
                <div>
                    <label for="sport_id" class="block text-sm font-medium text-gray-600 mb-1">Jenis Olahraga</label>
                    <select
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition"
                        id="sport_id" name="sport_id" required>
                        <option selected disabled value="">Pilih olahraga...</option>
                        @foreach ($sports as $sport)
                            <option value="{{ $sport->id }}" data-icon-svg="{{ $sport->icon_svg }}">{{ $sport->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
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
                        id="weight" name="weight" placeholder="Contoh: 65" required min="1">
                </div>
                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-4 rounded-lg shadow-md transition-colors duration-200 ease-in-out">
                        Hitung Kalori
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg flex flex-col h-full">
            <div id="sport-icon-container"
                class="w-full h-56 rounded-t-2xl flex items-center justify-center bg-gray-100 transition-colors duration-300">
                <svg id="sport-icon" class="w-24 h-24 text-gray-400 transition-all duration-300" fill="none"
                    stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125">
                    </path>
                </svg>
            </div>
            <div id="result-viewport" class="p-6 md:p-8 flex-grow flex items-center justify-center h-56">
                <div id="result-content" class="text-center text-gray-500">
                    <p>Hasil perhitungan akan muncul di sini.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function getResultContent(response) {
            return `
        <div class="text-center animate-fade-in">
            <p class="text-xl text-gray-600">Anda telah membakar sekitar</p>
            <h1 class="text-7xl font-bold text-orange-500 my-2">${response.calories_burned}</h1>
            <p class="text-xl text-gray-600 mb-3">Kalori!</p>
            <p class="text-sm text-gray-500">Berdasarkan olahraga ${response.sport_name} selama ${response.duration} menit dengan berat badan ${response.weight} kg.</p>
        </div>`;
        }

        $('#sport_id').on('change', function() {
            const selectedOption = $(this).find("option:selected");
            const iconSvg = selectedOption.data("icon-svg");
            const sportIcon = $("#sport-icon");
            if (iconSvg) {
                sportIcon.html(iconSvg);
                $('#sport-icon-container').removeClass('bg-gray-100').addClass('bg-orange-100');
                sportIcon.removeClass('text-gray-400').addClass('text-orange-500');
            }
        });
    </script>
@endpush
