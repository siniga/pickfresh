<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('categories')->insert([
            'name' => 'Mboga',
            'url' => '',
            'business_id'=> 1
        ]);

        DB::table('categories')->insert([
            'name' => "Nyama",
            'url' => '',
            'business_id'=> 1
        ]);

        DB::table('categories')->insert([
            'name' => "Vinywaji (bia)",
            'url' => '',
            'business_id'=> 1
        ]);

        DB::table('categories')->insert([
            'name' => "Sigara",
            'url' => '',
            'business_id'=> 2
        ]);
        
    }
}
