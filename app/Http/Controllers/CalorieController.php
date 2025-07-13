<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CalculationHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CalorieController extends Controller
{
    public function index()
    {
        // Mengambil data olahraga dan mengurutkannya berdasarkan nama
        $sports = Sport::orderBy('name', 'asc')->get();
        return view('calculator', compact('sports'));
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $period = $request->input('period', 'all'); // Default ke 'semua'

        $query = CalculationHistory::where('user_id', $user->id);

        // Terapkan filter periode waktu pada query
        switch ($period) {
            case 'daily':
                $query->whereDate('created_at', today());
                break;
            case 'weekly':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'monthly':
                $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                break;
        }

        // Ambil statistik berdasarkan query yang sudah difilter
        $stats = (clone $query)->select(
            DB::raw('SUM(calories_burned) as total_calories'),
            DB::raw('SUM(duration_minutes) as total_duration')
        )
            ->first();

        // Ambil 5 riwayat terakhir (tidak terpengaruh filter periode)
        $recentHistories = CalculationHistory::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', [
            'stats' => $stats,
            'recentHistories' => $recentHistories,
            'period' => $period,
        ]);
    }

    public function calculate(Request $request)
    {
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

        $caloriesBurned = ($sport->met_value * $weight * 3.5) / 200 * $duration;

        if (Auth::check()) {
            CalculationHistory::create([
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
     * Menampilkan halaman riwayat dengan logika filter.
     */
    public function history(Request $request)
    {
        // Ambil query builder dasar
        $query = CalculationHistory::where('user_id', Auth::id());

        // Terapkan filter jika ada
        if ($request->filled('sport_name')) {
            $query->where('sport_name', $request->sport_name);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $histories = $query->latest()->paginate(10)->withQueryString();

        // Ambil daftar olahraga unik untuk dropdown filter dan urutkan
        $sports = Sport::orderBy('name', 'asc')->get();

        return view('history', compact('histories', 'sports'));
    }

    /**
     * Mengunduh PDF dengan logika filter yang sama.
     */
    public function downloadHistoryPdf(Request $request)
    {
        $query = CalculationHistory::where('user_id', Auth::id());

        // Terapkan filter yang sama seperti di halaman history
        if ($request->filled('sport_name')) {
            $query->where('sport_name', $request->sport_name);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $histories = $query->latest()->get();

        $data = [
            'title' => 'Riwayat Perhitungan Kalori',
            'date' => date('d/m/Y'),
            'histories' => $histories
        ];

        $pdf = PDF::loadView('history_pdf', $data);

        return $pdf->download('riwayat-kalori-' . Auth::user()->name . '.pdf');
    }
}
