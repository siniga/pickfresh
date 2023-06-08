<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TeamUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('team_users')->insert([
            'team_id' => 3,
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('team_users')->insert([
            'team_id' => 2,
            'user_id' => 9,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('team_users')->insert([
            'team_id' => 2,
            'user_id' => 7,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('team_users')->insert([
            'team_id' => 1,
            'user_id' => 8,
            'created_at' => \Carbon\Carbon::now()
        ]);


    }
}
