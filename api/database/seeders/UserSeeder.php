<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => "Khamis peter",
            'email'=>"admin@mail.com",
            "created_date"=>\Carbon\Carbon::now()->format('Y-m-d'),
            'password'=>bcrypt(123456),
            'phone'=> "0768632087",
            // 'color'=>'#D48C70'
        ]);

        DB::table('users')->insert([
            'name' => "John Olvier",
            'email'=>"jn@mail.com",
            "created_date"=>\Carbon\Carbon::now()->format('Y-m-d'),
            'password'=>bcrypt(123456),
            'phone'=> "0002",
            // 'color'=>'#67595E'
        ]);

        DB::table('users')->insert([
            'name' => "Sin yang sam",
            'email'=>"ak@mail.com",
            "created_date"=>\Carbon\Carbon::now()->format('Y-m-d'),
            'password'=>bcrypt(123456),
            'phone'=> "0003",
            // 'color'=>'#2E8BC0'
        ]);

        DB::table('users')->insert([
            'name' => "Salim Isaya",
            'email'=>"salisua@mail.com",
            "created_date"=>\Carbon\Carbon::now()->format('Y-m-d'),
            'password'=>bcrypt(123456),
            'phone'=> "0004",
            // 'color'=>'#BC96CA'
        ]);


        DB::table('users')->insert([
            'name' => "Musa silamon",
            'email'=>"msi@mail.com",
            "created_date"=>\Carbon\Carbon::now()->format('Y-m-d'),
            'password'=>bcrypt(123456),
            'phone'=> "0005",
            // 'color'=>'#804026'
        ]);

        DB::table('users')->insert([
            'name' => "Sarah Salawi",
            'email'=>"sar@mail.com",
            "created_date"=>\Carbon\Carbon::now()->format('Y-m-d'),
            'password'=>bcrypt(123456),
            'phone'=> "0006",
            // 'color'=>'#56d35b'
        ]);

        DB::table('users')->insert([
            'name' => "James Kwame",
            'email'=>"jak@mail.com",
            "created_date"=>\Carbon\Carbon::now()->format('Y-m-d'),
            'password'=>bcrypt(123456),
            'phone'=> "0007",
            // 'color'=>'#0000FF'
        ]);

        DB::table('users')->insert([
            'name' => "Musa singa",
            'email'=>"musa@mail.com",
            "created_date"=>\Carbon\Carbon::now()->format('Y-m-d'),
            'password'=>bcrypt(123456),
            'phone'=> "0008",
            // 'color' => '#F51720'
        ]);

        DB::table('users')->insert([
            'name' => "Alina mahali",
            'email'=>"alia@mail.com",
            "created_date"=>\Carbon\Carbon::now()->format('Y-m-d'),
            'password'=>bcrypt(123456),
            'phone'=> "0009",
            // 'color'=>"#FA26A0"
        ]);

        DB::table('users')->insert([
            'name' => "Salama john",
            'email'=>"sla@mail.com",
            "created_date"=>\Carbon\Carbon::now()->format('Y-m-d'),
            'password'=>bcrypt(123456),
            'phone'=> "0762882288",
            // 'color'=>"#2FF3E0"
        ]);

    }
}
