<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            'id' => 1,
            'name' => 'Good Smile Company',
            'description' => 'Editeur japonais de figurines fondé en 2001 dans la préfecture de Chiba, il est spécialisé dans la production en masse de figurine PVC. Elle est également un distributeur pour un grand nombre de fabricants japonais. Elle est connue pour ses figurines classiques, sa gamme déformée Nendoroid et ses figurines à bas prix Pop Up Parade.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('brands')->insert([
            'id' => 2,
            'name' => 'Kotobukiya',
            'description' => 'Editeur japonais de figurines fondé en 1953 par Jusaburo Shimizu et ses frères, il est spécialisé dans la production de produits originaux et de licences au tant japonaises qu\'américaine. Il est notamment connu pour sa gamme de figurine articulée ArtFX J.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('brands')->insert([
            'id' => 3,
            'name' => 'Bandai',
            'description' => 'Bandai Co., Ltd. est un fabriquant de jouet japonais fondé en 1950. Ils sont très connus pour leur modèle de Gundam, les gunpla. Ils sont également propriétaire de MegaHouse qui proposent des figurines prize à gagner dans les jeux à pince.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('brands')->insert([
            'id' => 4,
            'name' => 'SEGA',
            'description' => 'Sega est un fabriquant de console japonais et de jeux-vidéos. Il propose également des jouets et figurines, les plus connues étant les figurines de type prize, des figurines se gagnant dans les jeux à pinces.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('brands')->insert([
            'id' => 5,
            'name' => 'Aniplex',
            'description' => 'Aniplex Inc. est une société de production et de distribution japonaise. Il propose également à la vente des figurines devenues rapidement populaire pour leur qualité supérieur au marché japonais classique mais avec un prix également plus élevé.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

    }
}
