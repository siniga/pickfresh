<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ProductUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('product_units')->insert([
            'product_id' => 1,
            'unit_id' => 3
        ]);

        DB::table('product_units')->insert([
            'product_id' => 1,
            'unit_id' => 4
        ]);

        DB::table('product_units')->insert([
            'product_id' => 1,
            'unit_id' => 7
        ]);


        DB::table('product_units')->insert([
            'product_id' => 2,
            'unit_id' => 3
        ]);

        DB::table('product_units')->insert([
            'product_id' => 2,
            'unit_id' => 4
        ]);

        DB::table('product_units')->insert([
            'product_id' => 2,
            'unit_id' => 7
        ]);

        DB::table('product_units')->insert([
            'product_id' => 3,
            'unit_id' => 3
        ]);

        DB::table('product_units')->insert([
            'product_id' => 3,
            'unit_id' => 4
        ]);

        DB::table('product_units')->insert([
            'product_id' => 3,
            'unit_id' => 7
        ]);

        DB::table('product_units')->insert([
            'product_id' => 4,
            'unit_id' => 3
        ]);

        DB::table('product_units')->insert([
            'product_id' => 4,
            'unit_id' => 4
        ]);

        DB::table('product_units')->insert([
            'product_id' => 4,
            'unit_id' => 7
        ]);
    }
}
