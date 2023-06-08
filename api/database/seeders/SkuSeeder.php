<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SkuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('skus')->insert([
            'name' => "fungu",

        ]);

        DB::table('skus')->insert([
            'name' => "nusu kilo",

        ]);

        DB::table('skus')->insert([
            'name' => "kilo",

        ]);

        DB::table('skus')->insert([
            'name' => "50KG",

        ]);

        DB::table('skus')->insert([
            'name' => "100KG",

        ]);

        DB::table('skus')->insert([
            'name' => "300ML",

        ]);

        DB::table('skus')->insert([
            'name' => "330ML",

        ]);

        DB::table('skus')->insert([
            'name' => "500ML",

        ]);


        DB::table('skus')->insert([
            'name' => "1L",

        ]);

        DB::table('skus')->insert([
            'name' => "5L",

        ]);

        DB::table('skus')->insert([
            'name' => "Fungu",

        ]);

    }
}
