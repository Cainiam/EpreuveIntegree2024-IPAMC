<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GerantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'gerant1',
            'email' => 'gerant1@rokuban.be',
            'email_verified_at' => \Carbon\Carbon::now(),
            'password' => Hash::make('qyvf27rn447u5k59c82f'), //randomly generate using an online generator
            'first_name' => null,
            'last_name' => null,
            'address_line_1' => null,
            'address_line_2' => null,
            'postal_code' => null,
            'city' => null,
            'role_id' => 1,
            'isActive' => 1,
            'remember_token' => null,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'gerant2',
            'email' => 'gerant2@rokuban.be',
            'email_verified_at' => \Carbon\Carbon::now(),
            'password' => Hash::make('8u9t6i3ui2cr8m686gv3'), //randomly generate using an online generator
            'first_name' => null,
            'last_name' => null,
            'address_line_1' => null,
            'address_line_2' => null,
            'postal_code' => null,
            'city' => null,
            'role_id' => 1,
            'isActive' => 1,
            'remember_token' => null,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
