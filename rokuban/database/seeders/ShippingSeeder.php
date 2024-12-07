<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shippings')->insert([
            'id' => 1,
            'shippingcompany_id' => 1,
            'name' => 'Bpost Standard',
            'description' => 'Livraison standard Bpost avec tracker et garantie jusqu\'à 500€ de valeur en 4-5 jours.',
            'price' => 9.95,
            'isVisible' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('shippings')->insert([
            'id' => 2,
            'shippingcompany_id' => 2,
            'name' => 'UPS Standard',
            'description' => 'Livraison standard UPS avec tracker et garantie "prix du colis" en 3-4 jours.',
            'price' => 12.50,
            'isVisible' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('shippings')->insert([
            'id' => 3,
            'shippingcompany_id' => 2,
            'name' => 'UPS Express',
            'description' => 'Livraison express UPS avec tracker et garantie "prix du colis" en 1 jour.',
            'price' => 15.00,
            'isVisible' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('shippings')->insert([
            'id' => 4,
            'shippingcompany_id' => 3,
            'name' => 'Mondial Relay Domicile',
            'description' => 'Livraison standard par PostNL garantie jusqu\'à 500€. Livré en 3-4 jours.',
            'price' => 8.10,
            'isVisible' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('shippings')->insert([
            'id' => 5,
            'shippingcompany_id' => 4,
            'name' => 'NLPost Standard',
            'description' => 'Livraison standard par Mondial Relay avec tracker jusqu\'à votre domicile. Le colis est garanti jusqu\'à 500€ et livré en 3-4 jours.',
            'price' => 12.00,
            'isVisible' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
