<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use Illuminate\Http\Request;
use App\Models\CalculationHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf; // Untuk FR06

class CalorieController extends Controller
{
    public function index()
    {
        $sports = Sport::all();
        return view('calculator', compact('sports'));
    }

    public function dashboard()
    {
        $user = Auth::user();

        // Ambil statistik
        $stats = CalculationHistory::where('user_id', $user->id)
            ->select(
                DB::raw('SUM(calories_burned) as total_calories'),
                DB::raw('SUM(duration_minutes) as total_duration')
            )
            ->first();

        // Ambil 3 riwayat terakhir
        $recentHistories = CalculationHistory::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        return view('dashboard', [
            'user' => $user,
            'stats' => $stats,
            'recentHistories' => $recentHistories,
        ]);
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

        // Simpan hanya jika pengguna sudah login
        if (Auth::check()) {
            CalculationHistory::create([
                // Menggunakan ID pengguna yang sedang login, bukan hardcode '1'
                'user_id' => Auth::id(),
                'sport_name' => $sport->name,
                'duration_minutes' => $duration,
                'weight_kg' => $weight,
                'calories_burned' => round($caloriesBurned, 2),
            ]);
        }

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
        $histories = CalculationHistory::where('user_id', Auth::id())->latest()->get();
        return view('history', compact('histories'));
    }

    /**
     * Mengunduh riwayat dalam format PDF. (FR06)
     */
    public function downloadHistoryPdf()
    {
        $histories = CalculationHistory::where('user_id', Auth::id())->latest()->get();

        // Data untuk di-pass ke view PDF
        $data = [
            'title' => 'Riwayat Perhitungan Kalori',
            'date' => date('d/m/Y'),
            'histories' => $histories
        ];

        // Membuat PDF dari view 'history_pdf'
        $pdf = PDF::loadView('history_pdf', $data);

        // Mengunduh file PDF
        return $pdf->download('riwayat-kalori-' . Auth::user()->name . '.pdf');
    }
}
