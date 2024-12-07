<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //First role will always be the "gerant" role
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'gerant',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        //Second role will always be the "client" role who is assigned by default on new user created
        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'client',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
