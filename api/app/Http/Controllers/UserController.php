<?php

namespace App\Http\Controllers;

use App\Models\CustomerType;
use App\Models\Region;
use App\Models\Team;
use App\Models\TeamUser;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class UserController extends Controller
{

    //
    public function index(){
        return User::select('id','name','phone','email','created_date')->with('roles')->get();
    }


    public function getUserCampaign($uid){
        $userCampaign = User::join('team_users','users.id','team_users.user_id')
        ->join('teams','teams.id','team_users.team_id')
        ->join('campaigns','campaigns.id','teams.campaign_id')
        ->select('campaigns.id','campaigns.name')
        ->where('users.id', $uid)
        ->first();

        return response(["campaign"=>$userCampaign],200);
    }

    public function getUsersByCampaignId($cid){
        $users = User::with('roles')
        ->join('team_users','users.id','team_users.user_id')
        ->join('teams','teams.id','team_users.team_id')
        ->select('users.id','users.name','users.phone','users.email','users.created_at as time_ago','teams.name as team')
        ->where('teams.campaign_id', $cid)
        ->orderBy('users.id','desc')
        ->get();

        $users->map(function($val, $key){
            $val->time_ago = Carbon::parse($val->time_ago)->diffForhumans();
    
        });

        return response($users, 200);
    }

    public function getUserCustomers($uid){
        $userCustomers = User::join('customers','users.id','customers.user_id')
        ->select('customers.id','customers.name','customers.phone','customers.location','customers.user_input_address as address','customers.customer_type_id','customers.created_date as createdDate','customers.device_time as deviceTime','customers.id as serverId','customers.lat','customers.lng', 'customers.district_id as districtId','customers.campaign_id as campaignId', 'users.id as user_id')
        ->where('users.id', $uid)
        ->get();

        $userCustomers->map(function ($val) {
            $val->user =  $this->getUser($val->user_id);
            $val->customerType = $this->getCustomerType($val->id);
        });

        return response(["customers"=>$userCustomers], 200);
    }
    
    public function getUser($uid){
        $user = User::where('id', $uid)->first();
        return $user;
    }
    
        public function getCustomerType($cid){
        $user = CustomerType::join('customers','customer_types.id','customers.customer_type_id')
        ->select('customer_types.id','customer_types.name')
        ->where('customers.id', $cid)->first();
        return $user;
    }

    public function getUserBusiness($uid){
        $user = User::where( 'users.id', $uid)
        ->select( 'users.name', 'users.phone', 'users.email','users.password', 'businesses.id as business_id', 'businesses.name as business' )
        ->join( 'team_users', 'users.id', 'team_users.user_id' )
        ->join( 'teams', 'teams.id', 'team_users.team_id' )
        ->join('campaigns','campaigns.id','teams.campaign_id')
        ->join( 'businesses', 'businesses.id', 'campaigns.business_id' )
        ->first();

        return $user;
    }

    public function getUserStats($uid){
        $userStats = DB::table('customer_stats')
            ->join('users', 'users.id', 'customer_stats.user_id')
            ->join('customers', 'customers.id', 'customer_stats.customer_id')
            ->join('orders', 'customers.id', 'orders.customer_id')
            ->join('order_products', 'orders.id', 'order_products.order_id')
            ->selectRaw(
                'users.id,
            users.name,
            SUM(customer_stats.num_visit) as num_visit,
            SUM(customer_stats.num_sale) as num_sale,
            COUNT(order_products.total_quantity)  as total_qnty_sold,
            SUM(order_products.total_amount) as total_amount_sold'

            )
            ->whereYear('customer_stats.created_at', date('Y'))
            ->groupBy('users.id', 'users.name')
            ->orderBy('customer_stats.num_sale', 'asc')
            ->where('customer_stats.user_id', $uid)
            ->first();

        return $userStats;
    }

    public function searchAmbassador(Request $request){

        $search = $request->input('search');

        $user = User::query()
            ->join('teams','teams.id','users.team_id')
            ->select('users.name','users.email','users.phone', 'teams.name as team')
            ->where('users.name', 'LIKE', "%{$search}%")
            ->orWhere('users.phone', 'LIKE', "%{$search}%")
            ->get();

        return $user;
    }

    public function getAllDeletedAmbassadors(){
        $users = User::withTrashed()->get();
        return response($users, 200);
    }

    public function getAmbassaorNames(){
        $users = User::select('id','name')->get();

        return response($users, 200);
    }
    public function getAmbassadors($tid){

        $users = User::join('user_roles','users.id','user_roles.user_id') 
            ->join('roles','roles.id','user_roles.role_id')
            ->join('teams','teams.id','users.team_id')
            ->where('user_roles.role_id', 4)
            ->where('teams.id', $tid)
            ->select('users.id','users.name','users.color','users.phone','roles.name as role','roles.id as role_id','teams.name as team')
            ->orderBy('users.id','desc')
            ->get();

        return response($users, 200);
    }

    public function getManagers(){

        $users = User::join('user_roles','users.id','user_roles.user_id') 
            ->join('roles','roles.id','user_roles.role_id')
            ->where('user_roles.role_id', 2)
            ->orWhere('user_roles.role_id',3)
            // ->where('user_roles.role_id', 2)
            // ->where('user_roles.role_id', 3)
            ->select('users.*','roles.name as role')
            ->orderBy('users.id','desc')
            ->get();

        $users->map(function($val, $key){
            $val->time_ago = Carbon::parse($val->created_at)->diffForhumans();
    
        });

        return response($users, 200);
    }

    public function verifyPhone($phone){
   
        if(User::where('phone', '=', $phone)->exists()){

            $response = [
                'phone_verification'=> [ 'msg' => "phone exist",'flag' => 1]
            ];
            
            return response($response, 200);
        }

        $response = [
            'phone_verification'=> [ 'msg' => "phone doesnt exist",'flag' => 0]
        ];

        return response($response, 200);
    }

    public function show($id){

    }

    public function storeAmbassador(Request $request){
        $randomNum =  rand(0, 900000);

        //if edit user flag is true edit user esle create
        if($request->edit){
           $user = User::findOrFail($request->id);
           $user->phone = $request->phone;
           $user->name  = $request->name;

           $this->attachUserToRole($user->id, $request->role_id);

           if($user->save()){
               return response(["success"=>$user], 201);
           }
        }

        if(User::where('phone', '=', $request->phone)->exists()){
           return response(["error"=>"Phone exist, try a different one!"], 409);
        }

        $fields = $request->validate([
            'name'=>'required|string',
            'phone'=>'required|string',
        ]);

        $user = User::create([
            'password'=>bcrypt($randomNum),
            'name'=>$fields['name'],
            'phone'=>$fields['phone'],
            'color'=>$request->color,
            'created_date'=>$request->created_date,
            'branch_id' => $request->branch_id
        ]);

        $this->attachUserToRole($user->id, $request->role_id);

        return response($user, 200);

    }
    
    //store user as customer
    public function storeUserCustomer(Request $request){
        $fields = $request->validate([
            'name'=>'required|string',
            'phone'=>'required|string|unique:users',
            // 'email'=>'required|string|unique:users',
        ]);


           //if edit user flag is true edit user else create
        if($request->edit){
            $user = User::findOrFail($request->id);
            $user->phone = $request->phone;
            $user->name  = $request->name;
            $user->email = $request->email;
 
            $this->attachUserToRole($user->id, $request->role_id);
 
            if($user->save()){
                return response(["success"=>$user], 201);
            }
        }

        if(User::where('phone', '=', $request->phone)->exists()){
            return response(["error"=>"Phone exist, try a different one!"], 409);
         }

         if(User::where('email', '=', $request->email)->exists()){
            return response(["error"=>"Email exist, try a different one!"], 409);
         }
        //generate random password
        //TODO:send this password to users email/sms for invitation
        // $randomNum =  rand(0, 900000);
        
        $user = User::create([
            'email'=>$request['email'] ? $request['email']: generateRandomString().'@wetrack.com',
            'password'=>bcrypt(123456),
            'name'=>$fields['name'],
            'phone'=>$fields['phone'],
            'created_date' => Carbon::now()->format('Y-m-d'),
        ]);

        $this->attachUserToRole($user->id, $request->role_id);

        //check if regions is sent from user,
        //then check if region exist in a team table
        //if exist assign user to the team that correspond to that region
        //else assign user to the team provided by admin
        $teamExist = Team::where('region_Id', '=', $request->region_id)
        ->where('campaign_Id', '=', $request->campaign_id)->exists();
        if($teamExist){
            $team = Team::where('region_Id', '=', $request->region_id)
        ->where('campaign_Id', '=', $request->campaign_id)->first();
            $this->attachUserToTeam($user->id, $team->id);
              
        }else{

            //if region doesnt exist in a team table
            //query regions tan;e using id provided by user
            //use region returned from regions table as team name
            $region = Region::where('id', '=', $request->region_id)->first();

           $team  = new Team;
           $team->name = $region->name;
           $team->region_id = $region->id;
           $team->campaign_id = $request->campaign_id;

           if($team->save()){
            $this->attachUserToRole($user->id, $request->role_id);
             $this->attachUserToTeam($user->id, $team->id);
           }

        }
        return response($user, 200);
    }

    //store user as an agent
    public function store(Request $request){
          
        $fields = $request->validate([
            'name'=>'required|string',
            'phone'=>'required|string|unique:users',
            // 'email'=>'required|string|unique:users',
        ]);


           //if edit user flag is true edit user esle create
        if($request->edit){
            $user = User::findOrFail($request->id);
            $user->phone = $request->phone;
            $user->name  = $request->name;
            $user->email = $request->email;
 
            $this->attachUserToRole($user->id, $request->role_id);
 
            if($user->save()){
                return response(["success"=>$user], 201);
            }
        }

        if(User::where('phone', '=', $request->phone)->exists()){
            return response(["error"=>"Phone exist, try a different one!"], 409);
         }

         if(User::where('email', '=', $request->email)->exists()){
            return response(["error"=>"Email exist, try a different one!"], 409);
         }
        //generate random password
        //TODO:send this password to users email/sms for invitation
        // $randomNum =  rand(0, 900000);
        
        $user = User::create([
            'email'=>$request['email'] ? $request['email']: generateRandomString().'@wetrack.com',
            'password'=>bcrypt(123456),
            'name'=>$fields['name'],
            'phone'=>$fields['phone'],
            'created_date' => Carbon::now()->format('Y-m-d'),
        ]);

        $this->attachUserToRole($user->id, $request->role_id);
        $this->attachUserToTeam($user->id, $request->team_id);

        return response($user, 200);
    }
    public function destroy($uid)
    {

        $user = User::findOrfail($uid);
        $userRole = $user->roles;
        $userTeam = $user->teams;

        if(count($userRole) > 0)
        $user->roles()->detach($userRole[0]->id);

        if(count($userTeam) > 0)
        $user->teams()->detach($userTeam[0]->id);

        if($user->delete()){
 
             return response($user, 200);
        }
    }
  

    public function attachUserToRole($uid, $rid){

        $user = User::findOrFail($uid);
      
        $user->roles()->syncWithoutDetaching($rid);
      
    }

    public function attachUserToTeam($uid, $tid){

        $user = User::findOrFail($uid);
      
        $user->teams()->syncWithoutDetaching($tid);
      
    }

    public function sendSms(){

        $client = new Client();
        
        $headers = [
            'Authorization' => 'Basic Um91dGVQcm86emV5MTIzMzIxUVE=',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        
        $data = [
            'from' => 'NEXTSMS',
            'to' => '255768632087',
            'text' => 'Karibu we track, tumia hii data kulogin kwa app yetu',
        ];
        
        $response = $client->post('https://messaging-service.co.tz/api/sms/v1/test/text/single', ['headers' => $headers, 'json' => $data]);

       return $response;
    }
}
