<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Sport;
use App\Models\CalculationHistory;
use Carbon\Carbon;

class CalculationHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // 1. Cari user yang akan kita isi datanya
        $user = User::where('email', 'test@example.com')->first();

        // Jika user tidak ditemukan, hentikan seeder
        if (!$user) {
            $this->command->info('User test@example.com tidak ditemukan. Seeder riwayat dibatalkan.');
            return;
        }

        // 2. Ambil semua data olahraga yang tersedia
        $sports = Sport::all();

        if ($sports->isEmpty()) {
            $this->command->info('Tidak ada data olahraga. Seeder riwayat dibatalkan.');
            return;
        }

        // 3. Hapus riwayat lama milik user ini untuk menghindari duplikat
        CalculationHistory::where('user_id', $user->id)->delete();

        // 4. Generate data riwayat untuk 60 hari ke belakang
        $this->command->info('Membuat data riwayat untuk ' . $user->name . '...');

        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays(60);

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Buat 0 sampai 3 entri acak per hari
            $entryCount = rand(0, 3);

            for ($i = 0; $i < $entryCount; $i++) {
                $sport = $sports->random();
                $duration = rand(15, 120); // Durasi antara 15 menit hingga 2 jam
                $weight = rand(55, 85); // Berat badan antara 55kg hingga 85kg

                // Rumus perhitungan kalori
                $caloriesBurned = ($sport->met_value * $weight * 3.5) / 200 * $duration;

                CalculationHistory::create([
                    'user_id' => $user->id,
                    'sport_name' => $sport->name,
                    'duration_minutes' => $duration,
                    'weight_kg' => $weight,
                    'calories_burned' => round($caloriesBurned, 2),
                    'created_at' => $date, // Gunakan tanggal dari loop
                    'updated_at' => $date,
                ]);
            }
        }

        $this->command->info('Seeding data riwayat selesai.');
    }
}
