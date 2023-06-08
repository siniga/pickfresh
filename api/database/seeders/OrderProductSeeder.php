<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class OrderProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('order_products')->insert([
            'order_id' => 1,
            'product_id'=> 1,
            'sku_id' => 2,
            'unit_id' => 1,
            'total_quantity' => 1,
            'total_amount' => "330000",
         ]);

         DB::table('order_products')->insert([
            'order_id' => 1,
            'product_id'=> 2,
            'sku_id' => 2,
            'unit_id' => 1,
            'total_quantity' => 1,
            'total_amount' => "5688900",
         ]);
         DB::table('order_products')->insert([
            'order_id' => 1,
            'product_id'=> 3,
            'sku_id' => 2,
            'unit_id' => 1,
            'total_quantity' => 1,
            'total_amount' =>"34400",
         ]);

         DB::table('order_products')->insert([
            'order_id' => 2,
            'product_id'=> 4,
            'sku_id' => 2,
            'unit_id' => 1,
            'total_quantity' => 1,
            'total_amount' =>"12400",
         ]);
    }
}
