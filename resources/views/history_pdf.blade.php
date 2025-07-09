<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
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
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 0;
        }

        p {
            text-align: center;
            margin-top: 5px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <h1>{{ $title }}</h1>
    <p>Tanggal Dibuat: {{ $date }}</p>

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
                    <td>{{ $history->calories_burned }}</td>
                    <td>{{ $history->created_at->format('d M Y, H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data riwayat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
