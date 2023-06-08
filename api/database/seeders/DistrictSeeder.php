<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('districts')->insert([
            'name' => "Kinondoni",
            'region_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('districts')->insert([
            'name' => "Kigamboni",
            'region_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('districts')->insert([
            'name' => "Ubungo",
            'region_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('districts')->insert([
            'name' => "Ilala",
            'region_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('districts')->insert([
            'name' => "Temeke",
            'region_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
