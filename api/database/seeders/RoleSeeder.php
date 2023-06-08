<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('roles')->insert([
            'name' => "Super Admin",
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name' => "Admin",
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name' => "Manager",
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name' => "Supervisor",
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('roles')->insert([
            'name' => "ambassador",
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('user_roles')->insert([
            'role_id' => 1,
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('user_roles')->insert([
            'role_id' => 4,
            'user_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('user_roles')->insert([
            'role_id' => 4,
            'user_id' => 3,
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('user_roles')->insert([
            'role_id' => 4,
            'user_id' => 4,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('user_roles')->insert([
            'role_id' => 4,
            'user_id' => 5,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('user_roles')->insert([
            'role_id' => 5,
            'user_id' => 6,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('user_roles')->insert([
            'role_id' => 5,
            'user_id' => 7,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('user_roles')->insert([
            'role_id' => 5,
            'user_id' => 8,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('user_roles')->insert([
            'role_id' => 5,
            'user_id' => 9,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('user_roles')->insert([
            'role_id' => 5,
            'user_id' => 10,
            'created_at' => \Carbon\Carbon::now()
        ]);





        

    }
}
