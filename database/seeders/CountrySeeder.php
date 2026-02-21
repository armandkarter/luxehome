<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $countries = [
            ['name' => 'France', 'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?q=80&w=1200'],
            ['name' => 'Espagne', 'image' => 'https://images.unsplash.com/photo-1543783232-47502cdd839a?q=80&w=1200'],
            ['name' => 'Italie', 'image' => 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?q=80&w=1200'],
            ['name' => 'Grèce', 'image' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?q=80&w=1200'],
            ['name' => 'Portugal', 'image' => 'https://images.unsplash.com/photo-1555881400-74d7acaacd8b?q=80&w=1200'],
            ['name' => 'Croatie', 'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?q=80&w=1200'],
            ['name' => 'Turquie', 'image' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?q=80&w=1200'],
            ['name' => 'Pays Bas', 'image' => 'https://images.unsplash.com/photo-1512470876302-972faa2aa9a4?q=80&w=1200'],
            ['name' => 'Angleterre', 'image' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?q=80&w=1200'],
            ['name' => 'Estonie', 'image' => 'https://images.unsplash.com/photo-1548834181-110bbd4ca490?q=80&w=1200'],
            ['name' => 'Allemagne', 'image' => 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?q=80&w=1200'],
            ['name' => 'Chine', 'image' => 'https://images.unsplash.com/photo-1508804185872-d7badad00f7d?q=80&w=1200'],
        ];

        foreach ($countries as $country) {
            DB::table('countries')->updateOrInsert(
                ['name' => $country['name']],
                [
                    'image_path' => $country['image'],
                    'slug'       => Str::slug($country['name']),
                    'is_active'  => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
