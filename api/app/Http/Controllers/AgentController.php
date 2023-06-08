<?php

namespace App\Http\Controllers;

use App\Events\Dashboard\PublishNotifications;
use App\Models\User;
use App\Traits\CustomerTrait;
use App\Traits\DashboardTrait;
use App\Traits\OrderTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller {
    //
    use DashboardTrait;
    use OrderTrait;
    use CustomerTrait;

    public function getAgentsStatsByCampaignId( $cid ) {
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
  


        $agents->map(function ($agent) {
            $agent->num_customers = $this->getCustomersByAgentId($agent->id);
            $agent->product_stats = $this->getOrdersById($agent->id, null);
        });

        return $agents;
    }

    public function getCustomersByAgentId( $uid ) {
        $numCustomers = DB::table('customers')
        ->where( 'user_id', $uid )
        ->get();

 
        
        return count($numCustomers);
    }

    public function getAgentsByLocation($cid, $rid){

        $agents = User::join('team_users','users.id','team_users.user_id')
        ->join('teams','teams.id','team_users.team_id')
        ->join('regions','regions.id','teams.region_id')
        ->select('users.id','users.name','regions.lat','regions.lng')
        ->where('teams.campaign_id', $cid)
        ->where('teams.region_id', $rid)
        ->get();
        return $agents;
    }

    public function markVisitation(Request $request){
        $this->storeCustomerStats(1,0,0, $request->lat,$request->lng, $request->user_id, $request->customer_id, $request->campaign_id);
       
        event(new PublishNotifications($this->getStats( $request->campaign_id)));
                
        return response(["customer"=>['id'=>$request->customer_id]], 201);
    }

    public function markVisitationWithQrCode(){
    
    }

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
            throw $th;
        }
        return response( $response, 200 );

    }
}


