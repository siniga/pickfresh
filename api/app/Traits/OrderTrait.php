<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait OrderTrait
{

    public function getOrdersById($uid, $cid){
        $orders = DB::table('orders')
        ->join('order_products','orders.id','order_products.order_id')
        ->selectRaw(
            'orders.user_id,
            COUNT(order_products.total_quantity)  as total_qnty_sold,
            SUM(order_products.total_amount) as total_amount_sold'
            
        )->groupBy('orders.user_id')
        ->where('orders.user_id',$uid)
        ->orWhere('orders.customer_id', $cid)
        ->first();

        return $orders;
    }

    
}
