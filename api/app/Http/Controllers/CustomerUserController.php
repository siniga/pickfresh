<?php

namespace App\Http\Controllers;

use App\Models\CustomerUser;
use App\Http\Requests\StoreCustomerUserRequest;
use App\Http\Requests\UpdateCustomerUserRequest;

class CustomerUserController extends Controller
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
     * @param  \App\Http\Requests\StoreCustomerUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerUserRequest $request)
    {
        //
        $visit = new CustomerUser;
        $visit->user_id = $request->user_id;
        $visit->customer_id = $request->customer_id;
        $visit->save();

        return $visit;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerUser  $customerUser
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerUser $customerUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerUser  $customerUser
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerUser $customerUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerUserRequest  $request
     * @param  \App\Models\CustomerUser  $customerUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerUserRequest $request, CustomerUser $customerUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerUser  $customerUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerUser $customerUser)
    {
        //
    }
}
