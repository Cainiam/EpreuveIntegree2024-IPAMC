<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TvaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Adding classical belgium TVA even if technically only 21% will apply
     * Source des taux : site belgium.be et myfid.be
     */
    public function run(): void
    {
        //TVA R03
        DB::table('tvas')->insert([
            'id' => 1,
            'name' => 'standard',
            'purcent' => 0.21,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        //TVA R02
        DB::table('tvas')->insert([
            'id' => 2,
            'name' => 'intermediaire',
            'purcent' => 0.12,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        //TVA R01
        DB::table('tvas')->insert([
            'id' => 3,
            'name' => 'reduit',
            'purcent' => 0.06,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        //TVA R00
        DB::table('tvas')->insert([
            'id' => 4,
            'name' => 'zero',
            'purcent' => 0.0,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
