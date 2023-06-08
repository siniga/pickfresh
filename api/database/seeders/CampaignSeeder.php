<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('campaigns')->insert([
            'name' => 'Sales Campaign',
            'campaign_type_id' => 1,
            'business_id'=> 3
        ]);

        DB::table('campaigns')->insert([
            'name' => 'Ongeza Mauzo Mwanza',
            'campaign_type_id' => 1,
            'business_id'=> 3
        ]);

        DB::table('campaigns')->insert([
            'name' => 'Promotion ya ndovu Kigoma',
            'campaign_type_id' => 1,
            'business_id'=> 3
        ]);

        DB::table('campaigns')->insert([
            'name' => 'Promotion ya Safari nchi nzima',
            'campaign_type_id' => 1,
            'business_id'=> 3
        ]);
    }
}
