<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // Commande : php artisan make:seeder CategorySeeder

public function run()
{
    $categories = [
        ['name' => 'Villas de Luxe', 'slug' => 'villas-de-luxe', 'icon' => 'fa-house-chimney-window'],
        ['name' => 'Appartements', 'slug' => 'appartements', 'icon' => 'fa-building'],
        ['name' => 'Hôtels & Suites', 'slug' => 'hotels-suites', 'icon' => 'fa-hotel'],
        ['name' => 'Lofts Modernes', 'slug' => 'lofts-modernes', 'icon' => 'fa-couch'],
    ];

    foreach ($categories as $cat) {
        \App\Models\Category::create($cat);
    }
}
}
