<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rawNames = [
            'Mohammad Taufiq Aziz',
            'Prasetyo Laksono',
            'Dede Jamaludin',
            'Lita Lidya',
            'Asep Hermawan',
            'Shildi Andriani',
            'Erian Sukarna Putera',
            'Raenal Apriansyah',
            'Deby Rahmawati',
            'Supriyadi',
            'Wira Mahardika Putra',
            'Triana',
            'Bowo Putranto',
            'Aditya Rahmadian Pamungkas',
            'Selvi Afriandini',
            'Rafli Maulana',
            'Citra Chairunnisa',
            'Sevira Rahmatuti',
            'Aesa Madiyah Walminah',
            'Ratnaningsih',
            'Herlina Apriani',
            'Novan Abdul Humaemi',
            'Abdul Fikri',
            'Shandra Eka Putri',
            'Muhammad Fajar Al Fathin',
            'Meidiyanto Yasin Nugraha Putra',
        ];

        foreach ($rawNames as $raw) {
            // Hapus gelar apa pun yang mengikuti koma, lalu trim spasi
            $name = trim(preg_replace('/,.*$/', '', $raw));

            // Buat user jika belum ada (firstOrCreate agar idempotent)
            User::firstOrCreate(
                ['name' => $name],
                [
                    'password' => Hash::make('12345678'),
                    // 'role' => 'user' // uncomment/set jika ingin menyertakan role
                ]
            );
        }
    }
}
