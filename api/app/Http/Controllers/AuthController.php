<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Business;


class AuthController extends Controller
{
    //

    private $userId;

    public function register(Request $request){
        $fields = $request->validate([
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string',
            'business_name' => 'required:string',
            'business_type_id'=>'required',
            'name' => 'required:string',
            'phone' => 'required:string',
        ]);



        $user = User::create([
            'email'=>$fields['email'],
            'password'=>bcrypt($fields['password']),
            'name' => $fields['name'],
            'phone' => $fields['phone']
        ]);

        $this->userId = $user->id;
        $this->attachUserToRole($user->id);

        $this->createBusiness($fields['business_name'], $fields['business_type_id']);


        $token = $user->createToken('adengToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' =>$token
        ];

        return response($response, 201);
    }

    public function createBusiness($businessName, $businessTypeId){
        $business = new Business;
        $business->name = $businessName;
        $business->business_type_id = $businessTypeId;

        if($business->save()){
            $this->createDefaultCampaign($business->id);
        }
    }

    public function createDefaultCampaign($businessId){
        $campaign = new Campaign;
        $campaign->name = "Sales Campaign";
        $campaign->campaign_type_id = 1;
        $campaign->business_id = $businessId;
        if($campaign->save()){
            $this->createDefaultTeam($campaign->id);
        }
    }

    public function createDefaultTeam($campaignId){
        $team = new Team;
        $team->name = "Admin Team";
        $team->campaign_id = $campaignId;
        $team->region_id = 2;

        if($team->save()){
            $this->attachTeamToUser($team->id);
        }

    }

    public function updateUserDetails(Request $request){
        $fields = $request->validate([
            'fullname'=>'required',
            'phone'=>'required|string|unique:users,phone',
            'url'=> 'required',
        ]);

        $user = User::findOrFail(auth()->user()->id);
        $user->fullname = $request->fullname;
        $user->phone = $request->phone;
        $user->url = $request->url;

        if($user->save()){
            return $response = [
                'user' => $user
            ];
        }

    }

    public function login(Request $request){

        //if email is set allow user to login with email
        //otherwise allow user to login with phone number
        if(isset($request->email)){
            $fields = $request->validate([
                'email'=>'required|string',
                'password'=>'required|string'
            ]);
    
            //check email
            $user = User::where('email', $fields['email'])
                        ->first();
        }else{
            $fields = $request->validate([
                'phone'=>'required|string',
                'password'=>'required|string'
            ]);
    
            //check email
            $user = User::where('phone', $fields['phone'])
                        ->first();

        }     

        //check password
        if(!$user || !Hash::check($fields['password'], $user->password)){

            return response([
                'message' => 'Invalid credentials',
            ], 401);
        }
      

        $token = $user->createToken('itargetToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' =>$token
        ];

        return response($response, 201);
    }

    public function logout(User $user){

        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    public function attachTeamToUser($tid){
        $user = User::findOrFail($this->userId);
        $user->teams()->syncWithoutDetaching($tid);
    }
    public function attachUserToRole($uid){

        $user = User::findOrFail($uid);
      
        //default role for the first user to register is admin
        $user->roles()->syncWithoutDetaching(2);
      
    }
}
