<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Movie::create([
            'title' => 'Interstellar',
            'year' => 2014,
            'director_id' => 1,
        ]);

        Movie::create([
            'title' => 'Barbie',
            'year' => 2023,
            'director_id' => 2,
        ]);

        Movie::create([
            'title' => 'Parasite',
            'year' => 2019,
            'director_id' => 3,
        ]);
    }
}
