<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ProductSkuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('product_skus')->insert([
            'product_id' => 1,
            'sku_id' => 1
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 1,
            'sku_id' => 2
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 1,
            'sku_id' => 3
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 1,
            'sku_id' => 4
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 1,
            'sku_id' => 5
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 2,
            'sku_id' => 1
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 2,
            'sku_id' => 2
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 2,
            'sku_id' => 3
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 2,
            'sku_id' => 4
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 2,
            'sku_id' => 5
        ]);


        DB::table('product_skus')->insert([
            'product_id' => 3,
            'sku_id' => 1
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 3,
            'sku_id' => 2
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 3,
            'sku_id' => 4
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 3,
            'sku_id' => 5
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 4,
            'sku_id' => 1
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 4,
            'sku_id' => 2
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 4,
            'sku_id' => 3
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 4,
            'sku_id' => 4
        ]);

        DB::table('product_skus')->insert([
            'product_id' => 4,
            'sku_id' => 5
        ]);

   
    }
}
