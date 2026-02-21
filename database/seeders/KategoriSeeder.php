<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar Kategori "Zaman Now"
        $kategori = [
            ['name' => 'Fiksi'],
            ['name' => 'Non-Fiksi'],
            ['name' => 'Self Improvement'],
            ['name' => 'Teknologi & Coding'],
            ['name' => 'Horor & Misteri'],
            ['name' => 'Hobi & Skill'],
            ['name' => 'Bisnis & Keuangan'], // Bonus biar lengkap
        ];

        // Masukkan data sekaligus dengan timestamps otomatis
        foreach ($kategori as $data) {
            DB::table('categories')->insert([
                'name' => $data['name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
