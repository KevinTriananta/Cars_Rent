<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat Admin
        \App\Models\User::create([
            'name' => 'Admin Rental',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Buat User
        \App\Models\User::create([
            'name' => 'User Rental',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Buat Mobil
        Car::create([
            'name' => 'Toyota Avanza',
            'brand' => 'Toyota',
            'price_per_day' => 350000,
            'status' => 'available',
        ]);

        Car::create([
            'name' => 'Honda Civic',
            'brand' => 'Honda',
            'price_per_day' => 500000,
            'status' => 'available',
        ]);

        Car::create([
            'name' => 'Daihatsu Xenia',
            'brand' => 'Daihatsu',
            'price_per_day' => 300000,
            'status' => 'available',
        ]);

        Car::create([
            'name' => 'Mitsubishi Pajero',
            'brand' => 'Mitsubishi',
            'price_per_day' => 750000,
            'status' => 'available',
        ]);

        Car::create([
            'name' => 'Toyota Innova',
            'brand' => 'Toyota',
            'price_per_day' => 550000,
            'status' => 'rented',
        ]);
    }
}
