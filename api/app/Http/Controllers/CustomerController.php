<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index(){
        $customers = Customer::join('users','users.id','customers.user_id')
        ->select('customers.name','customers.phone','customers.device_time','customers.location','users.name as user')->get();
        return $customers;
    }

    public function getCustomerByUserid($uid){
        $customer = Customer::where('user_id', $uid)->first();
        return $customer;
    }

    public function getCustomersByCompaignId($cid){
        $customers = Customer::join('users','users.id','customers.user_id')
        ->select('customers.name','customers.phone','customers.device_time','customers.location','customers.user_input_address','users.name as user')
        ->where('customers.campaign_id', $cid)
        ->get();

        return $customers;
    }
    public function export() 
    {
        // return Excel::download(new CustomersExport, 'Accounts.xlsx');
        return (new CustomersExport)->download('Accounts.xlsx');
    }

    public function getCustomers(Request $request)
    {
        //

        $whereClouse ='';
        $whereAggregate = '';
        $signs = '=';

        if($request->flag ==  0){
            $whereClouse = 'customers.id';
            $signs = '!=';
            $whereAggregate =  0;
        }

        if($request->flag ==  1){
            $whereClouse = 'customers.gender';
            $signs = '=';
            $whereAggregate =  $request->flagType;
        }

        if($request->flag  ==  2){
            $whereClouse = 'customers.account_id';
            $signs = '=';
            $whereAggregate =  $request->flagType;
        }

        if($request->flag  ==  3){
            $whereClouse = 'users.id';
            $signs = '=';
            $whereAggregate =  $request->flagType;
        }

        $customers = Customer::join('users','users.id','customers.user_id')
                ->join('accounts','accounts.id','customers.account_id')
                ->select('customers.*', 'users.name as user','accounts.name as account')
                ->where($whereClouse,$signs, $whereAggregate)
                ->orderBy('customers.id','desc')
                ->get();

        return response($customers, 200);
    }

    public function getCustomerLocationByBusinessId($bid){

        $custLocations = Customer::join('customer_types','customer_types.id','customers.customer_type_id')
        ->select('customers.name','customers.phone','customers.device_time','customers.location','customers.lat','customers.lng','customer_types.alias as customer_type')
        ->get();

        $features = [];

        foreach ($custLocations as $location) {
            $locationFeatures = 
                [
                    "type" => "Feature",
                    "properties" => [
                        "title" => $location->name,
                        // "description" => $location,
                        "customer_type" => $location->customer_type,
                        "phone" => $location->phone,
                        "location" => $location->location,
                        "device_time" => $location->device_time
                    ],
                    "geometry" => [
                        "coordinates" => [(double) $location->lng, (double)$location->lat],
                        "type" => "Point"
                    ]

                ];

            array_push($features, $locationFeatures);
    
        }
    
      
        return ["features"=> $features, "type"=> "FeatureCollection"];
    }
    public function getCustomerLocations(Request $request){
       
        $customers = Customer::join('users','users.id','customers.user_id')
            ->select('customers.id','customers.name','customers.lat','customers.lng','customers.amount_deposited','customers.device_time','customers.phone','users.color','users.name as user')
            ->whereBetween('customers.created_date',[$request->startDate, $request->endDate])
            ->get();

        $result = $customers->map(function($item, $key) {
            return [
                "id"=>$item->id,
                "position"=>[$item->lat, $item->lng],
                "name"=>$item->name,
                "color" =>$item->color,
                "amount_deposited"=>$item->amount_deposited,
                "phone"=>$item->phone,
                "device_time"=>$item->device_time,
                "added_by"=>$item->user
            ];
          });



        return response($result, 201);
    }
    public function getTeamsCustomers(){
        $teams = Customer::join('users','users.id','customers.user_id')
            ->join('branches','branches.id','users.branch_id')
            ->join('teams','teams.id','branches.team_id')
            ->selectRaw('teams.id, teams.name, count(customers.id) as stat, teams.lat, teams.lng')
            ->groupBy('teams.id','teams.name','teams.lat','teams.lng')
            ->orderBy('stat','desc')
            // ->whereBetween('customers.created_date',[$request->startDate, $request->endDate])
            ->get();

        return response($teams, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */

     public function storeCustomerWithOrder(Request $request){
        return $this->storeOrder($request);
     }
    public function store(Request $request)
    {
        //
        if(!Customer::where('phone', '=', $request->phone)->exists()){
          
            $customer = new Customer;
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->device_time = $request->device_time;
            $customer->lat = $request->lat;
            $customer->lng = $request->lng;
            $customer->location = $request->location;
            $customer->user_input_address = $request->user_input_address;
            $customer->customer_type_id = $request->customer_type_id;
            $customer->user_id = $request->user_id;
            $customer->created_date = $request->created_date;
            $customer->district_id = $request->district_id;
            $customer->campaign_id = $request->campaign_id;

            if($customer->save()){
                $customer->campaign = ['id', $request->campaign_id];
                
                $response = [
                    'customer' => $customer,
                ];

                return response($response, 201);
            }

        }else{
            
            $customer = Customer::where('phone', $request->phone)->first();

            //update customer
            $customer->district_id = $request->district_id;
            $customer->user_input_address = $request->user_input_address;
            $customer->save();

            $response = [
                    'customer' => $customer,
                ];

            return response($response, 201);
        }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
