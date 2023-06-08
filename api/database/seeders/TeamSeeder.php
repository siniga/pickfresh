<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('teams')->insert([
            'name' => "Fresh-Daresalaam",
            'campaign_id' => 1,
            'region_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'name' => "TCC-Daresalaam",
            'campaign_id'=> 2,
            'region_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'name' => "TBL-Daressalaam",
            'campaign_id' => 3,
            'region_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'name' => "Vodacom-Daresalaam",
            'campaign_id' => 3,
            'region_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
