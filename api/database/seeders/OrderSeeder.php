<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('orders')->insert([
            'device_time' => '2021-05-26 13:26:18',
            'order_no' => 'slxj2v08',
            'status' => 2,
            'created_date' => '2021-05-26',
            'lng'=> '39.1774773',
            'lat'=> '-6.7871327',
            'user_id'=> 6,
            'campaign_id'=>2,
            'location' => '',
            'delivery_option'=>'delivery',
            'day_option'=>'today',
            'time_option'=>'8:30',
            'customer_id'=> 1,
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('orders')->insert([
            'device_time' => '2021-05-26 13:44:03',
            'order_no' => 'bx8ljb4a',
            'status' => 2,
            'created_date' => '2021-05-26',
            'lng'=> '39.196093',
            'lat'=> '-6.8452534',
            'user_id'=> 6,
            'campaign_id'=>2,
            'location' => '',
            'delivery_option'=>'delivery',
            'day_option'=>'today',
            'time_option'=>'8:30',
            'customer_id'=> 1,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('orders')->insert([
            'device_time' => '2021-05-26 14:02:18',
            'order_no' => 'fjkhagv0',
            'status' => 2,
            'created_date' => '2021-05-27',
            'lng'=> '39.1923182',
            'lat'=> '-6.8446975',
            'user_id'=> 6,
            'campaign_id'=>2,
            'delivery_option'=>'delivery',
            'day_option'=>'today',
            'time_option'=>'8:30',
            'location' => '',
            'customer_id'=> 1,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('orders')->insert([
            'device_time' => '2021-05-26 14:04:14t',
            'order_no' => 'slxj2v08',
            'status' => 2,
            'created_date' => '2021-05-27',
            'lng'=> '39.2039364',
            'lat'=> '-6.8032061',
            'user_id'=> 6,
            'campaign_id'=>1,
            'delivery_option'=>'delivery',
            'day_option'=>'today',
            'time_option'=>'8:30',
            'location' => '',
            'customer_id'=> 1,
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
