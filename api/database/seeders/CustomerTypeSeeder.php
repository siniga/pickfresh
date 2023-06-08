<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class CustomerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('customer_types')->insert([
            'name' => "Duka",
            'alias'=>'duka',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('customer_types')->insert([
            'name' => "Supermarket",
            'alias'=>'supermarket',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('customer_types')->insert([
            'name' => "Min Supermarket",
            'alias'=>'mini-supermarket',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('customer_types')->insert([
            'name' => "Bar",
            'alias'=>'bar',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('customer_types')->insert([
            'name' => "Restaurant",
            'alias'=>'restaurant',
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
