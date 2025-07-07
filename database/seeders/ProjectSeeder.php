<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        Project::create([
            'title' => 'Proyek Demo 1',
            'description' => 'Deskripsi proyek demo pertama.',
            'status' => 'ongoing',
            'user_id' => 1, // Ganti dengan ID pengguna yang valid
        ]);

        Project::create([
            'title' => 'Proyek Demo 2',
            'description' => 'Deskripsi proyek demo kedua.',
            'status' => 'completed',
            'user_id' => 1, // Ganti dengan ID pengguna yang valid
        ]);
    }
}