<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActorMovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $interestellar = Movie::find(1);
        $barbie = Movie::find(2);                                                     
        $parasite = Movie::find(3);

        $interestellar->actors()->attach(1, ['role' => 'Cooper']);
        $interestellar->actors()->attach(2, ['role' => 'Brand']);

        $barbie->actors()->attach(3, ['role' => 'Barbie']);
        $barbie->actors()->attach(4, ['role' => 'Ken']);

        $parasite->actors()->attach(5, ['role' => 'Kim Ki-taek']);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
    }
}
