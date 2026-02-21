<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // Commande : php artisan make:seeder UserSeeder

public function run()
{
    \App\Models\User::create([
        'name' => 'Admin LuxeHabitat',
        'email' => 'armandkarter@gmail.com',
        'password' => Hash::make('Devaleur02@'),
        'email_verified_at' => now(),
    ]);
}
}
