@extends('layouts.app')

@section('title', 'Kalkulator Kalori Olahraga')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="fw-bolder">Hitung Kalori Olahraga Anda</h1>
                <p class="lead">Pilih jenis olahraga, masukkan durasi dan berat badan untuk mengetahui kalori yang
                    terbakar.</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Kolom Form -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm calculator-card">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-3">Masukkan Data</h5>
                    <!-- FR01: Form untuk input perhitungan -->
                    <form id="calculate-form">
                        @csrf
                        <div class="mb-3">
                            <label for="sport_id" class="form-label">Jenis Olahraga</label>
                            <select class="form-select" id="sport_id" name="sport_id" required>
                                <option selected disabled value="">Pilih olahraga...</option>
                                @foreach ($sports as $sport)
                                    <option value="{{ $sport->id }}" data-image-url="{{ $sport->image_url }}">
                                        {{ $sport->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="duration" class="form-label">Durasi (menit)</label>
                            <input type="number" class="form-control" id="duration" name="duration"
                                placeholder="Contoh: 30" required min="1">
                        </div>
                        <div class="mb-3">
                            <label for="weight" class="form-label">Berat Badan (kg)</label>
                            <input type="number" class="form-control" id="weight" name="weight"
                                placeholder="Contoh: 65" required min="1">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Hitung Kalori</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Gambar dan Hasil -->
        <div class="col-lg-6 mb-4">
            <!-- FR02: Menampilkan gambar -->
            <div class="card shadow-sm mb-4">
                <img id="sport-image" src="https://placehold.co/600x400/e0e0e0/757575?text=Pilih+Olahraga"
                    class="card-img-top" alt="Gambar Olahraga">
            </div>

            <!-- FR03: Animasi Loading -->
            <div id="loading-spinner" class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Menghitung...</p>
            </div>

            <!-- Hasil Perhitungan -->
            <div id="result-container" class="card shadow-sm result-card" style="display: none;">
                <div class="card-body text-center p-4">
                    <h5 class="card-title fw-bold">Hasil Perhitungan</h5>
                    <p class="lead">Anda telah membakar sekitar</p>
                    <h1 id="calories-burned" class="display-4 fw-bolder text-primary">0</h1>
                    <p class="lead mb-0">Kalori!</p>
                    <hr>
                    <small id="result-details" class="text-muted"></small>
                </div>
            </div>

            <div id="error-container" class="alert alert-danger" style="display: none;"></div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // FR02: Mengubah gambar saat olahraga dipilih
            $('#sport_id').on('change', function() {
                const imageUrl = $(this).find('option:selected').data('image-url');
                if (imageUrl) {
                    $('#sport-image').attr('src', imageUrl);
                }
            });

            // FR01 & FR03: Proses perhitungan via AJAX
            $('#calculate-form').on('submit', function(e) {
                e.preventDefault();

                // Tampilkan loading, sembunyikan hasil/error
                $('#loading-spinner').show();
                $('#result-container').hide();
                $('#error-container').hide();

                $.ajax({
                    url: '{{ route('calculator.calculate') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        // NFR01: Respon cepat, langsung tampilkan hasil
                        $('#calories-burned').text(response.calories_burned);
                        $('#result-details').text(
                            `Berdasarkan olahraga ${response.sport_name} selama ${response.duration} menit dengan berat badan ${response.weight} kg.`
                        );
                        $('#result-container').show();
                    },
                    error: function(xhr) {
                        const errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr
                            .responseJSON.error : 'Terjadi kesalahan. Silakan coba lagi.';
                        $('#error-container').text(errorMessage).show();
                    },
                    complete: function() {
                        // Sembunyikan loading spinner setelah selesai
                        $('#loading-spinner').hide();
                    }
                });
            });
        });
    </script>
@endpush
