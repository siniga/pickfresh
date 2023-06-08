<?php

namespace App\Traits;

use App\Models\CustomerStat;
use Illuminate\Support\Facades\DB;

trait CustomerTrait
{

    public function storeCustomerStats($visit, $sale, $amount, $lat, $lng, $userId, $customerId, $campaignId)
    {

        $customer = new CustomerStat;
        $customer->num_visit = $visit;
        $customer->num_sale = $sale;
        $customer->amount = $amount;
        $customer->user_visit_lat = $lat;
        $customer->user_visit_lng = $lng;
        $customer->user_id = $userId;
        $customer->customer_id = $customerId;
        $customer->campaign_id = $campaignId;

        $customer->save();
    }
}
