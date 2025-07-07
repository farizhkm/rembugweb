<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Idea;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Menetapkan user_id ke ID 1 secara manual (karena tidak ada model User)
        $userId = 1; // Ganti dengan user_id yang valid

        // Menambahkan ide dengan nilai untuk kolom description
        Idea::create([
            'title' => 'Ide Pertama',
            'category' => 'Kategori 1',
            'description' => 'Deskripsi untuk ide pertama',  // Berikan nilai untuk description
            'user_id' => $userId,
        ]);

        Idea::create([
            'title' => 'Ide Kedua',
            'category' => 'Kategori 2',
            'description' => 'Deskripsi untuk ide kedua',  // Berikan nilai untuk description
            'user_id' => $userId,
        ]);

        Idea::create([
            'title' => 'Ide Ketiga',
            'category' => 'Kategori 3',
            'description' => 'Deskripsi untuk ide ketiga',  // Berikan nilai untuk description
            'user_id' => $userId,
        ]);
    }
}
