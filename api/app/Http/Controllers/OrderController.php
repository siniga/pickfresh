<?php

namespace App\Http\Controllers;

use App\Events\Dashboard\PublishNotifications;
use App\Events\OrderEvent;
use App\Exports\SalesExport;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Traits\CustomerTrait;
use App\Traits\DashboardTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
class OrderController extends Controller
{

    use DashboardTrait;
    use CustomerTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orders  = Order::get();
        return $orders;
    }

    public function exportOrders(){
        return Excel::download(new SalesExport, 'sales.xlsx');
    }

    public function getOrdersBycampaignId($cid){
        //TODO: user lazy loading instead of join
        $orders = Order::with('products')->join('customers','customers.id','orders.customer_id')
        ->join('users','users.id','customers.user_id')
        ->select('orders.id','orders.device_time','orders.order_no','orders.status','orders.location','customers.name as customer','customers.phone as customer_phone','users.name as user')
        ->where('orders.campaign_id',$cid)
        ->orderBy('orders.id','desc')
        ->get();
        return $orders;
    }

    //use order status and campaign id to get orders
    public function getOrdersByStatus($cid, $status){
        //TODO: user lazy loading instead of join
        $orders = Order::with('products')->join('customers','customers.id','orders.customer_id')
        ->join('users','users.id','customers.user_id')
        ->select('orders.id','orders.device_time',
        'orders.order_no','orders.status',
        'orders.location','orders.delivery_option',
        'orders.day_option','orders.time_option',
        'customers.name as customer',
        'customers.phone as customer_phone', 'customers.user_input_address',
        'users.name as user')
        ->where('orders.campaign_id',$cid)
        ->where('orders.status',$status)
        ->orderBy('orders.id','desc')
        ->limit(10)
        ->orderBy("orders.id", "desc")
        ->get();

        
        $orders->map(function($val, $key){
            $val->time_ago = Carbon::parse($val->device_time)->diffForhumans();
    
        });

        return $orders;
    }

    public function getUserOrders($id){
        $orders =  Order::join('customers','customers.id','orders.customer_id')
        ->select('orders.id','orders.order_no','orders.location','orders.created_date','customers.name as customer_name')
        ->where('orders.user_id', $id)
        ->orderBy('orders.id','desc')
        ->get();

            
        $orders->map(function ($val) {
            $val->serverId = $val->id;
            $val->carts = $this->getOrderProducts($val->id);
       });

        $response = [
            "orders" => $orders
        ];

        return response($response, 200);
    }

    public function getUserOrdersByDate($id, $date){

        $orders =  Order::join('customers','customers.id','orders.customer_id')
            ->select('orders.id','orders.order_no','orders.location','orders.created_date','customers.name as customer_name')
            ->where('orders.user_id', $id)
            ->where('orders.created_date', $date)
            ->orderBy('orders.id','desc')
            ->get();

        $orders->map(function ($val) {
            $val->serverId = $val->id;
            $val->carts = $this->getOrderProducts($val->id);
        });

         $response = [
            "orders" => $orders,
         ];

         return response($response, 200);
    }

    private function getOrderProducts($orderId){

        $orderProducts = DB::table("order_products")
            ->join('products','products.id','order_products.product_id')
            ->join('units','units.id','order_products.unit_id')
            ->join('skus','skus.id','order_products.sku_id')
            ->select('products.name as name','order_products.total_amount as totalAmount',
                    'order_products.total_quantity as totalQuantity', 'order_products.unit_id',
                    'order_products.sku_id')
            ->where("order_id", $orderId)
            ->get();

        $orderProducts->map(function ($val) {
                $val->sku = $this->getSku($val->sku_id);
                $val->unit = $this->getUnit($val->unit_id);
        });

         return $orderProducts;
    }

    private function getSku($id){
        $sku = DB::table('skus')
           ->where('id', $id)
           ->select('id','name')
           ->first();

        return $sku;
    }

    private function getUnit($id){
        $unit = DB::table('units')
           ->where('id', $id)
           ->select('id','name')
           ->first();

        return $unit;
    }

    public function updateOrderStatus($id, $status){
         $order = Order::findOrFail($id);
         $order->status = $status;

         if($order->save()){
            return response(["order"=> $order], 201);
         }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        if(!Order::where('order_no', '=', $request->order_no)->exists()){
            
            $order  = new Order;
            $order->device_time = $request->device_time;
            $order->order_no = $request->order_no;
            $order->status  = $request->status;
            $order->created_date = $request->created_date;
            $order->location = $request->location;
            $order->lng = $request->lng;
            $order->lat = $request->lat;
            $order->user_id  = $request->user_id;
            $order->customer_id = $request->customer_id;
            $order->campaign_id = $request->campaign_id;
            $order->delivery_option = $request->delivery_option;
            $order->day_option = $request->day_option;
            $order->time_option = $request->time_option;

            if($order->save()){

                
                Storage::put('data.json', $request->carts);

                // return collect($request->carts)->sum('total_amount');
                foreach (json_decode($request->carts, true) as $cart) {
                    $this->attachToProduct($order->id, $cart);
                }

                //\Log::info('Info message');
            
                //add customer stats
                $this->storeCustomerStats(1,1,$request->order_total_amount, $order->lat,$order->lng, $order->user_id, $order->customer_id, $order->campaign_id);

                //push new order to the dashboard as notification
                event(new PublishNotifications($this->getStats( $request->campaign_id, $order)));

                //push new order to dashboard
                // event(new OrderEvent($order));

                $order->customer = ['id' => $request->customer_id];
                $json = json_encode(collect($request->order_total_amount));
          
                return response(["order"=> $order], 201);

            }
        }else{

            $order = Order::where('order_no', $request->order_no)->first();
            return response(["order"=> ['order_no'=> $order],'error_msg'=>'Order no already exists'], 201);
          
        }

    }


    public function getStats( $cid, $order ) {

        $stats = $this->getStatData( $cid );
        $response = [];
        try {
            $response =  [
                'stats' => $stats,
                'notifications' => [
                    'total_new_sales' =>$stats->num_sales,
                    'total_new_customers' => $stats->num_new_customers,
                    'total_new_revenue' => $stats->revenue,
                    'total_new_customer_visited' => $stats->num_visits,
                ],
                'new_order'=>$order
            ];

        } catch ( \Throwable $th ) {
            throw $th;
        }
        return response( $response, 200 );

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    
   public function attachToProduct($oid, $cart){

    //dd($product);
    $order = Order::findOrFail($oid);
  
    //check if cart is a duplicate before adding it
    // $cartExist = DB::table("order_products")
    //     ->where('product_id', $cart["product"]["id"])
    //     ->where('order_id',  $oid)
    //     ->where('unit_id', $cart['unit']['id'])
    //     ->where('sku_id', $cart['sku']['id'])
    //     ->exists();

    //TODO:dont forget to change the values on android
    $orderProduct =  new OrderProduct;
    $orderProduct->total_quantity = $cart['total_quantity'];
    $orderProduct->total_amount  =  $cart['total_amount'];
    $orderProduct->product_id =  $cart["product_id"];
    $orderProduct->order_id = $oid;
    $orderProduct->sku_id = $cart['sku_id'];
    $orderProduct->unit_id =$cart['unit_id'];
     
    $orderProduct->save();
     
    // if(!$cartExist){
    $order->products()->syncWithoutDetaching([
        $cart["product_id"] => [
            'total_quantity' => $cart['total_quantity'], 
            'total_amount' => $cart['total_amount'],
            'sku_id' => $cart['sku_id'],
            'unit_id' => $cart['unit_id']
            ]
    ]);
    // }
    
    

  
}

}
