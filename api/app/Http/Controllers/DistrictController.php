<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Http\Requests\StoreDistrictRequest;
use App\Http\Requests\UpdateDistrictRequest;

class DistrictController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        //
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \App\Http\Requests\StoreDistrictRequest  $request
    * @return \Illuminate\Http\Response
    */

    public function store( StoreDistrictRequest $request ) {
        //
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\District  $district
    * @return \Illuminate\Http\Response
    */

    public function show( District $district ) {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\District  $district
    * @return \Illuminate\Http\Response
    */

    public function edit( District $district ) {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \App\Http\Requests\UpdateDistrictRequest  $request
    * @param  \App\Models\District  $district
    * @return \Illuminate\Http\Response
    */

    public function update( UpdateDistrictRequest $request, District $district ) {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\District  $district
    * @return \Illuminate\Http\Response
    */

    public function destroy( District $district ) {
        //
    }

    public function insertDistrict() {

        $items = [
            //arusha
            [ 'region_id' => 1, 'name' =>'Meru' ],
            [ 'region_id'=> 1, 'name' =>'Arusha City' ],
            [ 'region_id'=> 1, 'name' =>'Arusha' ],
            [ 'region_id'=> 1, 'name' =>'Karatu' ],
            [ 'region_id'=> 1, 'name' =>'Longido' ],
            [ 'region_id'=> 1, 'name' =>'Monduli' ],
            [ 'region_id'=> 1, 'name' =>'Ngorongoro' ],

            //dar
            [ 'region_id'=> 2, 'name' =>'Kinondoni' ],
            [ 'region_id'=> 2, 'name' =>'Ilala' ],
            [ 'region_id'=> 2, 'name' =>'Temeke' ],
            [ 'region_id'=> 2, 'name' =>'Kigamboni' ],
            [ 'region_id'=> 2, 'name' =>'Ubungo' ],

            //dodoma
            [ 'region_id' => 3, 'name' =>'Bahi' ],
            [ 'region_id' => 3, 'name' =>'Chamwino' ],
            [ 'region_id' => 3, 'name' =>'Chemba' ],
            [ 'region_id' => 3, 'name' =>'Dodoma' ],
            [ 'region_id' => 3, 'name' =>'Kondoa' ],
            [ 'region_id' => 3, 'name' =>'Kongwa' ],
            [ 'region_id' => 3, 'name' =>'Mpwapwa' ],

            //geita
            [ 'region_id' => 4, 'name' =>'Bukombe' ],
            [ 'region_id' => 4, 'name' =>'Chato' ],
            [ 'region_id' => 4, 'name' =>'Geita Town' ],
            [ 'region_id' => 4, 'name' =>'Mbogwe' ],
            [ 'region_id' => 4, 'name' =>'Nyang’hwale' ],

            //Iringa
            [ 'region_id' => 5, 'name' =>'Iringa District Council' ],
            [ 'region_id' => 5, 'name' =>'Iringa Municipal Council' ],
            [ 'region_id' => 5, 'name' =>'Kilolo' ],
            [ 'region_id' => 5, 'name' =>'Mafinga Town' ],
            [ 'region_id' => 5, 'name' =>'Mufindi' ],

            //
            //Kagera
            [ 'region_id' => 6, 'name' =>'Biharamulo' ],
            [ 'region_id' => 6, 'name' =>'Bukoba District Council' ],
            [ 'region_id' => 6, 'name' =>'Bukoba Municipal Council' ],
            [ 'region_id' => 6, 'name' =>'Karagwe' ],
            [ 'region_id' => 6, 'name' =>'Kyerwa' ],
            [ 'region_id' => 6, 'name' =>'Missenyi' ],
            [ 'region_id' => 6, 'name' =>'Muleba' ],
            [ 'region_id' => 6, 'name' =>'Ngara' ],

            //Katavi
            [ 'region_id' => 7, 'name' =>'Mlele' ],
            [ 'region_id' => 7, 'name' =>'Mpanda District Council' ],
            [ 'region_id' => 7, 'name' =>'Mpanda Town Council' ],

            //kigoma
            [ 'region_id' => 8, 'name' =>'Buhigwe' ],
            [ 'region_id' => 8, 'name' =>'Kakonko' ],
            [ 'region_id' => 8, 'name' =>'Kasulu District Council' ],
            [ 'region_id' => 8, 'name' =>'Kasulu Town Council' ],
            [ 'region_id' => 8, 'name' =>'Kibondo' ],
            [ 'region_id' => 8, 'name' =>'Kigoma District Council' ],
            [ 'region_id' => 8, 'name' =>'Kigoma-Ujiji Municipal Council' ],
            [ 'region_id' => 8, 'name' =>'Uvinza' ],

            //killimanjaro
            [ 'region_id' => 9, 'name' =>'Hai' ],
            [ 'region_id' => 9, 'name' =>'Moshi District Council' ],
            [ 'region_id' => 9, 'name' =>'Moshi Municipal Council' ],
            [ 'region_id' => 9, 'name' =>'Mwanga' ],
            [ 'region_id' => 9, 'name' =>'Rombo' ],
            [ 'region_id' => 9, 'name' =>'Same' ],
            [ 'region_id' => 9, 'name' =>'Siha' ],

            //Lindi
            [ 'region_id' => 10, 'name' =>'Kilwa' ],
            [ 'region_id' => 10, 'name' =>'Lindi District Council' ],
            [ 'region_id' => 10, 'name' =>'Lindi Municipal Council' ],
            [ 'region_id' => 10, 'name' =>'Liwale' ],
            [ 'region_id' => 10, 'name' =>'Nachingwea' ],
            [ 'region_id' => 10, 'name' =>'Ruangwa' ],

            //Manyara
            [ 'region_id' => 11, 'name' =>'Babati Town Council' ],
            [ 'region_id' => 11, 'name' =>'Babati District Council' ],
            [ 'region_id' => 11, 'name' =>'Hanang' ],
            [ 'region_id' => 11, 'name' =>'Mbulu' ],
            [ 'region_id' => 11, 'name' =>'Simanjiro' ],
            [ 'region_id' => 11, 'name' =>'Ruangwa' ],

            //Mara
            [ 'region_id' => 12, 'name' =>'Bunda' ],
            [ 'region_id' => 12, 'name' =>'Butiama' ],
            [ 'region_id' => 12, 'name' =>'Musoma District Council' ],
            [ 'region_id' => 12, 'name' =>'Musoma Municipal Council' ],
            [ 'region_id' => 12, 'name' =>'Rorya' ],
            [ 'region_id' => 12, 'name' =>'Serengeti' ],
            [ 'region_id' => 12, 'name' =>'Tarime' ],

            //Mbeya
            [ 'region_id' => 13, 'name' =>'Busokelo' ],
            [ 'region_id' => 13, 'name' =>'Chunya' ],
            [ 'region_id' => 13, 'name' =>'Kyela' ],
            [ 'region_id' => 13, 'name' =>'Mbarali' ],
            [ 'region_id' => 13, 'name' =>'Mbeya City Council' ],
            [ 'region_id' => 13, 'name' =>'Mbeya District Council' ],
            [ 'region_id' => 13, 'name' =>'Rungwe' ],

            //Morogoro
            [ 'region_id' => 14, 'name' =>'Gairo' ],
            [ 'region_id' => 14, 'name' =>'Kilombero' ],
            [ 'region_id' => 14, 'name' =>'Kilosa' ],
            [ 'region_id' => 14, 'name' =>'Morogoro District Council' ],
            [ 'region_id' => 14, 'name' =>'Morogoro Municipal Council' ],
            [ 'region_id' => 14, 'name' =>'Mvomero' ],
            [ 'region_id' => 14, 'name' =>'Ulanga' ],
            [ 'region_id' => 14, 'name' =>'Malinyi' ],
            [ 'region_id' => 14, 'name' =>'Ifakara' ],

            //Mtwara
            [ 'region_id' => 15, 'name' =>'Masasi District Council' ],
            [ 'region_id' => 15, 'name' =>'Masasi Town Council' ],
            [ 'region_id' => 15, 'name' =>'Mtwara District Council' ],
            [ 'region_id' => 15, 'name' =>'Mtwara Municipal Council' ],
            [ 'region_id' => 15, 'name' =>'Nanyumbu' ],
            [ 'region_id' => 15, 'name' =>'Newala' ],
            [ 'region_id' => 15, 'name' =>'Tandahimba' ],

            //Mwanza
            [ 'region_id' => 16, 'name' =>'Ilemela ' ],
            [ 'region_id' => 16, 'name' =>'Kwimba' ],
            [ 'region_id' => 16, 'name' =>'Magu' ],
            [ 'region_id' => 16, 'name' =>'Misungwi' ],
            [ 'region_id' => 16, 'name' =>'Nyamagana' ],
            [ 'region_id' => 16, 'name' =>'Sengerema' ],
            [ 'region_id' => 16, 'name' =>'Ukerewe' ],

            //Pwani
            [ 'region_id' => 17, 'name' =>'Bagamoyo' ],
            [ 'region_id' => 17, 'name' =>'Kibaha District Council' ],
            [ 'region_id' => 17, 'name' =>'Kibaha Town Council' ],
            [ 'region_id' => 17, 'name' =>'Kisarawe' ],
            [ 'region_id' => 17, 'name' =>'Mafia' ],
            [ 'region_id' => 17, 'name' =>'Mkurangae' ],
            [ 'region_id' => 17, 'name' =>'Rufiji' ],

            //Ruvuma
            [ 'region_id' => 18, 'name' =>'Mbinga' ],
            [ 'region_id' => 18, 'name' =>'Songea District Council' ],
            [ 'region_id' => 18, 'name' =>'Songea Municipal Council' ],
            [ 'region_id' => 18, 'name' =>'Tunduru' ],
            [ 'region_id' => 18, 'name' =>'Namtumbo' ],

            //Rukwa
            [ 'region_id' => 20, 'name' =>'Kalambo' ],
            [ 'region_id' => 20, 'name' =>'Nkasi' ],
            [ 'region_id' => 20, 'name' =>'Sumbawanga' ],

            //Shinynaga
            [ 'region_id' => 21, 'name' =>'Kahama Town Council' ],
            [ 'region_id' => 21, 'name' =>'Kahama District Council' ],
            [ 'region_id' => 21, 'name' =>'Kishapu' ],
            [ 'region_id' => 21, 'name' =>'Shinyanga District Council' ],
            [ 'region_id' => 21, 'name' =>'Shinyanga Municipal Council' ],

            //Simiyu
            [ 'region_id' => 22, 'name' =>'Bariadi' ],
            [ 'region_id' => 22, 'name' =>'Busega' ],
            [ 'region_id' => 22, 'name' =>'Kishapu' ],
            [ 'region_id' => 22, 'name' =>'Itilima' ],
            [ 'region_id' => 22, 'name' =>'Maswa' ],
            [ 'region_id' => 22, 'name' =>'Meatu' ],

            //Singida
            [ 'region_id' => 23, 'name' =>'Ikungi' ],
            [ 'region_id' => 23, 'name' =>'Iramba' ],
            [ 'region_id' => 23, 'name' =>'Manyoni' ],
            [ 'region_id' => 23, 'name' =>'Mkalama' ],
            [ 'region_id' => 23, 'name' =>'Singida District Council' ],
            [ 'region_id' => 23, 'name' =>'Singida Municipal Council' ],

            //Songwe
            [ 'region_id' => 24, 'name' =>'Ileje' ],
            [ 'region_id' => 24, 'name' =>'Mbozi' ],
            [ 'region_id' => 24, 'name' =>'Momba' ],
            [ 'region_id' => 24, 'name' =>'Songwe District' ],

             //Tabora
             [ 'region_id' => 25, 'name' =>'Igunga' ],
             [ 'region_id' => 25, 'name' =>'Kaliua' ],
             [ 'region_id' => 25, 'name' =>'Nzega' ],
             [ 'region_id' => 25, 'name' =>'Sikonge' ],
             [ 'region_id' => 25, 'name' =>'Tabora Municipal Council' ],
             [ 'region_id' => 25, 'name' =>'Urambo' ],
             [ 'region_id' => 25, 'name' =>'Uyui' ],
 
             //Tanga
             [ 'region_id' => 26, 'name' =>'Handeni District Council' ],
             [ 'region_id' => 26, 'name' =>'Handeni Town Council' ],
             [ 'region_id' => 26, 'name' =>'Kilindi' ],
             [ 'region_id' => 26, 'name' =>'Korogwe Town Council' ],
             [ 'region_id' => 26, 'name' =>'Korogwe District Council' ],
             [ 'region_id' => 26, 'name' =>'Muheza' ],
             [ 'region_id' => 26, 'name' =>'Mkinga' ],
             [ 'region_id' => 26, 'name' =>'Pangani' ],
             [ 'region_id' => 26, 'name' =>'Tanga City Council' ],

            //Njombe
            [ 'region_id' => 27, 'name' =>'Ludewa' ],
            [ 'region_id' => 27, 'name' =>'Makambako' ],
            [ 'region_id' => 27, 'name' =>'Makete' ],
            [ 'region_id' => 27, 'name' =>'Njombe District Council' ],
            [ 'region_id' => 27, 'name' =>'Njombe Town Council' ],
            [ 'region_id' => 27, 'name' =>'Wanging’ombe' ],

            //Pemba North
            [ 'region_id' => 28, 'name' =>'Wete' ],
            [ 'region_id' => 28, 'name' =>'Micheweni' ],

            //Pemba South
            [ 'region_id' => 29, 'name' =>'Chakechake' ],
            [ 'region_id' => 29, 'name' =>'Mkoani' ],


            //Zanzibar north
            [ 'region_id' => 30, 'name' =>' Kaskazini A' ],
            [ 'region_id' => 30, 'name' =>' Kaskazini B' ],

            //zanzibar south and central
            [ 'region_id' => 31, 'name' =>'Kati' ],
            [ 'region_id' => 31, 'name' =>'Kusini' ],

            //zanzibar west
            [ 'region_id' => 32, 'name' =>'Magharibi' ],
            [ 'region_id' => 32, 'name' =>'Mjini District Council' ],

        ];

        for ( $i = 0; $i < count( $items )-1;
        $i++ ) {

            $district = new District;
            $district->region_id = $items[ $i ][ 'region_id' ];
            $district->name = $items[ $i ][ 'name' ];
            $district->save();
        }

    }
}
