<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
        }

        .text-center {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #e0e0e0;
            text-align: left;
            padding: 10px;
        }

        th {
            background-color: #FFF3E0;
            /* Kuning muda, senada dengan tema */
            color: #FF8C00;
            /* Oranye tua untuk teks header */
            text-transform: uppercase;
            font-size: 10px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        h1 {
            color: #FF8C00;
            /* Oranye tua */
            text-align: center;
            font-size: 22px;
            margin-bottom: 5px;
        }

        p.subtitle {
            text-align: center;
            margin-top: 0;
            font-size: 12px;
            color: #777;
        }

        .footer {
            position: fixed;
            bottom: -20px;
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>

<body>
    <h1>{{ $title }}</h1>
    <p class="subtitle">Tanggal Dibuat: {{ $date }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Jenis Olahraga</th>
                <th>Durasi (Menit)</th>
                <th>Berat Badan (Kg)</th>
                <th>Kalori Terbakar</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($histories as $history)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $history->sport_name }}</td>
                    <td>{{ $history->duration_minutes }}</td>
                    <td>{{ $history->weight_kg }}</td>
                    <td><b>{{ $history->calories_burned }}</b></td>
                    <td>{{ $history->created_at->format('d M Y, H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data riwayat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Aplikasi KaloriKu &copy; {{ date('Y') }}
    </div>
</body>

</html>
