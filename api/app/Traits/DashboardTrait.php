<?php

namespace App\Traits;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;

trait DashboardTrait
{
    use OrderTrait;

    public function getStatData($cid)
    {
        $stats = DB::table('customer_stats')
            ->select(
                DB::raw('(SUM(num_visit)) as num_visits'),
                DB::raw('(SUM(num_sale)) as num_sales'),
                DB::raw('SUM(amount) as revenue'),
            )
            ->where('campaign_id', $cid)
            ->groupBy('num_visit')
            ->get();

        if (count($stats) > 0) {
            $stats->map(function ($val) use ($cid) {
                $val->num_new_customers = $this->getNumOfCustomers($cid);

            });

            return $stats[0];
        }

        return $stats;

    }

    public function getNumOfCustomers($cid)
    {
        //get all customers regardless of campaign
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        $thisMonthData = DB::table('customers')
        ->where('campaign_id', $cid)
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
        ->get();

        
        $lastMonthData = DB::table('customers')
        ->where('campaign_id', $cid)
        ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
        ->get();
       
        return ['this_month_customers'=>count($thisMonthData),'last_month_customers'=>count($lastMonthData) ];

        
    }

    //query for visits vs num of sales
    public function getMonthlyVisits($cid)
    {
        
        $monthlyVisits = DB::table('customer_stats')->select(
            DB::raw('(SUM(num_visit)) as num_visit'),
            DB::raw('(SUM(num_sale)) as num_sale'),
            DB::raw('MONTHNAME(created_at) as month_name'),
            DB::raw("DATE_FORMAT(created_at, '%d-%b') as day")
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month_name','day')
            ->orderBy('created_at', 'asc')
            ->where('campaign_id', $cid)
            ->get()
            ->toArray();

        $monthlyData = [];

        foreach ($monthlyVisits as $key => $visit) {
            array_push($monthlyData, [$visit->day, (int) $visit->num_visit, (int) $visit->num_sale]);
        }

        array_unshift($monthlyData, ['Month', 'Visits', 'Effective sale']);
        return $monthlyData;
    }

    public function getItemSoldTrends($cid, $uid)
    {

        $monthlyItemSold = DB::table('products')
            ->join('order_products', 'products.id', 'order_products.product_id')
            ->join('orders', 'orders.id', 'order_products.order_id')
            ->select(
                DB::raw('(SUM(order_products.total_quantity)) as quantity_sold'),
                DB::raw('MONTHNAME(orders.created_at) as month_name'),
                DB::raw("DATE_FORMAT(orders.created_at, '%d-%b') as day"),
                'products.name'
            )
            ->whereYear('orders.created_at', date('Y'))
            ->groupBy('month_name', 'day', 'products.name')
            ->orderBy('orders.created_at', 'asc')
            ->where('orders.campaign_id', $cid)
            ->orWhere('orders.user_id', $uid)
            ->get();

            $brands = $monthlyItemSold->unique('name')->pluck('name');
            $data = [['Day', ...$brands->toArray()]];

            $monthlyItemSold->groupBy('day')
            ->each(function($dayGroup) use (&$data, $brands) {
                $row = array($dayGroup->first()->day);
                $brands->each(function($brand) use ($dayGroup, &$row) {
                    $item = $dayGroup->where('name', $brand)->first();
                    array_push($row, $item ? $item->quantity_sold : 0);
                });
                array_push($data, $row);
            });

        return $data;
    }

    public function getTopProducts($cid, $regionId)
    {

        $monthlySales = DB::table('order_products')
            ->join('products', 'products.id', 'order_products.product_id')
            ->join('orders', 'orders.id', 'order_products.order_id')
            ->join('customers','customers.id','orders.customer_id')
            ->join('districts','districts.id','customers.district_id')  
            ->join('regions','regions.id','districts.region_id')  
            ->orderBy('order_products.total_quantity', 'desc')
            ->select('products.id','products.name', DB::raw('sum(order_products.total_amount) as total_amount'), DB::raw('COUNT(order_products.total_quantity) as total_quantity'), 'products.img')
            ->distinct()
            ->groupBy('products.id','products.name','products.img')
            ->where('orders.campaign_id', $cid)
            ->where('regions.id', $regionId)
            ->limit(5)
            ->get();

        return $monthlySales->sortByDesc(function($data){
             return $data->total_quantity;
         })->values();
    }

    public function getTopProductsByDistricts($cid, $regionId)
    {

        //get products then group then into districts
        $productsByDist = DB::table("orders")
        ->join('order_products','orders.id','order_products.order_id')
        ->join('products','products.id','order_products.product_id')
        ->join('customers','customers.id','orders.customer_id')
        ->join('districts','districts.id','customers.district_id')
        ->join('regions','regions.id','districts.region_id')  
        ->select(
            DB::raw('(SUM(order_products.total_quantity)) as total_quantity'),
            'districts.name as district'
        )->groupBy('district')
        ->where('orders.campaign_id', $cid)
        ->where('regions.id', $regionId)
        ->get();


        $products = [];

        foreach ($productsByDist as $key => $product) {
            array_push($products, [$product->district, (int) $product->total_quantity]);
        }

        array_unshift($products, ['District', 'total_quantity']);

        return $products;

    }

    public function getTopSalesMen($cid){

        $topSalesmen = DB::table('customer_stats')
            ->join('users', 'users.id', 'customer_stats.user_id')
            //  ->join('orders','users.id','orders.user_id')
            ->selectRaw(
                'users.id,
                users.name,
            SUM(customer_stats.num_visit) as num_visit,
            SUM(customer_stats.num_sale) as num_sale'

            )->groupBy('users.id','users.name')
            ->where('customer_stats.campaign_id', $cid)
            ->limit(5)
            ->get();
      

        $topSalesmen->map(function ($val) {
            $val->product_stats = $this->getOrdersById($val->id, null);
        });

        return $topSalesmen;
    }

    public function getTopCustomers($cid){
        $topCustomers = DB::table('customer_stats')
        ->join('customers','customers.id','customer_stats.customer_id')
        //  ->join('orders','users.id','orders.user_id')
        ->selectRaw(
            'customers.id,
            customers.name,
        SUM(customer_stats.num_visit) as num_visit,
        SUM(customer_stats.num_sale) as num_sale'

        )->groupBy('customers.id','customers.name')
        ->where('customer_stats.campaign_id', $cid)
        ->limit(5)
        ->get();
  

    $topCustomers->map(function ($val) {
        $val->product_stats = $this->getOrdersById(null, $val->id);
    });


        return $topCustomers;
    }

    public function getLocations($cid, $uid){
        $locations =  DB::table('customer_stats')
        ->join('customers','customers.id','customer_stats.customer_id')
        ->join('customer_types','customer_types.id','customers.customer_type_id')
        ->where('customer_stats.campaign_id', $cid)
        ->orWhere('customer_stats.user_id', $uid)
        ->select('customers.location as name',
        'customer_types.alias as customer_type','customer_stats.user_visit_lat',
        'customer_stats.user_visit_lng','customers.lat','customers.lng')
        ->get();

        $features = [];

        foreach ($locations as $location) {
            $locationFeatures = 
                [
                    "type" => "Feature",
                    "properties" => [
                        "title" => $location->name,
                        // "description" => $location,
                        "customer_type" => $location->customer_type,
                        // "phone" => $location->phone,
                        // "location" => $location->location,
                        // "device_time" => $location->device_time
                    ],
                    "geometry" => [
                        "coordinates" => [(double) $location->lng, (double)$location->lat],
                        "type" => "Point",
                    ]

                ];

            array_push($features, $locationFeatures);
    
        }
    
      
        return ["features"=> $features, "type"=> "FeatureCollection"];
    }
    public function getSalesMenStats($cid){

        $agents = DB::table('customer_stats')
        ->join('users', 'users.id', 'customer_stats.user_id')
        //  ->join('orders','users.id','orders.user_id')
        ->selectRaw(
            'users.id,
            users.name,
        SUM(customer_stats.num_visit) as num_visit,
        SUM(customer_stats.num_sale) as num_sale'

        )->groupBy('users.id','users.name')
        ->where('customer_stats.campaign_id', $cid)
        ->get();
  

    $agents->map(function ($val) {
        $val->product_stats = $this->getOrdersById($val->id, null);
    });

    return $agents;

      
    }

    public function getNumCustomersWithOrders($cid){

        $recentCustomers = Customer::whereHas('orders', function($query){
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        }) ->where('campaign_id', $cid)->count();

        return $recentCustomers;
    }

    public function getNumCustomervisited($cid){
        $recentCustomers = Customer::whereHas('customer_stats', function($query){
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        }) ->where('campaign_id', $cid)->get();

        return $recentCustomers->count();
    }

    public function getNumRepeatCustomers($cid){
        $frequentCustomers = Customer::has('orders', '>=', 5)
        ->where('campaign_id', $cid)->count();
        return $frequentCustomers;
    }
    public function getTotalNumCustomers($cid){
        $totalCustomers = Customer::where('created_at', '>=', Carbon::now()
        ->subDays(30))
        ->where('campaign_id', $cid)
        ->count();

        return $totalCustomers;
    }

    public function getNumCustomersWithoutOrders($cid){
        $customersWithoutOrders = Customer::doesntHave('orders')->where('campaign_id', $cid)->get();
        return $customersWithoutOrders->count();
    }

    public function getNumCustomerWIthSku($cid){
        $customerWithSku = Customer::has('orders.products.skus')->where('campaign_id', $cid)->count();
        return $customerWithSku;
    }

    public function getNumAgentsOverMil($cid){
        $agentsOverMillion = DB::table('users')
                ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->join('roles', 'user_roles.role_id', '=', 'roles.id')
                ->join('customer_stats','users.id','customer_stats.user_id')
                ->where('roles.name', 'ambassador')
                ->selectRaw('SUM(customer_stats.amount) as amount,users.id')
                ->groupBy('users.id')
                ->where('amount', '>', 1000000)
                ->where('customer_stats.created_at', '>=', Carbon::now()->subDays(30))
                ->where('customer_stats.campaign_id',$cid)
                ->get();

        return $agentsOverMillion->count();
    }

    public function getTotalNumAgents($cid){
        $agentsOverMillion = DB::table('users')
        ->join('team_users','users.id','team_users.user_id')
        ->join('teams','teams.id','team_users.user_id')
        ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
        ->join('roles', 'user_roles.role_id', '=', 'roles.id')
        ->where('roles.name', 'ambassador')
        ->where('teams.campaign_id',$cid)
        ->get();

        return $agentsOverMillion->count();
    }
 
    public function getSalesByCustomerTypes($cid, $regionId){

        $customerTypes = DB::table("orders")
        ->join('order_products','orders.id','order_products.order_id')
        ->join('products','products.id','order_products.product_id')
        ->join('customers','customers.id','orders.customer_id')
        ->join('customer_types','customer_types.id','customers.customer_type_id')
        ->join('districts','districts.id','customers.district_id')
        ->join('regions','regions.id','districts.region_id')
        ->select(
            DB::raw('(SUM(order_products.total_quantity)) as total_quantity'),
            'customer_types.name as customter_type'
        )->groupBy('customter_type')
        ->where('regions.id', $regionId)
        ->where('orders.campaign_id', $cid)
        ->get();

        
        $salesByCustTypes = [];

        foreach ($customerTypes as $key => $type) {
            array_push($salesByCustTypes, [$type->customter_type, (int) $type->total_quantity]);
        }

        array_unshift($salesByCustTypes, ['Customer Type', 'Quantity']);
        return $salesByCustTypes;
    }

   
}