<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            "name" =>  "admin",
            "role" => "admin",
            "email" => "admin@gmail.com",
            "password" => Hash::make('admin123')
        ]);
        
        User::create([
            "name" =>  "bank",
            "role" => "bank",
            "email" => "bank@gmail.com",
            "password" => Hash::make('bank123')
        ]);

        User::create([
        "name" =>  "siswa",
        "role" => "siswa",
        "email" => "siswa@gmail.com",
        "password" => Hash::make('siswa123')
        ]);
    }
}
