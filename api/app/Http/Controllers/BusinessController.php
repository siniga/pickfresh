<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Http\Requests\StoreBusinessRequest;
use App\Http\Requests\UpdateBusinessRequest;
use Illuminate\Support\Facades\Auth; 

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getUserBusiness(){

        //get business that this user belongs to
        $user = Auth::user();

        //get busi
        $business = Business::join('teams','businesses.id','teams.business_id')
            ->join('team_users','teams.id','team_users.team_id')
            ->select('businesses.id', 'businesses.name')
            ->where('team_users.user_id', $user->id)
            ->first();

        return response(["business"=> $business], 200);
    }

    public function getBusinessProducts($businessId){
        $businessProducts = Business::
        where('businesses.id',$businessId)
        ->join('categories','businesses.id','categories.business_id')
        ->join('products','categories.id','products.category_id')
        ->join('product_units','products.id','product_units.product_id')
        ->join('units','units.id','product_units.unit_id')
        ->select('products.id','products.name','products.cost','products.price','products.img','products.stock','units.name as unit')
        ->get();

        return response(["products"=> $businessProducts], 200);
    }

    public function getBusinessCampaigns($bid){
        $business = Business::with('campaigns')->where('id', $bid)->first();

        return $business;
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
     * @param  \App\Http\Requests\StoreBusinessRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBusinessRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBusinessRequest  $request
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBusinessRequest $request, Business $business)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business)
    {
        //
    }
}
