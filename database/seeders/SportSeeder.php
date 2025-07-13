<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sport;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Sport::truncate(); // Mengosongkan tabel untuk data baru

        $sports = [
            [
                'name' => 'Berlari (Ringan)',
                'met_value' => 8.0,
                'image_url' => 'images/icons/berlari.png'
            ],
            [
                'name' => 'Berenang (Gaya Bebas)',
                'met_value' => 7.0,
                'image_url' => 'images/icons/berenang.png'
            ],
            [
                'name' => 'Bersepeda (Santai)',
                'met_value' => 6.0,
                'image_url' => 'images/icons/bersepeda.png'
            ],
            [
                'name' => 'Yoga',
                'met_value' => 2.5,
                'image_url' => 'images/icons/yoga.png'
            ],
            [
                'name' => 'Angkat Beban',
                'met_value' => 3.0,
                'image_url' => 'images/icons/angkat-beban.png'
            ],
            [
                'name' => 'Berjalan Kaki (Santai)',
                'met_value' => 3.5,
                'image_url' => 'images/icons/berjalan.png'
            ],
            [
                'name' => 'Basket',
                'met_value' => 8.0,
                'image_url' => 'images/icons/basket.png'
            ],
            [
                'name' => 'Sepak Bola',
                'met_value' => 7.0,
                'image_url' => 'images/icons/sepak-bola.png'
            ],
            [
                'name' => 'Tenis',
                'met_value' => 7.3,
                'image_url' => 'images/icons/tenis.png'
            ],
            [
                'name' => 'Zumba',
                'met_value' => 6.5,
                'image_url' => 'images/icons/zumba.png'
            ],
        ];

        foreach ($sports as $sport) {
            Sport::create($sport);
        }
    }
}
