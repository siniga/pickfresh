<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('units')->insert([
            'name' => "Bag",

        ]);

        DB::table('units')->insert([
            'name' => "Carton",

        ]);

        DB::table('units')->insert([
            'name' => "Sack",

        ]);

        DB::table('units')->insert([
            'name' => "Crate",

        ]);

        DB::table('units')->insert([
            'name' => "Box",

        ]);

        DB::table('units')->insert([
            'name' => "Bottle",

        ]);

        DB::table('units')->insert([
            'name' => "Fungu",

        ]);
    }
}
