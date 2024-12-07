<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'id' => 1,
            'name' => 'Prépeinte',
            'description' => 'Majorité des figurines, il s\'agit des figurines déjà peinte et en général complètement montée, sauf la base, prête à être exposée une fois sortie de la boite.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('categories')->insert([
            'id' => 2,
            'name' => 'Action/Poupée',
            'description' => 'Ces figurines sont la deuxième catégorie la plus populaire, il s\'agit de figurine articulée souvent de plus petite taille que les prépeintes, elles sont souvent accompagnée de plusieurs accessoires ou partie qui peuvent être interchargées.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('categories')->insert([
            'id' => 3,
            'name' => 'Collectionnable',
            'description' => 'Figurines plus rare, il s\'agit de figurine vendues uniquement lors d\'évenements et qui ne sont pas vendues en masses.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('categories')->insert([
            'id' => 4,
            'name' => 'Model Kit',
            'description' => 'Figurines prépeintes fournies démontée, l\'acheteur doit aller assemblée l\'ensemble du kit afin d\'exposer la figurine dans sa collection.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('categories')->insert([
            'id' => 5,
            'name' => 'Garage Kit',
            'description' => 'Figurines fournies sans peinture, l\'acheteur doit peinte de lui même la figurine, elles sont parfois en pièce détachée, parfois déjà assemblée.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
