@extends('layouts.app')

@section('title', 'Riwayat Perhitungan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bolder">Riwayat Perhitungan</h1>
            <p class="lead">Berikut adalah daftar perhitungan kalori yang pernah Anda lakukan.</p>
        </div>
        <div>
            {{-- FR06: Tombol untuk download PDF --}}
            <a href="{{ route('calculator.download.pdf') }}" class="btn btn-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download"
                    viewBox="0 0 16 16">
                    <path
                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                    <path
                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                </svg>
                Download PDF
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            {{-- FR05: Tampilan riwayat --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Jenis Olahraga</th>
                            <th scope="col">Durasi (Menit)</th>
                            <th scope="col">Berat Badan (Kg)</th>
                            <th scope="col">Kalori Terbakar</th>
                            <th scope="col">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($histories as $history)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $history->sport_name }}</td>
                                <td>{{ $history->duration_minutes }}</td>
                                <td>{{ $history->weight_kg }}</td>
                                <td class="fw-bold text-primary">{{ $history->calories_burned }}</td>
                                <td>{{ $history->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada riwayat perhitungan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
