<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampaignTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('campaign_types')->insert([
            'name' => "Sales",
        ]);

        DB::table('campaign_types')->insert([
            'name' => "Mapping",
        ]);


        DB::table('campaign_types')->insert([
            'name' => "Merchandising",
        ]);

        DB::table('campaign_types')->insert([
            'name' => "Promotions",
        ]);

        DB::table('campaign_types')->insert([
            'name' => "Activations",
        ]);
    }
}
