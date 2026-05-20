<?php

namespace Database\Seeders;

use App\Models\Actor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Actor::create([
            'name' => 'Matthew McConaughey',
            'birth_year' => 1969,
        ]);

        Actor::create([
            'name' => 'Anne Hathaway',
            'birth_year' => 1982,
        ]);

        Actor::create([
            'name' => 'Margot Robbie',
            'birth_year' => 1990,
        ]);

        Actor::create([
            'name' => 'Ryan Gosling',
            'birth_year' => 1980,
        ]);

        Actor::create([
            'name' => 'Song Kang-ho',
            'birth_year' => 1967,
        ]);
    }
}
