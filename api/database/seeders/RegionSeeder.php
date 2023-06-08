<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('regions')->insert([
            'name' => "Arusha",
            'lat' => '-3.391972',
            'lng'=>'36.699869',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Dar es Salaam",
            'lat' => '-6.785618',
            'lng'=>'39.207209',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Dodoma",
            'lat' => '-6.153487',
            'lng'=>'35.750145',
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('regions')->insert([
            'name' => "Geita",
            'lat' => '-2.856453',
            'lng'=>'32.190047',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Iringa",
            'lat' => '-7.766801',
            'lng'=>'35.693838',
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('regions')->insert([
            'name' => "Bukoba",
            'lat' => '-1.330339',
            'lng'=>'31.809336',
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('regions')->insert([
            'name' => "Katavi",
            'lat' => '-6.472742',
            'lng'=>'31.253885',
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('regions')->insert([
            'name' => "Kigoma",
            'lat' => '-4.879411',
            'lng'=>'29.651752',
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('regions')->insert([
            'name' => "Kilimanjaro",
            'lat' => '-3.662568',
            'lng'=>'37.713548',
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('regions')->insert([
            'name' => "Lindi",
            'lat' => '-9.995358',
            'lng'=>'39.706751',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Manyara",
            'lat' => '-4.586654',
            'lng'=>'36.936239',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Mara",
            'lat' => '-1.615791',
            'lng'=>'34.178298',
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('regions')->insert([
            'name' => "Mbeya",
            'lat' => '-8.913689',
            'lng'=>'33.453821',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Morogoro",
            'lat' => '-6.772566',
            'lng'=>'37.658611',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Mtwara",
            'lat' => '-10.304941',
            'lng'=>'40.186569',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Mwanza",
            'lat' => '-2.504778',
            'lng'=>'32.920638',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Pwani",
            'lat' => '-7.384860',
            'lng'=>'38.984214',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Ruvuma",
            'lat' => '-10.800758',
            'lng'=>'35.983998',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Kibaha",
            'lat' => '-6.780023',
            'lng'=>'38.990479',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Rukwa",
            'lat' => '-8.050328',
            'lng'=>'31.397720',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Shinyanga",
            'lat' => '-3.674064',
            'lng'=>'33.420355',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Simiyu",
            'lat' => '-3.046087',
            'lng'=>'34.154206',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Singida",
            'lat' => '-5.411672',
            'lng'=>'34.619211',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Songwe",
            'lat' => '-8.807689',
            'lng'=>'32.815453',
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('regions')->insert([
            'name' => "Tabora",
            'lat' => '-5.035325',
            'lng'=>'32.812701',
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('regions')->insert([
            'name' => "Tanga",
            'lat' => '-5.089957',
            'lng'=>'39.094102',
            'created_at' => \Carbon\Carbon::now()
        ]);
        
    }
}
