<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sport;

class SportSeeder extends Seeder
{
    public function run(): void
    {
        Sport::truncate(); // Mengosongkan tabel untuk data baru

        $sports = [
            [
                'name' => 'Berlari (5 mph)',
                'met_value' => 8.3,
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12.75 4.5a.75.75 0 01.75.75v8.25a.75.75 0 01-1.5 0V5.25a.75.75 0 01.75-.75zM12.75 18a.75.75 0 100-1.5.75.75 0 000 1.5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6.375 4.5a.75.75 0 01.75.75v12a.75.75 0 01-1.5 0v-12a.75.75 0 01.75-.75zM9.375 4.5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0V5.25a.75.75 0 01.75-.75z" />'
            ],
            [
                'name' => 'Berenang (Gaya Bebas)',
                'met_value' => 7.0,
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0zm-2.25-1.5a.375.375 0 00-.499.052l-2.25 3.375a.375.375 0 00.548.423l2.25-1.538a.375.375 0 00-.05-.51z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" />'
            ],
            [
                'name' => 'Bersepeda (10-12 mph)',
                'met_value' => 6.0,
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM11.25 6H12.75a1.5 1.5 0 010 3H11.25z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 12.75L12 15" />'
            ],
            [
                'name' => 'Yoga',
                'met_value' => 2.5,
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v.01a6 6 0 01-5.84-7.38l5.84-11.68 5.84 11.68z" />'
            ],
            [
                'name' => 'Angkat Beban',
                'met_value' => 3.0,
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 3.75h15M4.5 12h15m-7.5-8.25v16.5" />'
            ],
            [
                'name' => 'Berjalan Kaki (3 mph)',
                'met_value' => 3.5,
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75l-3.75 3.75-3.75-3.75" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 12.75v-6" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-2.25" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 18.75h6" />'
            ],
        ];

        foreach ($sports as $sport) {
            Sport::create($sport);
        }
    }
}
