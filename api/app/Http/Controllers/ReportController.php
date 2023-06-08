<?php

namespace App\Http\Controllers;

use App\Traits\DashboardTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller {
    //

    use DashboardTrait;

    //pass campaign id
    public function getStats( $cid ) {

        $stats = $this->getStatData( $cid );
        $response = [];

      
        try {

                $response =  [
                    'stats' => $stats,
                    'notifications' => [
                        'total_new_sales' =>$stats->num_sales,
                        'total_new_customers' => $stats->num_new_customers,
                        'total_new_revenue' => $stats->revenue,
                        'total_new_customer_visited' => $stats->num_visits
                    ]
                ];

        } catch ( \Throwable $th ) {
            $response =  [
                'stats' => ['num_visits'=>0, "num_sales"=> 0, "revenue"=>0],
                'notifications' => [
                    'total_new_sales' => 0,
                    'total_new_customers' => 0,
                    'total_new_revenue' => 0,
                    'total_new_customer_visited' => 0
                ]
            ];
        }
        return response( $response, 200 );

    }

    public function getTrends( $cid, $uid ) {
        $response = [
            'monthly_visits' => $this->getMonthlyVisits( $cid ),
            'top_sales_men' => $this->getTopSalesMen( $cid ),
            'top_customers' =>$this->getTopCustomers( $cid ),
            'item_sold_trends' => $this->getItemSoldTrends( $cid, $uid )
        ];

        return response( $response, 200 );
    }

    public function getNoticeBoardContent($cid){
        $response = [
            'num_new_customers_with_orders'=> $this->getNumCustomersWithOrders($cid),
            'num_new_customers_without_orders' => $this->getNumCustomersWithoutOrders($cid),
            'num_new_total_customers'=> $this->getTotalNumCustomers($cid),
            'customer_with_sku' => $this->getNumCustomerWIthSku($cid),
            'total_num_agents' =>$this->getTotalNumAgents($cid),
            'num_agents_sold_over_mil'=> $this->getNumAgentsOverMil($cid),
            'num_customers_visited' =>$this->getNumCustomervisited($cid),
            'num_repeat_customers' => $this->getNumRepeatCustomers($cid)
        ];

        return response($response, 200);
    }

    public function getDataByRegion($cid, $regionId){

        $response = [
            'top_products'=>  $this->getTopProducts( $cid, $regionId),
            'sales_by_customer_types'=> $this->getSalesByCustomerTypes($cid, $regionId),
            'top_products_by_districts' =>$this->getTopProductsByDistricts( $cid, $regionId )
        ];

        return response($response, 200);
    }

    public function getVisitedLocations($cid, $uid){
        $response = [
            'customer_visited_locations'=> $this->getLocations($cid,$uid),
            'sales_men_stats'=>$this->getSalesMenStats($cid),
        ];

        return response($response, 200);
    }




}
