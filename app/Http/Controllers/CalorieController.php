<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sport;
use App\Models\CalculationHistory;
use Barryvdh\DomPDF\Facade\Pdf; // Untuk FR06
use Illuminate\Support\Facades\Validator;

class CalorieController extends Controller
{
    /**
     * Menampilkan halaman utama kalkulator.
     */
    public function index()
    {
        $sports = Sport::all();
        return view('calculator', compact('sports'));
    }

    /**
     * Menghitung kalori berdasarkan input. (FR01)
     * Menyimpan hasil ke riwayat. (FR04)
     */
    public function calculate(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'sport_id' => 'required|exists:sports,id',
            'duration' => 'required|numeric|min:1',
            'weight' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $sport = Sport::find($request->sport_id);
        $duration = $request->duration;
        $weight = $request->weight;

        // Rumus MET untuk menghitung kalori
        // Kalori = (MET * Berat Badan * 3.5) / 200 * Durasi (menit)
        $caloriesBurned = ($sport->met_value * $weight * 3.5) / 200 * $duration;

        // Simpan ke riwayat (FR04)
        // NFR04 & NFR05: Data disimpan di database (cloud/server)
        CalculationHistory::create([
            'user_id' => 1, // Sementara, harusnya dari Auth::id()
            'sport_name' => $sport->name,
            'duration_minutes' => $duration,
            'weight_kg' => $weight,
            'calories_burned' => round($caloriesBurned, 2),
        ]);

        // NFR01: Respon cepat karena kalkulasi sederhana
        return response()->json([
            'sport_name' => $sport->name,
            'duration' => $duration,
            'weight' => $weight,
            'calories_burned' => round($caloriesBurned, 2)
        ]);
    }

    /**
     * Menampilkan halaman riwayat. (FR05)
     */
    public function history()
    {
        // Ambil riwayat untuk user_id 1 (sementara)
        $histories = CalculationHistory::where('user_id', 1)->latest()->get();
        return view('history', compact('histories'));
    }

    /**
     * Mengunduh riwayat dalam format PDF. (FR06)
     */
    public function downloadHistoryPdf()
    {
        $histories = CalculationHistory::where('user_id', 1)->latest()->get();

        // Data untuk di-pass ke view PDF
        $data = [
            'title' => 'Riwayat Perhitungan Kalori',
            'date' => date('d/m/Y'),
            'histories' => $histories
        ];

        // Membuat PDF dari view 'history_pdf'
        $pdf = PDF::loadView('history_pdf', $data);

        // Mengunduh file PDF
        return $pdf->download('riwayat-kalori.pdf');
    }
}
