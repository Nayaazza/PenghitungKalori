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
        $sports = Sport::orderBy('name', 'asc')->get();
        return view('calculator', compact('sports'));
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $period = $request->input('period', 'weekly'); // Default ke mingguan

        // Query dasar untuk statistik utama
        $statsQuery = CalculationHistory::where('user_id', $user->id);

        // Terapkan filter periode untuk statistik utama (Total Kalori & Durasi)
        switch ($period) {
            case 'daily':
                $statsQuery->whereDate('created_at', today());
                break;
            case 'weekly':
                $statsQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'monthly':
                $statsQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                break;
        }

        $stats = (clone $statsQuery)->select(
            DB::raw('SUM(calories_burned) as total_calories'),
            DB::raw('SUM(duration_minutes) as total_duration')
        )->first();

        // --- STATISTIK TAMBAHAN (selalu 'semua waktu') ---
        $allTimeQuery = CalculationHistory::where('user_id', $user->id);
        $favoriteSport = (clone $allTimeQuery)->select('sport_name', DB::raw('count(*) as count'))->groupBy('sport_name')->orderByDesc('count')->first();
        $topActivity = (clone $allTimeQuery)->orderByDesc('calories_burned')->first();

        // --- PERSIAPAN DATA GRAFIK DINAMIS ---
        $chartTitle = 'Aktivitas';
        $chartLabels = [];
        $chartValues = [];

        switch ($period) {
            case 'daily':
                $chartTitle = 'Aktivitas Hari Ini (per Jam)';
                $chartData = CalculationHistory::where('user_id', $user->id)
                    ->whereDate('created_at', today())
                    ->groupBy('hour')
                    ->orderBy('hour', 'asc')
                    ->get([
                        DB::raw('HOUR(created_at) as hour'),
                        DB::raw('SUM(calories_burned) as total_calories')
                    ])->pluck('total_calories', 'hour');
                for ($hour = 0; $hour < 24; $hour++) {
                    $chartLabels[] = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
                    $chartValues[] = $chartData[$hour] ?? 0;
                }
                break;

            case 'monthly':
                $chartTitle = 'Aktivitas Bulan Ini (per Hari)';
                $daysInMonth = now()->daysInMonth;
                $chartData = CalculationHistory::where('user_id', $user->id)
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->groupBy('day')
                    ->orderBy('day', 'asc')
                    ->get([
                        DB::raw('DAY(created_at) as day'),
                        DB::raw('SUM(calories_burned) as total_calories')
                    ])->pluck('total_calories', 'day');
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $chartLabels[] = $day;
                    $chartValues[] = $chartData[$day] ?? 0;
                }
                break;

            case 'all':
                $chartTitle = 'Ringkasan 12 Bulan Terakhir';
                $chartData = CalculationHistory::where('user_id', $user->id)
                    ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
                    ->select(
                        DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                        DB::raw('SUM(calories_burned) as total_calories')
                    )
                    ->groupBy('month')
                    ->orderBy('month', 'asc')
                    ->get()->pluck('total_calories', 'month');

                for ($i = 11; $i >= 0; $i--) {
                    $date = now()->subMonths($i);
                    $monthKey = $date->format('Y-m');
                    $chartLabels[] = $date->translatedFormat('M Y');
                    $chartValues[] = $chartData[$monthKey] ?? 0;
                }
                break;

            case 'weekly':
            default:
                $chartTitle = 'Aktivitas Minggu Ini (per Hari)';
                $chartData = CalculationHistory::where('user_id', $user->id)
                    ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->groupBy('day')
                    ->orderBy('day', 'asc')
                    ->get([
                        DB::raw('DAYOFWEEK(created_at) as day'), // 1=Minggu, 2=Senin, ...
                        DB::raw('SUM(calories_burned) as total_calories')
                    ])->pluck('total_calories', 'day');

                $days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
                for ($i = 0; $i < 7; $i++) {
                    $dayOfWeek = now()->startOfWeek()->addDays($i)->dayOfWeek; // 0=Minggu, 1=Senin
                    $dayKey = $dayOfWeek + 1; // Sesuaikan dengan DAYOFWEEK
                    $chartLabels[] = $days[$dayOfWeek];
                    $chartValues[] = $chartData[$dayKey] ?? 0;
                }
                break;
        }

        // --- RIWAYAT TERAKHIR ---
        $recentHistories = CalculationHistory::where('user_id', $user->id)->latest()->take(5)->get();

        return view('dashboard', [
            'stats' => $stats,
            'recentHistories' => $recentHistories,
            'period' => $period,
            'favoriteSport' => $favoriteSport,
            'topActivity' => $topActivity,
            'chartTitle' => $chartTitle,
            'chartLabels' => $chartLabels,
            'chartValues' => $chartValues,
        ]);
    }

    public function calculate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sport_id' => 'required|exists:sports,id',
            'duration' => 'required|numeric|min:1',
            'weight' => 'required|numeric|min:1',
            'activity_time' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $sport = Sport::find($request->sport_id);
        $duration = $request->duration;
        $weight = $request->weight;

        $activityTime = $request->filled('activity_time') ? Carbon::parse($request->activity_time) : now();

        $caloriesBurned = ($sport->met_value * $weight * 3.5) / 200 * $duration;

        if (Auth::check()) {
            CalculationHistory::create([
                'user_id' => Auth::id(),
                'sport_name' => $sport->name,
                'duration_minutes' => $duration,
                'weight_kg' => $weight,
                'calories_burned' => round($caloriesBurned, 2),
                'created_at' => $activityTime,
                'updated_at' => $activityTime,
            ]);
        }

        return response()->json([
            'sport_name' => $sport->name,
            'duration' => $duration,
            'weight' => $weight,
            'calories_burned' => round($caloriesBurned, 2)
        ]);
    }

    public function history(Request $request)
    {
        $query = CalculationHistory::where('user_id', Auth::id());

        if ($request->filled('sport_name')) {
            $query->where('sport_name', $request->sport_name);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $histories = $query->latest()->paginate(10)->withQueryString();
        $sports = Sport::orderBy('name', 'asc')->get();

        return view('history', compact('histories', 'sports'));
    }

    public function downloadHistoryPdf(Request $request)
    {
        $query = CalculationHistory::where('user_id', Auth::id());

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

    /**
     * Menghapus entri riwayat tertentu.
     */
    public function destroyHistory(CalculationHistory $history)
    {
        // Pastikan pengguna yang login adalah pemilik riwayat ini
        if (Auth::id() !== $history->user_id) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        $history->delete();

        return back()->with('status', 'Riwayat berhasil dihapus!');
    }
}
