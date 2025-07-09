<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sport;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data awal untuk jenis olahraga (FR01)
        $sports = [
            [
                'name' => 'Berlari (5 mph)',
                'met_value' => 8.3,
                'image_url' => 'https://placehold.co/600x400/a3e635/3f6212?text=Berlari'
            ],
            [
                'name' => 'Berenang (Gaya Bebas)',
                'met_value' => 7.0,
                'image_url' => 'https://placehold.co/600x400/67e8f9/0e7490?text=Berenang'
            ],
            [
                'name' => 'Bersepeda (10-12 mph)',
                'met_value' => 6.0,
                'image_url' => 'https://placehold.co/600x400/fde047/854d0e?text=Bersepeda'
            ],
            [
                'name' => 'Yoga',
                'met_value' => 2.5,
                'image_url' => 'https://placehold.co/600x400/c4b5fd/4c1d95?text=Yoga'
            ],
            [
                'name' => 'Angkat Beban',
                'met_value' => 3.0,
                'image_url' => 'https://placehold.co/600x400/fca5a5/991b1b?text=Angkat+Beban'
            ],
            [
                'name' => 'Berjalan Kaki (3 mph)',
                'met_value' => 3.5,
                'image_url' => 'https://placehold.co/600x400/fdba74/9a3412?text=Jalan+Kaki'
            ],
        ];

        foreach ($sports as $sport) {
            Sport::create($sport);
        }
    }
}
