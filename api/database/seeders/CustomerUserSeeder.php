<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('customer_users')->insert([
            'user_id' => 1,
            'customer_id'=> 3,
               'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('customer_users')->insert([
            'user_id' => 1,
            'customer_id'=> 4,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('customer_users')->insert([
            'user_id' => 1,
            'customer_id'=> 5,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('customer_users')->insert([
            'user_id' => 1,
            'customer_id'=> 6,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('customer_users')->insert([
            'user_id' => 3,
            'customer_id'=> 7,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('customer_users')->insert([
            'user_id' => 3,
            'customer_id'=> 8,
            'created_at' => \Carbon\Carbon::now()
        ]);

    
    }
}
