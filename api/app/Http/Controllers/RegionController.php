<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Region;
use App\Http\Requests\StoreRegionRequest;
use App\Http\Requests\UpdateRegionRequest;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $regions = Region::get();

      $regionList= $regions->map(function ($region) {
            $region->value = $region->name;
            $region->label = $region->name;

            return ["id"=>$region->id,"value"=>$region->name, "label"=>$region->name,'lat'=>$region->lat,"lng"=>$region->lng];
        });
        return $regionList;
    }

    public function getRegionDistricts()
    {
        //
        $regions = Region::with('districts')->get();

      
        return $regions;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRegionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit(Region $region)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRegionRequest  $request
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegionRequest $request, Region $region)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
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
            [ 'region_id' => 9, 'name' =>'Buhigwe' ],
            [ 'region_id' => 9, 'name' =>'Kakonko' ],
            [ 'region_id' => 9, 'name' =>'Kasulu District Council' ],
            [ 'region_id' => 9, 'name' =>'Kasulu Town Council' ],
            [ 'region_id' => 9, 'name' =>'Kibondo' ],
            [ 'region_id' => 9, 'name' =>'Kigoma District Council' ],
            [ 'region_id' => 9, 'name' =>'Kigoma-Ujiji Municipal Council' ],
            [ 'region_id' => 9, 'name' =>'Uvinza' ],

            //killimanjaro
            [ 'region_id' => 10, 'name' =>'Hai' ],
            [ 'region_id' => 10, 'name' =>'Moshi District Council' ],
            [ 'region_id' => 10, 'name' =>'Moshi Municipal Council' ],
            [ 'region_id' => 10, 'name' =>'Mwanga' ],
            [ 'region_id' => 10, 'name' =>'Rombo' ],
            [ 'region_id' => 10, 'name' =>'Same' ],
            [ 'region_id' => 10, 'name' =>'Siha' ],

            //Lindi
            [ 'region_id' => 11, 'name' =>'Kilwa' ],
            [ 'region_id' => 11, 'name' =>'Lindi District Council' ],
            [ 'region_id' => 11, 'name' =>'Lindi Municipal Council' ],
            [ 'region_id' => 11, 'name' =>'Liwale' ],
            [ 'region_id' => 11, 'name' =>'Nachingwea' ],
            [ 'region_id' => 11, 'name' =>'Ruangwa' ],

            //Manyara
            [ 'region_id' => 12, 'name' =>'Babati Town Council' ],
            [ 'region_id' => 12, 'name' =>'Babati District Council' ],
            [ 'region_id' => 12, 'name' =>'Hanang' ],
            [ 'region_id' => 12, 'name' =>'Mbulu' ],
            [ 'region_id' => 12, 'name' =>'Simanjiro' ],
            [ 'region_id' => 12, 'name' =>'Ruangwa' ],

            //Mara
            [ 'region_id' => 13, 'name' =>'Bunda' ],
            [ 'region_id' => 13, 'name' =>'Butiama' ],
            [ 'region_id' => 13, 'name' =>'Musoma District Council' ],
            [ 'region_id' => 13, 'name' =>'Musoma Municipal Council' ],
            [ 'region_id' => 13, 'name' =>'Rorya' ],
            [ 'region_id' => 13, 'name' =>'Serengeti' ],
            [ 'region_id' => 13, 'name' =>'Tarime' ],

            //Mbeya
            [ 'region_id' => 14, 'name' =>'Busokelo' ],
            [ 'region_id' => 14, 'name' =>'Chunya' ],
            [ 'region_id' => 14, 'name' =>'Kyela' ],
            [ 'region_id' => 14, 'name' =>'Mbarali' ],
            [ 'region_id' => 14, 'name' =>'Mbeya City Council' ],
            [ 'region_id' => 14, 'name' =>'Mbeya District Council' ],
            [ 'region_id' => 14, 'name' =>'Rungwe' ],

            //Morogoro
            [ 'region_id' => 15, 'name' =>'Gairo' ],
            [ 'region_id' => 15, 'name' =>'Kilombero' ],
            [ 'region_id' => 15, 'name' =>'Kilosa' ],
            [ 'region_id' => 15, 'name' =>'Morogoro District Council' ],
            [ 'region_id' => 15, 'name' =>'Morogoro Municipal Council' ],
            [ 'region_id' => 15, 'name' =>'Mvomero' ],
            [ 'region_id' => 15, 'name' =>'Ulanga' ],
            [ 'region_id' => 15, 'name' =>'Malinyi' ],
            [ 'region_id' => 15, 'name' =>'Ifakara' ],

            //Mtwara
            [ 'region_id' => 16, 'name' =>'Masasi District Council' ],
            [ 'region_id' => 16, 'name' =>'Masasi Town Council' ],
            [ 'region_id' => 16, 'name' =>'Mtwara District Council' ],
            [ 'region_id' => 16, 'name' =>'Mtwara Municipal Council' ],
            [ 'region_id' => 16, 'name' =>'Nanyumbu' ],
            [ 'region_id' => 16, 'name' =>'Newala' ],
            [ 'region_id' => 16, 'name' =>'Tandahimba' ],

            //Mwanza
            [ 'region_id' => 17, 'name' =>'Ilemela ' ],
            [ 'region_id' => 17, 'name' =>'Kwimba' ],
            [ 'region_id' => 17, 'name' =>'Magu' ],
            [ 'region_id' => 17, 'name' =>'Misungwi' ],
            [ 'region_id' => 17, 'name' =>'Nyamagana' ],
            [ 'region_id' => 17, 'name' =>'Sengerema' ],
            [ 'region_id' => 17, 'name' =>'Ukerewe' ],

            //Njombe
            [ 'region_id' => 18, 'name' =>'Ludewa' ],
            [ 'region_id' => 18, 'name' =>'Makambako' ],
            [ 'region_id' => 18, 'name' =>'Makete' ],
            [ 'region_id' => 18, 'name' =>'Njombe District Council' ],
            [ 'region_id' => 18, 'name' =>'Njombe Town Council' ],
            [ 'region_id' => 18, 'name' =>'Wanging’ombe' ],

            //Pemba North
            [ 'region_id' => 19, 'name' =>'Wete' ],
            [ 'region_id' => 19, 'name' =>'Micheweni' ],

            //Pemba South
            [ 'region_id' => 20, 'name' =>'Chakechake' ],
            [ 'region_id' => 20, 'name' =>'Mkoani' ],

            //Pwani
            [ 'region_id' => 21, 'name' =>'Bagamoyo' ],
            [ 'region_id' => 21, 'name' =>'Kibaha District Council' ],
            [ 'region_id' => 21, 'name' =>'Kibaha Town Council' ],
            [ 'region_id' => 21, 'name' =>'Kisarawe' ],
            [ 'region_id' => 21, 'name' =>'Mafia' ],
            [ 'region_id' => 21, 'name' =>'Mkurangae' ],
            [ 'region_id' => 21, 'name' =>'Rufiji' ],

            //Rukwa
            [ 'region_id' => 22, 'name' =>'Kalambo' ],
            [ 'region_id' => 22, 'name' =>'Nkasi' ],
            [ 'region_id' => 22, 'name' =>'Sumbawanga' ],

            //Ruvuma
            [ 'region_id' => 23, 'name' =>'Mbinga' ],
            [ 'region_id' => 23, 'name' =>'Songea District Council' ],
            [ 'region_id' => 23, 'name' =>'Songea Municipal Council' ],
            [ 'region_id' => 23, 'name' =>'Tunduru' ],
            [ 'region_id' => 23, 'name' =>'Namtumbo' ],

            //Shinynaga
            [ 'region_id' => 24, 'name' =>'Kahama Town Council' ],
            [ 'region_id' => 24, 'name' =>'Kahama District Council' ],
            [ 'region_id' => 24, 'name' =>'Kishapu' ],
            [ 'region_id' => 24, 'name' =>'Shinyanga District Council' ],
            [ 'region_id' => 24, 'name' =>'Shinyanga Municipal Council' ],

            //Simiyu
            [ 'region_id' => 25, 'name' =>'Bariadi' ],
            [ 'region_id' => 25, 'name' =>'Busega' ],
            [ 'region_id' => 25, 'name' =>'Kishapu' ],
            [ 'region_id' => 25, 'name' =>'Itilima' ],
            [ 'region_id' => 25, 'name' =>'Maswa' ],
            [ 'region_id' => 25, 'name' =>'Meatu' ],

            //Singida
            [ 'region_id' => 26, 'name' =>'Ikungi' ],
            [ 'region_id' => 26, 'name' =>'Iramba' ],
            [ 'region_id' => 26, 'name' =>'Manyoni' ],
            [ 'region_id' => 26, 'name' =>'Mkalama' ],
            [ 'region_id' => 26, 'name' =>'Singida District Council' ],
            [ 'region_id' => 26, 'name' =>'Singida Municipal Council' ],

            //Tabora
            [ 'region_id' => 27, 'name' =>'Igunga' ],
            [ 'region_id' => 27, 'name' =>'Kaliua' ],
            [ 'region_id' => 27, 'name' =>'Nzega' ],
            [ 'region_id' => 27, 'name' =>'Sikonge' ],
            [ 'region_id' => 27, 'name' =>'Tabora Municipal Council' ],
            [ 'region_id' => 27, 'name' =>'Urambo' ],
            [ 'region_id' => 27, 'name' =>'Uyui' ],

            //Tanga
            [ 'region_id' => 28, 'name' =>'Handeni District Council' ],
            [ 'region_id' => 28, 'name' =>'Handeni Town Council' ],
            [ 'region_id' => 28, 'name' =>'Kilindi' ],
            [ 'region_id' => 28, 'name' =>'Korogwe Town Council' ],
            [ 'region_id' => 28, 'name' =>'Korogwe District Council' ],
            [ 'region_id' => 28, 'name' =>'Muheza' ],
            [ 'region_id' => 28, 'name' =>'Mkinga' ],
            [ 'region_id' => 28, 'name' =>'Pangani' ],
            [ 'region_id' => 28, 'name' =>'Tanga City Council' ],

            //Zanzibar north
            [ 'region_id' => 29, 'name' =>' Kaskazini A' ],
            [ 'region_id' => 29, 'name' =>' Kaskazini B' ],

            //zanzibar south and central
            [ 'region_id' => 30, 'name' =>'Kati' ],
            [ 'region_id' => 30, 'name' =>'Kusini' ],

            //zanzibar west
            [ 'region_id' => 31, 'name' =>'Magharibi' ],
            [ 'region_id' => 31, 'name' =>'Mjini District Council' ],

            //Songwe
            [ 'region_id' => 35, 'name' =>'Ileje' ],
            [ 'region_id' => 35, 'name' =>'Mbozi' ],
            [ 'region_id' => 35, 'name' =>'Momba' ],
            [ 'region_id' => 35, 'name' =>'Songwe District' ],

        ];

        // for ( $i = 0; $i < count( $items )-1;
        // $i++ ) {

        //     $district = new District;
        //     $district->region_id = $items[$i]['region_id'];
        //     $district->name = $items[$i]['name'];
        //     $district->save();
        // }
 

    }
}
