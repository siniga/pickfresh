<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('products')->insert([
            'name' => "Safari",
            'cost' => '1500',
            'price' => '1800',
            'img' => 'uploads/YIwhJmacSQmN2lPS95NKXXSWcoQ6KAQ4taPYMWgo.png',
            'stock' => 20,
            'category_id' => 3
        ]);

        DB::table('products')->insert([
            'name' => "Kilimanjaro",
            'cost' => '1500',
            'price' => '1800',
            'img' => 'uploads/8Qs0UQvgWvqNhHQoOuTeu3i3IaEmphnVHDoSiQMM.png',
            'stock' => 20,
            'category_id' => 3

        ]);

        DB::table('products')->insert([
            'name' => "Castle Light",
            'cost' => '1500',
            'price' => '1800',
            'img' => 'uploads/tTFfmzy1j98RqM7NiDU1omxbIupxUtP3rUhq8ML8.png',
            'stock' => 20,
            'category_id' => 3

        ]);

        DB::table('products')->insert([
            'name' => "Karoti",
            'cost' => '1500',
            'price' => '1800',
            'img' => 'uploads/JR2NMMAz06X6wx4Q33LaamjVosBzXIKEsm5Ow3UG.png',
            'stock' => 20,
            'category_id' => 1

        ]);

        DB::table('products')->insert([
            'name' => "Embassy",
            'cost' => '100',
            'price' => '180',
            'img' => 'uploads/JR2NMMAz06X6wx4Q33LaamjVosBzXIKEsm5Ow3UG.png',
            'stock' => 20,
            'category_id' => 4

        ]);

        DB::table('products')->insert([
            'name' => "SM",
            'cost' => '80',
            'price' => '100',
            'img' => 'uploads/JR2NMMAz06X6wx4Q33LaamjVosBzXIKEsm5Ow3UG.png',
            'stock' => 20,
            'category_id' => 4

        ]);

        DB::table('products')->insert([
            'name' => "Portsman",
            'cost' => '100',
            'price' => '200',
            'img' => 'uploads/JR2NMMAz06X6wx4Q33LaamjVosBzXIKEsm5Ow3UG.png',
            'stock' => 20,
            'category_id' => 4

        ]);

        DB::table('products')->insert([
            'name' => "Winston",
            'cost' => '100',
            'price' => '150',
            'img' => 'uploads/JR2NMMAz06X6wx4Q33LaamjVosBzXIKEsm5Ow3UG.png',
            'stock' => 20,
            'category_id' => 4

        ]);


    }
}
