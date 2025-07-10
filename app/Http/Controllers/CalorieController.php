<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sport;
use App\Models\CalculationHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $stats = CalculationHistory::where('user_id', $user->id)->select(DB::raw('SUM(calories_burned) as total_calories'), DB::raw('SUM(duration_minutes) as total_duration'))->first();
        $recentHistories = CalculationHistory::where('user_id', $user->id)->latest()->take(3)->get();
        return view('dashboard', ['user' => $user, 'stats' => $stats, 'recentHistories' => $recentHistories,]);
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

        $histories = $query->latest()->get();

        // Ambil daftar olahraga unik untuk dropdown filter
        $sports = Sport::orderBy('name')->get();

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