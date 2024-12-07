<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('scales')->insert([
            'id' => 1,
            'name' => '1/7',
            'description' => 'La taille la plus commune de figurines est le 1/7ème, c\'est à dire que la taille totale de la personne representée est divisée par 7.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('scales')->insert([
            'id' => 2,
            'name' => '1/6',
            'description' => 'Taille de figurine commune, le 1/6è est souvent utilisé lorsque le personnage est petit.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('scales')->insert([
            'id' => 3,
            'name' => '1/4',
            'description' => 'Taille de figurine commune, le 1/4 est souvent utilisé pour réalisé des figurines de taille plus importante.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('scales')->insert([
            'id' => 4,
            'name' => 'Non-scale',
            'description' => 'Cela veut dire que l\'échelle du personnage n\'est pas respecté, cela est souvent le cas pour les figurines articulées.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('scales')->insert([
            'id' => 5,
            'name' => 'Miniature',
            'description' => 'A utilisé pour les figurines de Gundam ou autres machines dont la taille peut varié entre le 1/32 et le 1/100è',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
