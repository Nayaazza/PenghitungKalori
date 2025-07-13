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
        // 1. Cari user target dan siapkan data olahraga
        $user = User::where('email', 'test@example.com')->first();
        if (!$user) {
            $this->command->info('User test@example.com tidak ditemukan, seeder riwayat dibatalkan.');
            return;
        }

        $sports = Sport::all();
        if ($sports->isEmpty()) {
            $this->command->info('Tidak ada data olahraga, seeder riwayat dibatalkan.');
            return;
        }

        // 2. Hapus riwayat lama untuk menghindari duplikasi
        CalculationHistory::where('user_id', $user->id)->delete();
        $this->command->info('Membuat data riwayat yang realistis untuk ' . $user->name . '...');

        // 3. Tentukan parameter "pengguna" yang realistis
        $baseWeight = 72; // Berat badan pengguna relatif stabil
        $favoriteSports = ['Berlari (Ringan)', 'Angkat Beban', 'Bersepeda (Santai)'];
        $lightSports = ['Yoga', 'Berjalan Kaki (Santai)'];

        // 4. Generate data untuk 90 hari ke belakang
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays(90);

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dayOfWeek = $date->dayOfWeek; // 0=Minggu, 1=Senin, ..., 6=Sabtu

            // Tentukan apakah hari ini ada aktivitas olahraga
            $isWorkoutDay = false;
            if (in_array($dayOfWeek, [1, 3, 5])) { // Senin, Rabu, Jumat (Hari Latihan Utama)
                $isWorkoutDay = rand(1, 100) <= 85; // 85% kemungkinan olahraga
            } elseif ($dayOfWeek == 6) { // Sabtu (Latihan akhir pekan)
                $isWorkoutDay = rand(1, 100) <= 60; // 60% kemungkinan olahraga
            } elseif ($dayOfWeek == 0) { // Minggu (Latihan ringan atau istirahat)
                $isWorkoutDay = rand(1, 100) <= 30; // 30% kemungkinan olahraga ringan
            }

            if ($isWorkoutDay) {
                // Pilih olahraga untuk hari ini
                $sportName = $sports->random()->name;
                if ($dayOfWeek == 0) { // Jika hari Minggu, pilih olahraga ringan
                    $sportName = $lightSports[array_rand($lightSports)];
                } elseif (rand(1, 10) <= 7) { // 70% kemungkinan melakukan olahraga favorit
                    $sportName = $favoriteSports[array_rand($favoriteSports)];
                }

                $sport = $sports->firstWhere('name', $sportName);

                // Tentukan durasi yang masuk akal berdasarkan jenis olahraga
                $duration = rand(30, 60); // Durasi default
                if (in_array($sport->name, ['Berlari (Ringan)', 'Bersepeda (Santai)'])) {
                    $duration = rand(25, 45);
                } elseif ($sport->name === 'Angkat Beban') {
                    $duration = rand(45, 75);
                }

                // Sedikit variasi berat badan
                $weight = $baseWeight + (rand(-10, 10) / 10);

                // Rumus perhitungan kalori
                $caloriesBurned = ($sport->met_value * $weight * 3.5) / 200 * $duration;

                // Buat entri di database dengan waktu acak pada hari itu
                $activityTime = $date->copy()->setTime(rand(6, 21), rand(0, 59), rand(0, 59));

                CalculationHistory::create([
                    'user_id' => $user->id,
                    'sport_name' => $sport->name,
                    'duration_minutes' => $duration,
                    'weight_kg' => round($weight, 1),
                    'calories_burned' => round($caloriesBurned, 2),
                    'created_at' => $activityTime,
                    'updated_at' => $activityTime,
                ]);
            }
        }

        $this->command->info('Seeding data riwayat selesai.');
    }
}
