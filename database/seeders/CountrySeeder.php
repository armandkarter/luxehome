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
            ['name' => 'Spain', 'image' => 'https://images.unsplash.com/photo-1509840841025-9088ba78a826?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'], 
            ['name' => 'Italy', 'image' => 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?q=80&w=1200'],
            ['name' => 'Greece', 'image' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?q=80&w=1200'],
            ['name' => 'Portugal', 'image' => 'https://images.unsplash.com/photo-1555881400-74d7acaacd8b?q=80&w=1200'],
            ['name' => 'Croatia', 'image' => 'https://images.unsplash.com/photo-1504019347908-b45f9b0b8dd5?q=80&w=1200'],
            ['name' => 'Turkey', 'image' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?q=80&w=1200'],
            ['name' => 'Netherlands', 'image' => 'https://images.unsplash.com/photo-1512470876302-972faa2aa9a4?q=80&w=1200'],
            ['name' => 'England', 'image' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?q=80&w=1200'],
            ['name' => 'Estonia', 'image' => 'https://images.unsplash.com/photo-1593103415082-969472658826?q=80&w=1200'],   
            ['name' => 'Germany', 'image' => 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?q=80&w=1200'],
            ['name' => 'China', 'image' => 'https://images.unsplash.com/photo-1508804185872-d7badad00f7d?q=80&w=1200'],
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