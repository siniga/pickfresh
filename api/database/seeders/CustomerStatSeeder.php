<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerStatSeeder extends Seeder {
    /**
    * Run the database seeds.
    *
    * @return void
    */

    public function run() {
        DB::table( 'customer_stats' )->insert( [
            'num_sale' => 1,
            'num_visit'=> 1,
            'amount'=> '14000',
            'customer_id'=> 1,
            'campaign_id' => 1,
            'user_visit_lat'=>'0.00',
            'user_visit_lng' => '0.00',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()
        ] );

        DB::table( 'customer_stats' )->insert( [
            'num_sale' => 1,
            'num_visit'=> 1,
            'amount'=> '10000',
            'customer_id'=> 2,
            'campaign_id' => 1,
            'user_visit_lat'=>'0.00',
            'user_visit_lng' => '0.00',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()
        ] );

        DB::table( 'customer_stats' )->insert( [
            'num_sale' => 1,
            'num_visit'=> 1,
            'amount'=> '5000',
            'customer_id'=> 2,
            'campaign_id' => 1,
            'user_visit_lat'=>'0.00',
            'user_visit_lng' => '0.00',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()
        ] );

        DB::table( 'customer_stats' )->insert( [
            'num_sale' => 0,
            'num_visit'=> 1,
            'amount'=> '11000',
            'customer_id'=> 1,
            'campaign_id' => 1,
            'user_visit_lat'=>'0.00',
            'user_visit_lng' => '0.00',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()
        ] );

        DB::table( 'customer_stats' )->insert( [
            'num_sale' => 0,
            'num_visit'=> 1,
            'amount'=> '20000',
            'customer_id'=> 1,
            'campaign_id' => 1,
            'user_visit_lat'=>'0.00',
            'user_visit_lng' => '0.00',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()
        ] );

        DB::table( 'customer_stats' )->insert( [
            'num_sale' => 1,
            'num_visit'=> 1,
            'amount'=> '90000',
            'customer_id'=> 1,
            'campaign_id' => 2,
            'user_visit_lat'=>'0.00',
            'user_visit_lng' => '0.00',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()
        ] );

    }
}
