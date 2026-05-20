<?php

namespace Database\Seeders;

use App\Models\Director;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Director::create([
            'name' => 'Christopher Nolan',
            'country' => 'Reino Unido',
        ]);

        Director::create([
            'name' => 'Greta Gerwig',
            'country' => 'Estados Unidos',
        ]);

        Director::create([
            'name' => 'Bong Joon-ho',
            'country' => 'Corea del Sur',
        ]);
    }
}
