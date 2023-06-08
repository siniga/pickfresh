<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('businesses')->insert([
            'name' => "Fresh",
            'business_type_id' => 5
        ]);

        DB::table('businesses')->insert([
            'name' => "TCC",
            'business_type_id' =>2
        ]);

        DB::table('businesses')->insert([
            'name' => "TBL",
            'business_type_id' => 6
        ]);

        DB::table('businesses')->insert([
            'name' => "Vodacom",
            'business_type_id' => 4
        ]);
    }
}
