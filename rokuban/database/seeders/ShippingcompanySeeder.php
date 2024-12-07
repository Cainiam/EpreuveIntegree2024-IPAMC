<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingcompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shippingcompanies')->insert([
            'id' => 1,
            'name' => 'Bpost',
            'description' => 'Entreprise publique postale belge qui s\'occupe de la distribution du courrier ainsi que de colis.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        
        DB::table('shippingcompanies')->insert([
            'id' => 2,
            'name' => 'UPS',
            'description' => 'Entreprise postale américaine parmis les plus connues, elle a été fondée en 1907.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('shippingcompanies')->insert([
            'id' => 3,
            'name' => 'PostNL',
            'description' => 'Entreprise néerlandaises de livraison de colis fondée en 2011.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('shippingcompanies')->insert([
            'id' => 4,
            'name' => 'DHL',
            'description' => 'Entreprise française de livraison colis notamment connue pour ses points-relais fondée en 1992.',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
