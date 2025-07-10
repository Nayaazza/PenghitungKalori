@extends('layouts.app')

@section('title', 'Kalkulator Kalori Olahraga')

@section('content')
    <div class="text-center mb-8 md:mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800">Hitung Kalori Olahraga Anda</h1>
        <p class="text-lg text-gray-600 mt-2">Pilih olahraga, masukkan durasi, dan berat badan Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
        <div class="bg-white/90 backdrop-blur-sm p-6 md:p-8 rounded-2xl shadow-lg flex flex-col h-full">
            <h2 class="text-2xl font-bold text-gray-700 mb-6">Masukkan Data</h2>
            <form id="calculate-form" class="space-y-6 flex-grow flex flex-col justify-center">
                @csrf
                <div>
                    <label for="sport_id" class="block text-sm font-medium text-gray-600 mb-1">Jenis Olahraga</label>
                    <select
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition"
                        id="sport_id" name="sport_id" required>
                        <option selected disabled value="">Pilih olahraga...</option>
                        @foreach ($sports as $sport)
                            <option value="{{ $sport->id }}" data-image-url="{{ $sport->image_url }}">{{ $sport->name }}
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
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-4 rounded-lg shadow-md transition-transform transform hover:scale-105">
                        Hitung Kalori
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg flex flex-col h-full">
            <img id="sport-image" src="https://placehold.co/600x400/FFF/757575?text=Pilih+Olahraga"
                class="w-full h-56 object-cover rounded-t-2xl transition-all duration-500 ease-in-out"
                alt="Gambar Olahraga">

            <div class="p-6 md:p-8 flex-grow flex items-center justify-center h-56">
                <div id="loading-spinner" class="text-center text-gray-500" style="display: none;">
                    <div
                        class="w-12 h-12 border-4 border-orange-400 border-t-transparent rounded-full animate-spin mx-auto">
                    </div>
                    <p class="mt-4 font-semibold">Menghitung...</p>
                </div>

                <div id="result-container" class="hidden text-center">
                    <p class="text-lg text-gray-600">Anda telah membakar sekitar</p>
                    <h1 id="calories-burned" class="text-6xl font-bold text-orange-500 my-2">0</h1>
                    <p class="text-lg text-gray-600 mb-3">Kalori!</p>
                    <p id="result-details" class="text-sm text-gray-500"></p>
                </div>

                <div id="error-container" class="hidden text-center text-red-600 font-medium"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#sport_id').on('change', function() {
                const imageUrl = $(this).find('option:selected').data('image-url');
                const imageElement = $('#sport-image');

                if (imageUrl) {
                    imageElement.addClass('opacity-0');
                    setTimeout(() => {
                        imageElement.attr('src', imageUrl);
                        imageElement.removeClass('opacity-0');
                    }, 300);
                }
            });

            $('#calculate-form').on('submit', function(e) {
                e.preventDefault();

                $('#result-container, #error-container').hide();
                $('#loading-spinner').fadeIn();

                $.ajax({
                    url: '{{ route('calculator.calculate') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#calories-burned').text(response.calories_burned);
                        $('#result-details').text(
                            `Berdasarkan olahraga ${response.sport_name} selama ${response.duration} menit dengan berat badan ${response.weight} kg.`
                        );
                        $('#result-container').fadeIn();
                    },
                    error: function(xhr) {
                        const errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr
                            .responseJSON.error : 'Terjadi kesalahan. Silakan coba lagi.';
                        $('#error-container').text(errorMessage).fadeIn();
                    },
                    complete: function() {
                        $('#loading-spinner').hide();
                    }
                });
            });
        });
    </script>
@endpush
