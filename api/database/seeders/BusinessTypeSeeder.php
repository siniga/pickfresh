<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class BusinessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('business_types')->insert([
            'name' => "Construction"
        ]);
        DB::table('business_types')->insert([
            'name' => "Tobacco"
        ]);
        DB::table('business_types')->insert([
            'name' => "Finance"
        ]);
        DB::table('business_types')->insert([
            'name' => "Telcom"
        ]);
        
        DB::table('business_types')->insert([
            'name' => "Food"
        ]);

        DB::table('business_types')->insert([
            'name' => "Bevarages"
        ]);
    }
}
